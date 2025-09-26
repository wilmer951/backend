<?php
namespace App\Generators;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Helpers\ExcelTemplateHelper;

class UsersExcelGenerator
{
    public function generate($usuarios)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Base genérica
        ExcelTemplateHelper::applyBaseLayout($sheet, 'Reporte de Usuarios', [
            'ID', 'Nombre', 'Email', 'Estado', 'Fecha de creación'
        ]);

        // Datos
        $row = 4;
        foreach ($usuarios as $usuario) {
            $sheet->setCellValue("A{$row}", $usuario->id);
            $sheet->setCellValue("B{$row}", $usuario->name);
            $sheet->setCellValue("C{$row}", $usuario->email);
            $sheet->setCellValue("D{$row}", $usuario->status ? 'Activo' : 'Inactivo');
            $sheet->setCellValue("E{$row}", $usuario->created_at->format('Y-m-d'));
            $row++;
        }

        // Ajuste columnas
        ExcelTemplateHelper::autoSizeColumns($sheet, 5);

        // Descargar directo
        $writer = new Xlsx($spreadsheet);
        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="usuarios.xlsx"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
