<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Discount;
use App\Models\DocumentSequence;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\TaxRate;
use App\Models\Unit;
use App\Services\ActivityLogger;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Exports\Reports\Products\ProductImportTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;

use Throwable;

class ProductImportService
{
    /**
     * Import columns.
     *
     * Product codes are deliberately excluded because they are
     * generated from the company's product document sequence.
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
        'tax_rate',
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

    /**
     * Human-readable column labels.
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
        'tax_rate' => 'Tax Rate',
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

    /**
     * Activity logger.
     */
    protected ActivityLogger $activityLogger;

    /**
     * Create service.
     */
    public function __construct(ActivityLogger $activityLogger)
    {
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
                'file' => 'The import file does not contain any product rows.',
            ]);
        }

        $lookups = $this->buildLookups($companyId);

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
            | Track values appearing in the uploaded file.
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
                $seenSkus[] = $result['normalized']['sku'];
            }

            if (
                !empty($result['normalized']['barcode'])
                && !in_array(
                    $result['normalized']['barcode'],
                    $seenBarcodes,
                    true
                )
            ) {
                $seenBarcodes[] = $result['normalized']['barcode'];
            }
        }

        return [
            'summary' => [
                'total' => count($validatedRows),
                'valid' => $validCount,
                'warnings' => $warningCount,
                'errors' => $errorCount,
                'can_import' => $errorCount === 0,
            ],

            'rows' => $validatedRows,
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
     * The file is parsed and validated again. The preview response
     * is never trusted as the source of truth.
     */
    public function import(
        UploadedFile $file,
        int $companyId,
        $user
    ): array {
        $rows = $this->readFile($file);

        if (empty($rows)) {
            throw ValidationException::withMessages([
                'file' => 'The import file does not contain any product rows.',
            ]);
        }

        return DB::transaction(function () use (
            $rows,
            $companyId,
            $user
        ) {

            /*
            |--------------------------------------------------------------------------
            | Resolve all relationships before writing products.
            |--------------------------------------------------------------------------
            */

            $lookups = $this->buildLookups($companyId);

            $validatedRows = [];

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

                if ($result['status'] === 'error') {
                    throw ValidationException::withMessages([
                        "row_{$result['row']}" =>
                            implode(' ', $result['errors']),
                    ]);
                }

                $validatedRows[] = $result;

                if (!empty($result['normalized']['sku'])) {
                    $seenSkus[] = $result['normalized']['sku'];
                }

                if (!empty($result['normalized']['barcode'])) {
                    $seenBarcodes[] = $result['normalized']['barcode'];
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Product sequence
            |--------------------------------------------------------------------------
            */

            $sequence = DocumentSequence::query()
                ->where('company_id', $companyId)
                ->where('document_type', 'product')
                ->where('status', true)
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

            $headOffice = Branch::query()
                ->where('company_id', $companyId)
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
            | Import products
            |--------------------------------------------------------------------------
            */

            $imported = 0;

            $products = [];

            foreach ($validatedRows as $result) {

                $data = $result['normalized'];

                /*
                |--------------------------------------------------------------------------
                | Generate product code from locked sequence.
                |--------------------------------------------------------------------------
                */

                $productCode = $sequence->formattedNumber(
                    $sequence->current_number
                );

                $sequence->current_number++;

                /*
                |--------------------------------------------------------------------------
                | Product data
                |--------------------------------------------------------------------------
                */

                $productData = [
                    'company_id' => $companyId,

                    'product_category_id' =>
                        $data['product_category_id'],

                    'unit_id' =>
                        $data['unit_id'],

                    'tax_rate_id' =>
                        $data['tax_rate_id'],

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

                $product = Product::create($productData);

                /*
                |--------------------------------------------------------------------------
                | Head Office stock
                |--------------------------------------------------------------------------
                */

                $openingStock = $data['opening_stock'];

                ProductStock::create([
                    'company_id' => $companyId,

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

                $products[] = [
                    'id' => $product->id,
                    'product_code' => $productCode,
                    'name' => $product->name,
                    'sku' => $product->sku,
                ];

                $imported++;
            }

            /*
            |--------------------------------------------------------------------------
            | Persist sequence
            |--------------------------------------------------------------------------
            */

            $sequence->save();

            /*
            |--------------------------------------------------------------------------
            | Activity log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(
                'Products',
                'Imported',
                "{$imported} product(s) imported successfully.",
                null,
                null,
                [
                    'company_id' => $companyId,
                    'count' => $imported,
                    'products' => $products,
                ]
            );

            return [
                'imported' => $imported,
                'products' => $products,
            ];
        });
    }

    /*
    |--------------------------------------------------------------------------
    | File Reading
    |--------------------------------------------------------------------------
    */

    /**
     * Read XLSX, XLS or CSV file into normalized row arrays.
     */
    protected function readFile(UploadedFile $file): array
    {
        try {

            $spreadsheet = IOFactory::load(
                $file->getRealPath()
            );

        } catch (Throwable $e) {

            throw ValidationException::withMessages([
                'file' =>
                    'The uploaded file could not be read. Please use a valid Excel or CSV file.',
            ]);
        }

        $sheet = $spreadsheet->getActiveSheet();

        $rows = $sheet->toArray(
            null,
            true,
            true,
            true
        );

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

            $normalizedHeader =
                $this->normalizeHeader($header);

            if ($normalizedHeader === '') {
                continue;
            }

            $headers[$column] = $normalizedHeader;
        }

        $this->validateHeaders($headers);

        /*
        |--------------------------------------------------------------------------
        | Data rows
        |--------------------------------------------------------------------------
        */

        $result = [];

        foreach ($rows as $index => $row) {

            $excelRow = $index + 2;

            /*
            |--------------------------------------------------------------------------
            | Skip completely empty rows.
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

            $normalized = [
                'row' => $excelRow,
            ];

            foreach ($headers as $column => $header) {
                $normalized[$header] =
                    isset($row[$column])
                        ? $this->cleanValue($row[$column])
                        : null;
            }

            $result[] = $normalized;
        }

        return $result;
    }

    /**
     * Normalize spreadsheet header names.
     */
    protected function normalizeHeader($header): string
    {
        $header = trim((string) $header);

        $header = strtolower($header);

        $header = str_replace(
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

    /**
     * Clean imported cell values.
     */
    protected function cleanValue($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === ''
            ? null
            : $value;
    }

    /**
     * Validate required spreadsheet headers.
     */
    protected function validateHeaders(array $headers): void
    {
        $required = [
            'name',
            'category',
            'unit',
            'cost_price',
            'selling_price',
            'minimum_stock',
        ];

        $missing = [];

        foreach ($required as $column) {
            if (!in_array($column, $headers, true)) {
                $missing[] =
                    $this->columnLabels[$column] ?? $column;
            }
        }

        if (!empty($missing)) {
            throw ValidationException::withMessages([
                'file' =>
                    'The import file is missing required columns: '
                    . implode(', ', $missing)
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
    protected function buildLookups(int $companyId): array
    {
        return [
            'categories' =>
                ProductCategory::query()
                    ->where('company_id', $companyId)
                    ->get()
                    ->keyBy(
                        fn ($item) =>
                            $this->lookupKey($item->name)
                    ),

            'units' =>
                Unit::query()
                    ->where('company_id', $companyId)
                    ->get()
                    ->keyBy(
                        fn ($item) =>
                            $this->lookupKey($item->name)
                    ),

            'tax_rates' =>
                TaxRate::query()
                    ->where('company_id', $companyId)
                    ->get()
                    ->keyBy(
                        fn ($item) =>
                            $this->lookupKey($item->name)
                    ),

            'discounts' =>
                Discount::query()
                    ->where('company_id', $companyId)
                    ->get()
                    ->keyBy(
                        fn ($item) =>
                            $this->lookupKey($item->name)
                    ),
        ];
    }

    /**
     * Normalize lookup value.
     */
    protected function lookupKey($value): string
    {
        return mb_strtolower(
            trim((string) $value)
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

        $normalized = [
            'name' => $this->stringValue($row['name'] ?? null),

            'sku' => $this->stringValue($row['sku'] ?? null),

            'barcode' =>
                $this->stringValue($row['barcode'] ?? null),

            'qr_code' =>
                $this->stringValue($row['qr_code'] ?? null),

            'description' =>
                $this->stringValue($row['description'] ?? null),

            'brand' =>
                $this->stringValue($row['brand'] ?? null),

            'manufacturer' =>
                $this->stringValue($row['manufacturer'] ?? null),

            'cost_price' =>
                $this->numericValue($row['cost_price'] ?? null),

            'selling_price' =>
                $this->numericValue($row['selling_price'] ?? null),

            'minimum_stock' =>
                $this->numericValue($row['minimum_stock'] ?? null),

            'maximum_stock' =>
                $this->numericValue($row['maximum_stock'] ?? null),

            'opening_stock' =>
                $this->numericValue($row['opening_stock'] ?? null),

            'weight' =>
                $this->numericValue($row['weight'] ?? null),

            'expiry_date' =>
                $this->dateValue($row['expiry_date'] ?? null),

            'status' =>
                $this->statusValue($row['status'] ?? null),
        ];

        /*
        |--------------------------------------------------------------------------
        | Required fields
        |--------------------------------------------------------------------------
        */

        if ($normalized['name'] === null) {
            $errors[] = 'Name is required.';
        }

        if (
            $this->stringValue($row['category'] ?? null)
            === null
        ) {
            $errors[] = 'Category is required.';
        }

        if (
            $this->stringValue($row['unit'] ?? null)
            === null
        ) {
            $errors[] = 'Unit is required.';
        }

        /*
        |--------------------------------------------------------------------------
        | Numeric fields
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
        | Minimum / maximum stock relationship
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
        | Expiry date
        |--------------------------------------------------------------------------
        */

        if (
            ($row['expiry_date'] ?? null) !== null
            && $normalized['expiry_date'] === null
        ) {
            $errors[] = 'Expiry date is invalid.';
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
                    $this->lookupKey($categoryName)
                )
                : null;

        if ($categoryName !== null && !$category) {
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
                    $this->lookupKey($unitName)
                )
                : null;

        if ($unitName !== null && !$unit) {
            $errors[] =
                "Unit '{$unitName}' does not exist for this company.";
        }

        $normalized['unit_id'] =
            $unit?->id;

        /*
        |--------------------------------------------------------------------------
        | Tax rate
        |--------------------------------------------------------------------------
        */

        $taxRateName =
            $this->stringValue(
                $row['tax_rate'] ?? null
            );

        $taxRate =
            $taxRateName !== null
                ? $lookups['tax_rates']->get(
                    $this->lookupKey($taxRateName)
                )
                : null;

        if ($taxRateName !== null && !$taxRate) {
            $errors[] =
                "Tax rate '{$taxRateName}' does not exist for this company.";
        }

        $normalized['tax_rate_id'] =
            $taxRate?->id;

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
                    $this->lookupKey($discountName)
                )
                : null;

        if ($discountName !== null && !$discount) {
            $errors[] =
                "Discount '{$discountName}' does not exist for this company.";
        }

        $normalized['discount_id'] =
            $discount?->id;

        /*
        |--------------------------------------------------------------------------
        | SKU duplicates
        |--------------------------------------------------------------------------
        */

        if (!empty($normalized['sku'])) {

            $sku = $normalized['sku'];

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

            $existingSku = Product::withTrashed()
                ->where('company_id', $companyId)
                ->where('sku', $sku)
                ->exists();

            if ($existingSku) {
                $errors[] =
                    "SKU '{$sku}' already exists.";
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Barcode duplicates
        |--------------------------------------------------------------------------
        */

        if (!empty($normalized['barcode'])) {

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

            $existingBarcode = Product::withTrashed()
                ->where('company_id', $companyId)
                ->where('barcode', $barcode)
                ->exists();

            if ($existingBarcode) {
                $errors[] =
                    "Barcode '{$barcode}' already exists.";
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Return row result
        |--------------------------------------------------------------------------
        */

        $status = 'valid';

        if (!empty($errors)) {
            $status = 'error';
        } elseif (!empty($warnings)) {
            $status = 'warning';
        }

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

                'tax_rate' =>
                    $taxRate?->name,

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
    | Value Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Normalize string.
     */
    protected function stringValue($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === ''
            ? null
            : $value;
    }

    /**
     * Convert numeric value.
     */
    protected function numericValue($value): ?float
    {
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

    /**
     * Parse date.
     */
    protected function dateValue($value): ?string
    {
        if (
            $value === null
            || trim((string) $value) === ''
        ) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Excel serial dates
        |--------------------------------------------------------------------------
        */

        if (
            is_numeric($value)
            && (float) $value > 0
        ) {
            try {

                $date =
                    \PhpOffice\PhpSpreadsheet\Shared\Date
                        ::excelToDateTimeObject(
                            (float) $value
                        );

                return $date->format('Y-m-d');

            } catch (Throwable $e) {
                return null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Normal date strings
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

    /**
     * Normalize status.
     */
    protected function statusValue($value): bool
    {
        if (
            $value === null
            || trim((string) $value) === ''
        ) {
            return true;
        }

        $value = mb_strtolower(
            trim((string) $value)
        );

        return match ($value) {
            '1',
            'true',
            'yes',
            'active',
            'enabled' => true,

            '0',
            'false',
            'no',
            'inactive',
            'disabled' => false,

            default => true,
        };
    }

    /**
     * Validate numeric spreadsheet value.
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

