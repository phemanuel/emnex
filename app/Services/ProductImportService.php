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


    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct(
        ActivityLogger $activityLogger
    ) {
        $this->activityLogger = $activityLogger;
    }


    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    */

    /**
     * Download Excel import template.
     */
    public function downloadExcelTemplate()
    {
        return Excel::download(
            new ProductImportTemplateExport(),
            'products-import-template.xlsx'
        );
    }


    /**
     * Download CSV import template.
     */
    public function downloadCsvTemplate()
    {
        return Excel::download(
            new ProductImportTemplateExport(),
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
        $rows = $this->readFile($file);

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

            $result = $this->validateRow(
                $row,
                $companyId,
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
                    count($validatedRows),

                'valid' =>
                    $validCount,

                'warnings' =>
                    $warningCount,

                'errors' =>
                    $errorCount,

                'can_import' =>
                    $errorCount === 0,
            ],

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
        $rows = $this->readFile($file);

        if (empty($rows)) {
            throw ValidationException::withMessages([
                'file' =>
                    'The import file does not contain any product rows.',
            ]);
        }

        return DB::transaction(
            function () use (
                $rows,
                $companyId,
                $user
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

                foreach ($rows as $row) {

                    $result =
                        $this->validateRow(
                            $row,
                            $companyId,
                            $lookups,
                            $seenSkus,
                            $seenBarcodes
                        );


                    if (
                        $result['status'] === 'error'
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


                    if (
                        !empty(
                            $result['normalized']['sku']
                        )
                    ) {
                        $seenSkus[] =
                            $result['normalized']['sku'];
                    }


                    if (
                        !empty(
                            $result['normalized']['barcode']
                        )
                    ) {
                        $seenBarcodes[] =
                            $result['normalized']['barcode'];
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
                | Head Office
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Import Products
                |--------------------------------------------------------------------------
                */

                $imported = 0;

                $products = [];


                foreach (
                    $validatedRows as $result
                ) {

                    $data =
                        $result['normalized'];


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
                            $data['product_category_id'],

                        'unit_id' =>
                            $data['unit_id'],

                        'discount_id' =>
                            $data['discount_id'],

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

                        'minimum_stock' =>
                            $data['minimum_stock'],

                        'maximum_stock' =>
                            $data['maximum_stock'],

                        'weight' =>
                            $data['weight'],

                        'expiry_date' =>
                            $data['expiry_date'],

                        'status' =>
                            $data['status'],
                    ];


                    $product =
                        Product::create(
                            $productData
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Head Office Opening Stock
                    |--------------------------------------------------------------------------
                    */

                    $openingStock =
                        $data['opening_stock'];


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
                            $data['minimum_stock'],

                        'maximum_stock' =>
                            $data['maximum_stock'],
                    ]);


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
    protected function readFile(UploadedFile $file): array
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

            $this->validateHeaders($headers);

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
            trim((string) $header);


        /*
        |--------------------------------------------------------------------------
        | Remove UTF-8 BOM
        |--------------------------------------------------------------------------
        |
        | This protects CSV headers from invisible BOM characters.
        |
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


        return preg_replace(
            '/[^a-z0-9_]/',
            '',
            $header
        );
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


    /*
    |--------------------------------------------------------------------------
    | Validate Headers
    |--------------------------------------------------------------------------
    */

    protected function validateHeaders(
        array $headers
    ): void {

        $required = [

            'name',
            'category',
            'unit',
            'cost_price',
            'selling_price',
            'minimum_stock',
        ];


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
        int $companyId,
        array $lookups,
        array &$seenSkus,
        array &$seenBarcodes
    ): array {

        $errors = [];
        $warnings = [];


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

            'minimum_stock' =>
                $this->numericValue(
                    $row['minimum_stock'] ?? null
                ),

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
        ];


        /*
        |--------------------------------------------------------------------------
        | Required Fields
        |--------------------------------------------------------------------------
        */

        if (
            $normalized['name'] === null
        ) {

            $errors[] =
                'Name is required.';
        }


        if (
            $this->stringValue(
                $row['category'] ?? null
            ) === null
        ) {

            $errors[] =
                'Category is required.';
        }


        if (
            $this->stringValue(
                $row['unit'] ?? null
            ) === null
        ) {

            $errors[] =
                'Unit is required.';
        }


        /*
        |--------------------------------------------------------------------------
        | Numeric Fields
        |--------------------------------------------------------------------------
        */

        $this->validateNumericField(
            $row['cost_price'] ?? null,
            'Cost price',
            true,
            $errors
        );


        $this->validateNumericField(
            $row['selling_price'] ?? null,
            'Selling price',
            true,
            $errors
        );


        $this->validateNumericField(
            $row['minimum_stock'] ?? null,
            'Minimum stock',
            true,
            $errors
        );


        $this->validateNumericField(
            $row['maximum_stock'] ?? null,
            'Maximum stock',
            false,
            $errors
        );


        $this->validateNumericField(
            $row['opening_stock'] ?? null,
            'Opening stock',
            false,
            $errors
        );


        $this->validateNumericField(
            $row['weight'] ?? null,
            'Weight',
            false,
            $errors
        );


        /*
        |--------------------------------------------------------------------------
        | Minimum / Maximum Stock
        |--------------------------------------------------------------------------
        */

        if (
            $normalized['maximum_stock'] !== null
            && $normalized['minimum_stock'] !== null
            && $normalized['maximum_stock']
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
            ($row['expiry_date'] ?? null) !== null
            && $normalized['expiry_date'] === null
        ) {

            $errors[] =
                'Expiry date is invalid.';
        }


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $categoryName =
            $this->stringValue(
                $row['category'] ?? null
            );


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
            && !$category
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
            $this->stringValue(
                $row['unit'] ?? null
            );


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
            && !$unit
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
            $this->stringValue(
                $row['discount'] ?? null
            );


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
            && !$discount
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

        $status = 'valid';


        if (!empty($errors)) {

            $status = 'error';

        } elseif (!empty($warnings)) {

            $status = 'warning';
        }


        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */

        return [

            'row' =>
                $row['row'] ?? null,

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
}