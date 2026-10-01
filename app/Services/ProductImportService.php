<?php

namespace App\Services;

use App\Exports\Reports\Products\ProductImportTemplateExport;
use App\Imports\Products\ProductImport;

use App\Models\Setting;
use App\Models\Branch;
use App\Models\Discount;
use App\Models\DocumentSequence;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\Unit;

use App\Models\Company;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Facades\Excel;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;


use Throwable;

class ProductImportService
{
    /*
    |--------------------------------------------------------------------------
    | Import Columns
    |--------------------------------------------------------------------------
    |
    | Product codes are deliberately excluded because they are generated
    | from the company's product document sequence.
    |
    */

    protected array $columns = [
        'name',
        'sku',
        'barcode',
        'qr_code',
        'description',
        'brand',
        'manufacturer',
        'category',
        'unit',
        'discount',
        'cost_price',
        'selling_price',
        'track_stock',
        'minimum_stock',
        'maximum_stock',
        'opening_stock',
        'weight',
        'expiry_date',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | Human-readable Column Labels
    |--------------------------------------------------------------------------
    */

    protected array $columnLabels = [
        'name' => 'Name',
        'sku' => 'SKU',
        'barcode' => 'Barcode',
        'qr_code' => 'QR Code',
        'description' => 'Description',
        'brand' => 'Brand',
        'manufacturer' => 'Manufacturer',
        'category' => 'Category',
        'unit' => 'Unit',
        'discount' => 'Discount',
        'cost_price' => 'Cost Price',
        'selling_price' => 'Selling Price',
        'track_stock' => 'Track Inventory',
        'minimum_stock' => 'Minimum Stock',
        'maximum_stock' => 'Maximum Stock',
        'opening_stock' => 'Opening Stock',
        'weight' => 'Weight',
        'expiry_date' => 'Expiry Date',
        'status' => 'Status',
    ];


    /*
    |--------------------------------------------------------------------------
    | Activity Logger
    |--------------------------------------------------------------------------
    */

    protected ActivityLogger $activityLogger;
    protected BusinessProfileService $businessProfileService;


    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */
    public function __construct(
        ActivityLogger $activityLogger,
        BusinessProfileService $businessProfileService
    ) {
        $this->activityLogger =
            $activityLogger;

        $this->businessProfileService =
            $businessProfileService;
    }


    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    */

   /**
     * Download Excel import template.
     */
    public function downloadExcelTemplate(
        Company $company
    ) {

        $headings =
            $this->importHeadingsForCompany(
                $company
            );


        return Excel::download(

            new ProductImportTemplateExport(
                $headings
            ),

            'products-import-template.xlsx'

        );
    }


    /**
     * Download CSV import template.
     */
    public function downloadCsvTemplate(
        Company $company
    ) {

        $headings =
            $this->importHeadingsForCompany(
                $company
            );


        return Excel::download(

            new ProductImportTemplateExport(
                $headings
            ),

            'products-import-template.csv',

            ExcelFormat::CSV

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Preview
    |--------------------------------------------------------------------------
    */

    /**
     * Preview an import file without writing to the database.
     */
    public function preview(
        UploadedFile $file,
        int $companyId
    ): array {

    $company = Company::query()
        ->findOrFail(
            $companyId
        );

        $rows =
        $this->readFile(
            $file,
            $company
        );

        if (empty($rows)) {
            throw ValidationException::withMessages([
                'file' =>
                    'The import file does not contain any product rows.',
            ]);
        }

        $lookups = $this->buildLookups(
            $companyId
        );

        $validatedRows = [];

        $validCount = 0;
        $warningCount = 0;
        $errorCount = 0;

        $seenSkus = [];
        $seenBarcodes = [];

        foreach ($rows as $row) {

            $result =
                $this->validateRow(
                    $row,
                    $company,
                    $lookups,
                    $seenSkus,
                    $seenBarcodes
                );

            $validatedRows[] = $result;

            if ($result['status'] === 'valid') {
                $validCount++;
            }

            if ($result['status'] === 'warning') {
                $warningCount++;
                $validCount++;
            }

            if ($result['status'] === 'error') {
                $errorCount++;
            }


            /*
            |--------------------------------------------------------------------------
            | Track Uploaded SKU
            |--------------------------------------------------------------------------
            */

            if (
                !empty($result['normalized']['sku'])
                && !in_array(
                    $result['normalized']['sku'],
                    $seenSkus,
                    true
                )
            ) {
                $seenSkus[] =
                    $result['normalized']['sku'];
            }


            /*
            |--------------------------------------------------------------------------
            | Track Uploaded Barcode
            |--------------------------------------------------------------------------
            */

            if (
                !empty($result['normalized']['barcode'])
                && !in_array(
                    $result['normalized']['barcode'],
                    $seenBarcodes,
                    true
                )
            ) {
                $seenBarcodes[] =
                    $result['normalized']['barcode'];
            }
        }

        return [

            'summary' => [

                'total' =>
                    count(
                        $validatedRows
                    ),

                'valid' =>
                    $validCount,

                'warnings' =>
                    $warningCount,

                'errors' =>
                    $errorCount,

                'can_import' =>
                    $errorCount === 0,

            ],

            'columns' =>
                $this->previewColumnsForCompany(
                    $company
                ),

            'rows' =>
                $validatedRows,

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Import
    |--------------------------------------------------------------------------
    */
    /**
     * Import products from a validated spreadsheet.
     *
     * The file is parsed and validated again.
     * The preview response is never trusted as the source of truth.
     */
    public function import(
        UploadedFile $file,
        int $companyId,
        $user
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */

        $company =
            Company::query()
                ->findOrFail(
                    $companyId
                );


        /*
        |--------------------------------------------------------------------------
        | Read File
        |--------------------------------------------------------------------------
        */

        $rows =
            $this->readFile(
                $file,
                $company
            );


        if (empty($rows)) {

            throw ValidationException::withMessages([

                'file' =>
                    'The import file does not contain any product rows.',

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Import Transaction
        |--------------------------------------------------------------------------
        */

        return DB::transaction(
            function () use (
                $rows,
                $company,
                $companyId
            ) {

                /*
                |--------------------------------------------------------------------------
                | Build Company-scoped Lookups
                |--------------------------------------------------------------------------
                */

                $lookups =
                    $this->buildLookups(
                        $companyId
                    );


                $validatedRows = [];

                $seenSkus = [];

                $seenBarcodes = [];


                /*
                |--------------------------------------------------------------------------
                | Validate Every Row Again
                |--------------------------------------------------------------------------
                */

                foreach (
                    $rows as $row
                ) {

                    $result =
                        $this->validateRow(
                            $row,
                            $company,
                            $lookups,
                            $seenSkus,
                            $seenBarcodes
                        );


                    if (
                        $result['status']
                        === 'error'
                    ) {

                        throw ValidationException::withMessages([

                            "row_{$result['row']}" =>
                                implode(
                                    ' ',
                                    $result['errors']
                                ),

                        ]);

                    }


                    $validatedRows[] =
                        $result;


                    /*
                    |--------------------------------------------------------------------------
                    | Track Uploaded SKU
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !empty(
                            $result[
                                'normalized'
                            ]['sku']
                        )
                    ) {

                        $seenSkus[] =
                            $result[
                                'normalized'
                            ]['sku'];

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Track Uploaded Barcode
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !empty(
                            $result[
                                'normalized'
                            ]['barcode']
                        )
                    ) {

                        $seenBarcodes[] =
                            $result[
                                'normalized'
                            ]['barcode'];

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Product Document Sequence
                |--------------------------------------------------------------------------
                */

                $sequence =
                    DocumentSequence::query()

                        ->where(
                            'company_id',
                            $companyId
                        )

                        ->where(
                            'document_type',
                            'product'
                        )

                        ->where(
                            'status',
                            true
                        )

                        ->lockForUpdate()

                        ->first();


                if (!$sequence) {

                    throw ValidationException::withMessages([

                        'file' =>
                            'The product document sequence is not configured for this company.',

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Determine Whether Head Office Is Required
                |--------------------------------------------------------------------------
                |
                | An import containing only non-stock products does not need a
                | ProductStock record and therefore does not need Head Office.
                |
                */

                $requiresHeadOffice =
                    collect(
                        $validatedRows
                    )->contains(
                        function ($result) {

                            return (bool) (
                                $result[
                                    'normalized'
                                ]['track_stock']
                                ?? true
                            );

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | Head Office
                |--------------------------------------------------------------------------
                */

                $headOffice =
                    null;


                if ($requiresHeadOffice) {

                    $headOffice =
                        Branch::query()

                            ->where(
                                'company_id',
                                $companyId
                            )

                            ->headOffice()

                            ->first();


                    if (!$headOffice) {

                        throw ValidationException::withMessages([

                            'file' =>
                                'A Head Office branch could not be found for this company.',

                        ]);

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Import Products
                |--------------------------------------------------------------------------
                */

                $imported =
                    0;


                $products =
                    [];


                foreach (
                    $validatedRows
                    as $result
                ) {

                    $data =
                        $result[
                            'normalized'
                        ];


                    /*
                    |--------------------------------------------------------------------------
                    | Generate Product Code
                    |--------------------------------------------------------------------------
                    */

                    $productCode =
                        $sequence->formattedNumber(
                            $sequence->current_number
                        );


                    $sequence->current_number++;


                    /*
                    |--------------------------------------------------------------------------
                    | Product Data
                    |--------------------------------------------------------------------------
                    */

                    $productData = [

                        'company_id' =>
                            $companyId,

                        'product_category_id' =>
                            $data[
                                'product_category_id'
                            ],

                        'unit_id' =>
                            $data[
                                'unit_id'
                            ],

                        'discount_id' =>
                            $data[
                                'discount_id'
                            ],

                        'product_code' =>
                            $productCode,

                        'sku' =>
                            $data['sku'],

                        'barcode' =>
                            $data['barcode'],

                        'qr_code' =>
                            $data['qr_code'],

                        'name' =>
                            $data['name'],

                        'description' =>
                            $data['description'],

                        'brand' =>
                            $data['brand'],

                        'manufacturer' =>
                            $data['manufacturer'],

                        'cost_price' =>
                            $data['cost_price'],

                        'selling_price' =>
                            $data['selling_price'],

                        /*
                        |--------------------------------------------------------------------------
                        | Stock Behaviour
                        |--------------------------------------------------------------------------
                        */

                        'track_stock' =>
                            (bool) (
                                $data[
                                    'track_stock'
                                ]
                                ?? true
                            ),

                        'minimum_stock' =>
                            $data[
                                'minimum_stock'
                            ],

                        'maximum_stock' =>
                            $data[
                                'maximum_stock'
                            ],

                        /*
                        |--------------------------------------------------------------------------
                        | Product Details
                        |--------------------------------------------------------------------------
                        */

                        'weight' =>
                            $data['weight'],

                        'expiry_date' =>
                            $data[
                                'expiry_date'
                            ],

                        'status' =>
                            $data['status'],

                    ];


                    /*
                    |--------------------------------------------------------------------------
                    | Create Product
                    |--------------------------------------------------------------------------
                    */

                    $product =
                        Product::create(
                            $productData
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Head Office Opening Stock
                    |--------------------------------------------------------------------------
                    |
                    | Non-stock products deliberately have no ProductStock row.
                    |
                    */

                    if (
                        $product->tracksStock()
                    ) {

                        if (!$headOffice) {

                            throw ValidationException::withMessages([

                                'file' =>
                                    'A Head Office branch could not be found for this company.',

                            ]);

                        }


                        $openingStock =
                            max(
                                0,
                                (float) (
                                    $data[
                                        'opening_stock'
                                    ]
                                    ?? 0
                                )
                            );


                        ProductStock::create([

                            'company_id' =>
                                $companyId,

                            'branch_id' =>
                                $headOffice->id,

                            'product_id' =>
                                $product->id,

                            'quantity' =>
                                $openingStock,

                            'reserved_quantity' =>
                                0,

                            'available_quantity' =>
                                $openingStock,

                            'reorder_level' =>
                                $data[
                                    'minimum_stock'
                                ]
                                ?? 0,

                            'maximum_stock' =>
                                $data[
                                    'maximum_stock'
                                ]
                                ?? null,

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Generated Product Information
                    |--------------------------------------------------------------------------
                    */

                    $products[] = [

                        'id' =>
                            $product->id,

                        'product_code' =>
                            $productCode,

                        'name' =>
                            $product->name,

                        'sku' =>
                            $product->sku,

                        'track_stock' =>
                            $product->tracksStock(),

                    ];


                    $imported++;

                }


                /*
                |--------------------------------------------------------------------------
                | Persist Sequence
                |--------------------------------------------------------------------------
                */

                $sequence->save();


                /*
                |--------------------------------------------------------------------------
                | Activity Log
                |--------------------------------------------------------------------------
                */

                $this->activityLogger->log(

                    'Products',

                    'Imported',

                    "{$imported} product(s) imported successfully.",

                    null,

                    null,

                    [

                        'company_id' =>
                            $companyId,

                        'count' =>
                            $imported,

                        'products' =>
                            $products,

                    ]

                );


                /*
                |--------------------------------------------------------------------------
                | Response
                |--------------------------------------------------------------------------
                */

                return [

                    'imported' =>
                        $imported,

                    'products' =>
                        $products,

                ];

            }
        );
    }

    
    /**
     * Read XLSX, XLS or CSV using Maatwebsite Excel.
     *
     * Maatwebsite Excel handles the underlying spreadsheet reader.
     */
    protected function readFile(
        UploadedFile $file,
        Company $company
    ): array
    {
        try {
            $import = new class implements ToCollection {

                public Collection $rows;

                public function __construct()
                {
                    $this->rows = collect();
                }

                public function collection(Collection $collection): void
                {
                    $this->rows = $collection;
                }
            };

            /*
            |--------------------------------------------------------------------------
            | Read Uploaded File
            |--------------------------------------------------------------------------
            |
            | Maatwebsite Excel automatically detects XLSX, XLS and CSV from
            | the uploaded file.
            |
            */

            Excel::import(
                $import,
                $file
            );

            $rows = $import->rows;

            if ($rows->isEmpty()) {
                return [];
            }

            /*
            |--------------------------------------------------------------------------
            | Convert Rows To Arrays
            |--------------------------------------------------------------------------
            */

            $rows = $rows
                ->map(function ($row) {
                    if ($row instanceof Collection) {
                        return $row->toArray();
                    }

                    return (array) $row;
                })
                ->values()
                ->all();

            if (count($rows) < 2) {
                return [];
            }

            /*
            |--------------------------------------------------------------------------
            | Header
            |--------------------------------------------------------------------------
            */

            $headerRow = array_shift($rows);

            $headers = [];

            foreach ($headerRow as $column => $header) {
                $normalizedHeader = $this->normalizeHeader($header);

                if ($normalizedHeader === '') {
                    continue;
                }

                $headers[$column] = $normalizedHeader;
            }

            $this->validateHeaders(
                $headers,
                $company
            );

            /*
            |--------------------------------------------------------------------------
            | Data Rows
            |--------------------------------------------------------------------------
            */

            $result = [];

            foreach ($rows as $index => $row) {
                $excelRow = $index + 2;

                /*
                |--------------------------------------------------------------------------
                | Skip Completely Empty Rows
                |--------------------------------------------------------------------------
                */

                $hasValue = false;

                foreach ($row as $value) {
                    if (
                        $value !== null
                        && trim((string) $value) !== ''
                    ) {
                        $hasValue = true;
                        break;
                    }
                }

                if (!$hasValue) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Normalize Row
                |--------------------------------------------------------------------------
                */

                $normalized = [
                    'row' => $excelRow,
                ];

                foreach ($headers as $column => $header) {
                    $normalized[$header] =
                        array_key_exists($column, $row)
                            ? $this->cleanValue($row[$column])
                            : null;
                }

                $result[] = $normalized;
            }

            return $result;

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Log Actual Import Error
            |--------------------------------------------------------------------------
            |
            | Do not expose the raw exception to the browser, but log it so
            | we can diagnose malformed files or reader configuration issues.
            |
            */

            report($e);

            throw ValidationException::withMessages([
                'file' =>
                    'The uploaded file could not be read. Please make sure the file is a valid XLSX, XLS or CSV product import file.',
            ]);
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Header Normalization
    |--------------------------------------------------------------------------
    */

    /**
     * Normalize spreadsheet header names.
     */
    protected function normalizeHeader(
        $header
    ): string {

        $header =
            trim(
                (string) $header
            );


        /*
        |--------------------------------------------------------------------------
        | Remove UTF-8 BOM
        |--------------------------------------------------------------------------
        */

        $header =
            preg_replace(
                '/^\xEF\xBB\xBF/',
                '',
                $header
            );


        $header =
            strtolower(
                $header
            );


        $header =
            str_replace(
                [
                    ' ',
                    '-',
                ],
                '_',
                $header
            );


        $header =
            preg_replace(
                '/[^a-z0-9_]/',
                '',
                $header
            );


        /*
        |--------------------------------------------------------------------------
        | Friendly Header Aliases
        |--------------------------------------------------------------------------
        */

        return match ($header) {

            'track_inventory' =>
                'track_stock',

            default =>
                $header,

        };
    }

    /*
    |--------------------------------------------------------------------------
    | Clean Cell Value
    |--------------------------------------------------------------------------
    */

    protected function cleanValue(
        $value
    ): ?string {

        if ($value === null) {
            return null;
        }


        $value =
            trim(
                (string) $value
            );


        return $value === ''
            ? null
            : $value;
    }

    /**
     * Map an import column to its Product business-profile field.
     */
    protected function profileFieldForImportColumn(
        string $column
    ): ?string {

        return match ($column) {

            'name' =>
                'name',

            'sku' =>
                'sku',

            'barcode' =>
                'barcode',

            'qr_code' =>
                'qr_code',

            'description' =>
                'description',

            'brand' =>
                'brand',

            'manufacturer' =>
                'manufacturer',

            'category' =>
                'product_category_id',

            'unit' =>
                'unit_id',

            'discount' =>
                'discount_id',

            'cost_price' =>
                'cost_price',

            'selling_price' =>
                'selling_price',

            'minimum_stock' =>
                'minimum_stock',

            'maximum_stock' =>
                'maximum_stock',

            'opening_stock' =>
                'opening_stock',

            'weight' =>
                'weight',

            'expiry_date' =>
                'expiry_date',

            /*
            |--------------------------------------------------------------------------
            | These are not ordinary field-mode fields.
            |--------------------------------------------------------------------------
            */

            'track_stock',
            'status' =>
                null,

            default =>
                null,

        };
    }


    /**
     * Determine whether an import column is available for this company.
     */
    protected function importColumnVisible(
        Company $company,
        string $column
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | Universal Column
        |--------------------------------------------------------------------------
        */

        if ($column === 'status') {

            return true;

        }


        /*
        |--------------------------------------------------------------------------
        | Track Inventory
        |--------------------------------------------------------------------------
        */

        if ($column === 'track_stock') {

            return $this->businessProfileService
                ->productStockTrackingIsChangeable(
                    $company
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Stock Fields
        |--------------------------------------------------------------------------
        |
        | If this profile never tracks inventory and tracking cannot be changed,
        | stock columns should not appear in the spreadsheet at all.
        |
        */

        if (
            in_array(
                $column,
                [
                    'minimum_stock',
                    'maximum_stock',
                    'opening_stock',
                ],
                true
            )
            &&
            !$this->businessProfileService
                ->productTracksStockByDefault(
                    $company
                )
            &&
            !$this->businessProfileService
                ->productStockTrackingIsChangeable(
                    $company
                )
        ) {

            return false;

        }


        /*
        |--------------------------------------------------------------------------
        | Profile Field
        |--------------------------------------------------------------------------
        */

        $field =
            $this->profileFieldForImportColumn(
                $column
            );


        if ($field === null) {

            return false;

        }


        return $this->businessProfileService
            ->productFieldVisible(
                $company,
                $field
            );
    }

    /**
     * Get import columns available for this company.
     */
    protected function importColumnsForCompany(
        Company $company
    ): array {

        return array_values(
            array_filter(
                $this->columns,
                fn (string $column): bool =>
                    $this->importColumnVisible(
                        $company,
                        $column
                    )
            )
        );
    }


    /**
     * Build human-readable spreadsheet headings.
     */
    protected function importHeadingsForCompany(
        Company $company
    ): array {

        return array_map(
            fn (string $column): string =>
                $this->columnLabels[$column]
                ?? $column,
            $this->importColumnsForCompany(
                $company
            )
        );
    }

    /**
     * Determine whether an import column is required.
     */
    protected function importColumnRequired(
        Company $company,
        string $column
    ): bool {

        if (
            in_array(
                $column,
                [
                    'status',
                    'track_stock',
                ],
                true
            )
        ) {

            return false;

        }


        /*
        |--------------------------------------------------------------------------
        | Stock Fields
        |--------------------------------------------------------------------------
        |
        | If stock tracking can vary by product, stock fields cannot be globally
        | required at spreadsheet-header level.
        |
        | Their requirement is checked per row instead.
        |
        */

        if (
            in_array(
                $column,
                [
                    'minimum_stock',
                    'maximum_stock',
                    'opening_stock',
                ],
                true
            )
            &&
            $this->businessProfileService
                ->productStockTrackingIsChangeable(
                    $company
                )
        ) {

            return false;

        }


        if (
            in_array(
                $column,
                [
                    'minimum_stock',
                    'maximum_stock',
                    'opening_stock',
                ],
                true
            )
            &&
            !$this->businessProfileService
                ->productTracksStockByDefault(
                    $company
                )
        ) {

            return false;

        }


        $field =
            $this->profileFieldForImportColumn(
                $column
            );


        if ($field === null) {

            return false;

        }


        return $this->businessProfileService
            ->productFieldRequired(
                $company,
                $field
            );
    }


    /**
     * Resolve Track Inventory from an import cell.
     */
    protected function trackStockValue(
        $value,
        bool $default
    ): ?bool {

        if (
            $value === null
            ||
            trim(
                (string) $value
            ) === ''
        ) {

            return $default;

        }


        $value =
            strtolower(
                trim(
                    (string) $value
                )
            );


        if (
            in_array(
                $value,
                [
                    '1',
                    'true',
                    'yes',
                    'y',
                    'on',
                    'track',
                    'tracked',
                ],
                true
            )
        ) {

            return true;

        }


        if (
            in_array(
                $value,
                [
                    '0',
                    'false',
                    'no',
                    'n',
                    'off',
                    'do not track',
                    'not tracked',
                ],
                true
            )
        ) {

            return false;

        }


        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Headers
    |--------------------------------------------------------------------------
    */

    protected function validateHeaders(
        array $headers,
        Company $company
    ): void {

        $required = [];


        foreach (
            $this->columns as $column
        ) {

            if (
                !$this->importColumnVisible(
                    $company,
                    $column
                )
            ) {

                continue;

            }


            if (
                !$this->importColumnRequired(
                    $company,
                    $column
                )
            ) {

                continue;

            }


            $required[] =
                $column;

        }


        $missing = [];


        foreach (
            $required as $column
        ) {

            if (
                !in_array(
                    $column,
                    $headers,
                    true
                )
            ) {

                $missing[] =
                    $this->columnLabels[$column]
                    ?? $column;

            }

        }


        if (!empty($missing)) {

            throw ValidationException::withMessages([

                'file' =>
                    'The import file is missing required columns: '
                    . implode(
                        ', ',
                        $missing
                    )
                    . '.',

            ]);

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Lookups
    |--------------------------------------------------------------------------
    */
    /**
     * Build company-scoped relationship lookups.
     */  
    protected function buildLookups(
        int $companyId
    ): array {

        return [

            /*
            |--------------------------------------------------------------------------
            | Product Categories
            |--------------------------------------------------------------------------
            */

            'categories' =>
                ProductCategory::query()
                    ->where(
                        'company_id',
                        $companyId
                    )
                    ->get()
                    ->keyBy(
                        fn ($item) =>
                            $this->lookupKey(
                                $item->name
                            )
                    ),

            /*
            |--------------------------------------------------------------------------
            | Units
            |--------------------------------------------------------------------------
            */

            'units' =>
                Unit::query()
                    ->where(
                        'company_id',
                        $companyId
                    )
                    ->get()
                    ->keyBy(
                        fn ($item) =>
                            $this->lookupKey(
                                $item->name
                            )
                    ),

            /*
            |--------------------------------------------------------------------------
            | Discounts
            |--------------------------------------------------------------------------
            */

            'discounts' =>
                Discount::query()
                    ->where(
                        'company_id',
                        $companyId
                    )
                    ->get()
                    ->keyBy(
                        fn ($item) =>
                            $this->lookupKey(
                                $item->name
                            )
                    ),
        ];
    }



    /*
    |--------------------------------------------------------------------------
    | Lookup Key
    |--------------------------------------------------------------------------
    */

    protected function lookupKey(
        $value
    ): string {

        return mb_strtolower(
            trim(
                (string) $value
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Row Validation
    |--------------------------------------------------------------------------
    */

   /**
     * Validate and normalize a single import row.
     */
    protected function validateRow(
        array $row,
        Company $company,
        array $lookups,
        array &$seenSkus,
        array &$seenBarcodes
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Validation State
        |--------------------------------------------------------------------------
        */

        $errors = [];
        $warnings = [];


        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */

        $companyId =
            $company->id;


        /*
        |--------------------------------------------------------------------------
        | Product Capabilities
        |--------------------------------------------------------------------------
        */

        $fieldVisible =
            fn (string $field): bool =>
                $this->businessProfileService
                    ->productFieldVisible(
                        $company,
                        $field
                    );


        $fieldRequired =
            fn (string $field): bool =>
                $this->businessProfileService
                    ->productFieldRequired(
                        $company,
                        $field
                    );


        /*
        |--------------------------------------------------------------------------
        | Stock Behaviour
        |--------------------------------------------------------------------------
        */

        $trackStockDefault =
            $this->businessProfileService
                ->productTracksStockByDefault(
                    $company
                );


        $trackStockChangeable =
            $this->businessProfileService
                ->productStockTrackingIsChangeable(
                    $company
                );


        $tracksStock =
            $trackStockDefault;


        if ($trackStockChangeable) {

            $tracksStock =
                $this->trackStockValue(
                    $row['track_stock']
                        ?? null,
                    $trackStockDefault
                );


            if ($tracksStock === null) {

                $errors[] =
                    'Track Inventory must be Yes or No.';


                $tracksStock =
                    $trackStockDefault;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Normalize Values
        |--------------------------------------------------------------------------
        */

        $normalized = [

            'name' =>
                $this->stringValue(
                    $row['name'] ?? null
                ),

            'sku' =>
                $this->stringValue(
                    $row['sku'] ?? null
                ),

            'barcode' =>
                $this->stringValue(
                    $row['barcode'] ?? null
                ),

            'qr_code' =>
                $this->stringValue(
                    $row['qr_code'] ?? null
                ),

            'description' =>
                $this->stringValue(
                    $row['description'] ?? null
                ),

            'brand' =>
                $this->stringValue(
                    $row['brand'] ?? null
                ),

            'manufacturer' =>
                $this->stringValue(
                    $row['manufacturer'] ?? null
                ),

            'cost_price' =>
                $this->numericValue(
                    $row['cost_price'] ?? null
                ),

            'selling_price' =>
                $this->numericValue(
                    $row['selling_price'] ?? null
                ),

            /*
            |--------------------------------------------------------------------------
            | Minimum Stock
            |--------------------------------------------------------------------------
            |
            | products.minimum_stock is not nullable.
            |
            | Validation still decides whether the user was required to provide a
            | value. This 0 is only the safe persisted fallback for optional/hidden
            | or non-stock products.
            |
            */

            'minimum_stock' =>
                $this->numericValue(
                    $row['minimum_stock'] ?? null
                )
                ?? 0,

            'maximum_stock' =>
                $this->numericValue(
                    $row['maximum_stock'] ?? null
                ),

            'opening_stock' =>
                $this->numericValue(
                    $row['opening_stock'] ?? null
                ),

            'weight' =>
                $this->numericValue(
                    $row['weight'] ?? null
                ),

            'expiry_date' =>
                $this->dateValue(
                    $row['expiry_date'] ?? null
                ),

            'status' =>
                $this->statusValue(
                    $row['status'] ?? null
                ),

            'track_stock' =>
                (bool) $tracksStock,

        ];


        /*
        |--------------------------------------------------------------------------
        | Remove Hidden Field Values
        |--------------------------------------------------------------------------
        |
        | Hidden business-profile fields must not be imported merely because an
        | older spreadsheet happens to contain them.
        |
        */

        foreach (
            [
                'sku',
                'barcode',
                'qr_code',
                'description',
                'brand',
                'manufacturer',
                'cost_price',
                'selling_price',
                'weight',
                'expiry_date',
            ]
            as $field
        ) {

            if (
                !$fieldVisible(
                    $field
                )
            ) {

                $normalized[$field] =
                    null;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Hidden / Disabled Stock Fields
        |--------------------------------------------------------------------------
        */

        if (
            !$tracksStock
            ||
            !$fieldVisible(
                'minimum_stock'
            )
        ) {

            $normalized['minimum_stock'] =
                null;

        }


        if (
            !$tracksStock
            ||
            !$fieldVisible(
                'maximum_stock'
            )
        ) {

            $normalized['maximum_stock'] =
                null;

        }


        if (
            !$tracksStock
            ||
            !$fieldVisible(
                'opening_stock'
            )
        ) {

            $normalized['opening_stock'] =
                0;

        }


        /*
        |--------------------------------------------------------------------------
        | Required String Fields
        |--------------------------------------------------------------------------
        */

        $requiredStringFields = [

            'name' => [
                'profile' =>
                    'name',

                'label' =>
                    'Name',

                'value' =>
                    $normalized['name'],
            ],

            'sku' => [
                'profile' =>
                    'sku',

                'label' =>
                    'SKU',

                'value' =>
                    $normalized['sku'],
            ],

            'barcode' => [
                'profile' =>
                    'barcode',

                'label' =>
                    'Barcode',

                'value' =>
                    $normalized['barcode'],
            ],

            'qr_code' => [
                'profile' =>
                    'qr_code',

                'label' =>
                    'QR Code',

                'value' =>
                    $normalized['qr_code'],
            ],

            'description' => [
                'profile' =>
                    'description',

                'label' =>
                    'Description',

                'value' =>
                    $normalized['description'],
            ],

            'brand' => [
                'profile' =>
                    'brand',

                'label' =>
                    'Brand',

                'value' =>
                    $normalized['brand'],
            ],

            'manufacturer' => [
                'profile' =>
                    'manufacturer',

                'label' =>
                    'Manufacturer',

                'value' =>
                    $normalized['manufacturer'],
            ],

            'category' => [
                'profile' =>
                    'product_category_id',

                'label' =>
                    'Category',

                'value' =>
                    $this->stringValue(
                        $row['category']
                            ?? null
                    ),
            ],

            'unit' => [
                'profile' =>
                    'unit_id',

                'label' =>
                    'Unit',

                'value' =>
                    $this->stringValue(
                        $row['unit']
                            ?? null
                    ),
            ],

            'discount' => [
                'profile' =>
                    'discount_id',

                'label' =>
                    'Discount',

                'value' =>
                    $this->stringValue(
                        $row['discount']
                            ?? null
                    ),
            ],

        ];


        foreach (
            $requiredStringFields
            as $definition
        ) {

            if (
                !$fieldVisible(
                    $definition['profile']
                )
            ) {

                continue;

            }


            if (
                !$fieldRequired(
                    $definition['profile']
                )
            ) {

                continue;

            }


            if (
                $definition['value']
                === null
            ) {

                $errors[] =
                    $definition['label']
                    . ' is required.';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Numeric Fields
        |--------------------------------------------------------------------------
        */

        $numericFields = [

            'cost_price' =>
                'Cost price',

            'selling_price' =>
                'Selling price',

            'weight' =>
                'Weight',

        ];


        foreach (
            $numericFields
            as $field => $label
        ) {

            if (
                !$fieldVisible(
                    $field
                )
            ) {

                continue;

            }


            $this->validateNumericField(

                $row[$field]
                    ?? null,

                $label,

                $fieldRequired(
                    $field
                ),

                $errors

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Stock Numeric Fields
        |--------------------------------------------------------------------------
        */

        if ($tracksStock) {

            foreach (
                [
                    'minimum_stock' =>
                        'Minimum stock',

                    'maximum_stock' =>
                        'Maximum stock',

                    'opening_stock' =>
                        'Opening stock',
                ]
                as $field => $label
            ) {

                if (
                    !$fieldVisible(
                        $field
                    )
                ) {

                    continue;

                }


                $this->validateNumericField(

                    $row[$field]
                        ?? null,

                    $label,

                    $fieldRequired(
                        $field
                    ),

                    $errors

                );

            }

        }
        else {

            /*
            |--------------------------------------------------------------------------
            | Non-stock Product Defaults
            |--------------------------------------------------------------------------
            */

            $normalized['minimum_stock'] =
                0;

            $normalized['maximum_stock'] =
                null;

            $normalized['opening_stock'] =
                0;

        }

        /*
        |--------------------------------------------------------------------------
        | Minimum / Maximum Stock
        |--------------------------------------------------------------------------
        */

        if (
            $tracksStock
            &&
            $normalized['maximum_stock'] !== null
            &&
            $normalized['minimum_stock'] !== null
            &&
            $normalized['maximum_stock']
                < $normalized['minimum_stock']
        ) {

            $errors[] =
                'Maximum stock cannot be less than minimum stock.';

        }


        /*
        |--------------------------------------------------------------------------
        | Expiry Date
        |--------------------------------------------------------------------------
        */

        if (
            $fieldVisible(
                'expiry_date'
            )
        ) {

            $rawExpiryDate =
                $row['expiry_date']
                    ?? null;


            if (
                $fieldRequired(
                    'expiry_date'
                )
                &&
                (
                    $rawExpiryDate === null
                    ||
                    trim(
                        (string) $rawExpiryDate
                    ) === ''
                )
            ) {

                $errors[] =
                    'Expiry date is required.';

            }
            elseif (
                $rawExpiryDate !== null
                &&
                trim(
                    (string) $rawExpiryDate
                ) !== ''
                &&
                $normalized['expiry_date']
                    === null
            ) {

                $errors[] =
                    'Expiry date is invalid.';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $categoryName =
            $fieldVisible(
                'product_category_id'
            )
                ? $this->stringValue(
                    $row['category']
                        ?? null
                )
                : null;


        $category =
            $categoryName !== null
                ? $lookups['categories']->get(
                    $this->lookupKey(
                        $categoryName
                    )
                )
                : null;


        if (
            $categoryName !== null
            &&
            !$category
        ) {

            $errors[] =
                "Category '{$categoryName}' does not exist for this company.";

        }


        $normalized['product_category_id'] =
            $category?->id;


        /*
        |--------------------------------------------------------------------------
        | Unit
        |--------------------------------------------------------------------------
        */

        $unitName =
            $fieldVisible(
                'unit_id'
            )
                ? $this->stringValue(
                    $row['unit']
                        ?? null
                )
                : null;


        $unit =
            $unitName !== null
                ? $lookups['units']->get(
                    $this->lookupKey(
                        $unitName
                    )
                )
                : null;


        if (
            $unitName !== null
            &&
            !$unit
        ) {

            $errors[] =
                "Unit '{$unitName}' does not exist for this company.";

        }


        $normalized['unit_id'] =
            $unit?->id;


        /*
        |--------------------------------------------------------------------------
        | Discount
        |--------------------------------------------------------------------------
        */

        $discountName =
            $fieldVisible(
                'discount_id'
            )
                ? $this->stringValue(
                    $row['discount']
                        ?? null
                )
                : null;


        $discount =
            $discountName !== null
                ? $lookups['discounts']->get(
                    $this->lookupKey(
                        $discountName
                    )
                )
                : null;


        if (
            $discountName !== null
            &&
            !$discount
        ) {

            $errors[] =
                "Discount '{$discountName}' does not exist for this company.";

        }


        $normalized['discount_id'] =
            $discount?->id;


        /*
        |--------------------------------------------------------------------------
        | SKU
        |--------------------------------------------------------------------------
        */

        if (
            $fieldVisible(
                'sku'
            )
            &&
            !empty(
                $normalized['sku']
            )
        ) {

            $sku =
                $normalized['sku'];


            if (
                in_array(
                    $sku,
                    $seenSkus,
                    true
                )
            ) {

                $errors[] =
                    "SKU '{$sku}' appears more than once in this file.";

            }


            $existingSku =
                Product::withTrashed()

                    ->where(
                        'company_id',
                        $companyId
                    )

                    ->where(
                        'sku',
                        $sku
                    )

                    ->exists();


            if ($existingSku) {

                $errors[] =
                    "SKU '{$sku}' already exists.";

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Barcode
        |--------------------------------------------------------------------------
        */

        if (
            $fieldVisible(
                'barcode'
            )
            &&
            !empty(
                $normalized['barcode']
            )
        ) {

            $barcode =
                $normalized['barcode'];


            if (
                in_array(
                    $barcode,
                    $seenBarcodes,
                    true
                )
            ) {

                $errors[] =
                    "Barcode '{$barcode}' appears more than once in this file.";

            }


            $existingBarcode =
                Product::withTrashed()

                    ->where(
                        'company_id',
                        $companyId
                    )

                    ->where(
                        'barcode',
                        $barcode
                    )

                    ->exists();


            if ($existingBarcode) {

                $errors[] =
                    "Barcode '{$barcode}' already exists.";

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Row Status
        |--------------------------------------------------------------------------
        */

        $status =
            'valid';


        if (
            !empty(
                $errors
            )
        ) {

            $status =
                'error';

        }
        elseif (
            !empty(
                $warnings
            )
        ) {

            $status =
                'warning';

        }


        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */

        return [

            'row' =>
                $row['row']
                    ?? null,

            'status' =>
                $status,

            'errors' =>
                $errors,

            'warnings' =>
                $warnings,

            'normalized' =>
                $normalized,

            'display' => [

                'name' =>
                    $normalized['name'],

                'sku' =>
                    $normalized['sku'],

                'barcode' =>
                    $normalized['barcode'],

                'category' =>
                    $category?->name,

                'unit' =>
                    $unit?->name,

                'discount' =>
                    $discount?->name,

                'cost_price' =>
                    $normalized['cost_price'],

                'selling_price' =>
                    $normalized['selling_price'],

                'track_stock' =>
                    $tracksStock,

                'minimum_stock' =>
                    $normalized['minimum_stock'],

                'maximum_stock' =>
                    $normalized['maximum_stock'],

                'opening_stock' =>
                    $normalized['opening_stock'],

                'status' =>
                    $normalized['status'],

            ],

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | String Value
    |--------------------------------------------------------------------------
    */

    protected function stringValue(
        $value
    ): ?string {

        if ($value === null) {
            return null;
        }


        $value =
            trim(
                (string) $value
            );


        return $value === ''
            ? null
            : $value;
    }


    /*
    |--------------------------------------------------------------------------
    | Numeric Value
    |--------------------------------------------------------------------------
    */

    protected function numericValue(
        $value
    ): ?float {

        if (
            $value === null
            || trim((string) $value) === ''
        ) {

            return null;
        }


        if (!is_numeric($value)) {
            return null;
        }


        return (float) $value;
    }


    /*
    |--------------------------------------------------------------------------
    | Date Value
    |--------------------------------------------------------------------------
    */

    protected function dateValue(
        $value
    ): ?string {

        if (
            $value === null
            || trim((string) $value) === ''
        ) {

            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Maatwebsite Excel Date Handling
        |--------------------------------------------------------------------------
        |
        | Depending on the import configuration, Excel dates can arrive as
        | formatted strings or numeric Excel serial values.
        |
        */

        if (
            is_numeric($value)
            && (float) $value > 0
        ) {

            try {

                /*
                |--------------------------------------------------------------------------
                | Use Carbon through Laravel Excel's converted value.
                |--------------------------------------------------------------------------
                |
                | We deliberately do not call PhpSpreadsheet directly here.
                | Numeric spreadsheet dates are handled by the import layer
                | where possible. If a numeric value reaches this point,
                | we leave it to Carbon only when it represents a timestamp.
                |
                */

                $timestamp =
                    ((float) $value - 25569)
                    * 86400;

                return gmdate(
                    'Y-m-d',
                    (int) $timestamp
                );

            } catch (Throwable $e) {

                return null;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Normal Date String
        |--------------------------------------------------------------------------
        */

        try {

            return \Carbon\Carbon::parse(
                $value
            )->format('Y-m-d');

        } catch (Throwable $e) {

            return null;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Status Value
    |--------------------------------------------------------------------------
    */

    protected function statusValue(
        $value
    ): bool {

        if (
            $value === null
            || trim((string) $value) === ''
        ) {

            return true;
        }


        $value =
            mb_strtolower(
                trim(
                    (string) $value
                )
            );


        return match ($value) {

            '1',
            'true',
            'yes',
            'active',
            'enabled' =>
                true,

            '0',
            'false',
            'no',
            'inactive',
            'disabled' =>
                false,

            default =>
                true,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Numeric Field
    |--------------------------------------------------------------------------
    */

    protected function validateNumericField(
        $value,
        string $label,
        bool $required,
        array &$errors
    ): void {

        if (
            $value === null
            || trim((string) $value) === ''
        ) {

            if ($required) {

                $errors[] =
                    "{$label} is required.";
            }

            return;
        }


        if (!is_numeric($value)) {

            $errors[] =
                "{$label} must be a valid number.";

            return;
        }


        if ((float) $value < 0) {

            $errors[] =
                "{$label} cannot be negative.";
        }
    }

    /**
     * Get the columns that should appear in the import preview.
     */
    protected function previewColumnsForCompany(
        Company $company
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Universal Columns
        |--------------------------------------------------------------------------
        */

        $columns = [

            [
                'key' =>
                    'row',

                'label' =>
                    'Row',
            ],

            [
                'key' =>
                    'status',

                'label' =>
                    'Status',
            ],

            [
                'key' =>
                    'name',

                'label' =>
                    'Product',
            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | Business-aware Product Columns
        |--------------------------------------------------------------------------
        */

        $availableColumns = [

            'sku' =>
                'SKU',

            'category' =>
                'Category',

            'unit' =>
                'Unit',

            'cost_price' =>
                'Cost',

            'selling_price' =>
                'Selling',

            'track_stock' =>
                'Track Inventory',

            'opening_stock' =>
                'Opening Stock',

        ];


        foreach (
            $availableColumns
            as $column => $label
        ) {

            if (
                !$this->importColumnVisible(
                    $company,
                    $column
                )
            ) {

                continue;

            }


            $columns[] = [

                'key' =>
                    $column,

                'label' =>
                    $label,

            ];

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $columns[] = [

            'key' =>
                'validation',

            'label' =>
                'Validation',

        ];


        return $columns;
    }
}