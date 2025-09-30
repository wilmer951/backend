<?php
namespace App\Services\Reports\Helpers;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelTemplateHelper
{
    public static function applyBaseLayout(Worksheet $sheet, string $titulo, array $headers)
    {
        // Título del reporte
        $sheet->setCellValue('A1', $titulo);
        $sheet->mergeCells('A1:' . chr(64 + count($headers)) . '1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Encabezados
        $colIndex = 1;
        foreach ($headers as $header) {
            $columnLetter = chr(64 + $colIndex);
            $cellCoordinate = $columnLetter . '3';
            $sheet->setCellValue($cellCoordinate, $header);
            $colIndex++;
        }

        // Negrita en encabezados
        $sheet->getStyle("A3:" . chr(64 + count($headers)) . "3")->getFont()->setBold(true);
    }

    public static function autoSizeColumns(Worksheet $sheet, int $colCount)
    {
        foreach (range(1, $colCount) as $col) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
    }
}
