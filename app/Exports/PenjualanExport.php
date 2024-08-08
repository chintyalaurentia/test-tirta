<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenjualanExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $forms = Penjualan::select('*')->get();

        // Add a row number to each record and move it to the first column
        $forms = $forms->map(function ($item, $key) {
            $item->row_number = $key + 1;

            // Convert the item to an array to reorder the columns
            $itemArray = $item->toArray();

            // Create a new array with the row_number as the first column
            $itemArray = array_merge(['row_number' => $item->row_number], $itemArray);

            // Convert it back to an object (optional, if you need it as an object)
            return (object) $itemArray;
        });

        return $forms;

    }

    private function cellStyle($event, $cellCoordinate)
    {
        $style = $event->sheet->getDelegate()->getStyle($cellCoordinate);
        $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $style->getAlignment()->setWrapText(true);
        $style->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;
                $data = $this->collection();
                $currentRow = 2;
                $rowNumber = 1;
                $headingsStyle = [
                    'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,

                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ];

                $lastColumnIndex = Coordinate::stringFromColumnIndex(count($this->headings()));
                $headingRange = 'A1:' . $lastColumnIndex . '1';

                $event->sheet->getDelegate()->getStyle($headingRange)->applyFromArray($headingsStyle);

                $borderStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ];
                $lastRow = $sheet->getDelegate()->getHighestRow();

                foreach ($data as $item) {

                    // $colSupp = 'H' . $currentRow;
                    // $sheet->setCellValue($colSupp, HICResin::getSuppName($item->KodeVendor));

                    $cols = range('A', 'C');
                    foreach ($cols as $column) {
                        $this->cellStyle($event, $column . $currentRow);
                    }

                    $currentRow++;
                }
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);



                for ($i = 2; $i <= $lastRow; $i++) {
                    for ($j = Coordinate::columnIndexFromString('A'); $j <= Coordinate::columnIndexFromString('C'); $j++) {
                        $colLetter = Coordinate::stringFromColumnIndex($j);
                        $event->sheet->getDelegate()->getStyle($colLetter . $i)->applyFromArray($borderStyle);
                    }
                }



            },
        ];
    }

    public function headings(): array
    {
        return  [
            'NO',
            'Kode Toko',
            'Nominal Transaksi',
        ];
    }
}
