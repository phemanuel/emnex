<?php

namespace App\Exports\Reports\Products;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductImportTemplateExport implements
    FromArray,
    WithHeadings,
    ShouldAutoSize,
    WithStyles
{
    /**
     * Spreadsheet headings.
     */
    protected array $headings;


    /**
     * Constructor.
     */
    public function __construct(
        array $headings
    ) {

        $this->headings =
            $headings;

    }


    /**
     * No sample product rows.
     *
     * The template contains headings only so an example product
     * cannot accidentally be imported as real data.
     */
    public function array(): array
    {
        return [];
    }


    /**
     * Dynamic headings supplied by the business profile.
     */
    public function headings(): array
    {
        return $this->headings;
    }


    /**
     * Basic Excel heading styling.
     *
     * CSV exports simply ignore spreadsheet styling.
     */
    public function styles(
        Worksheet $sheet
    ): array {

        return [

            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],

        ];
    }
}