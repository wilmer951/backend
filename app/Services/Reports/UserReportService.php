<?php

namespace App\Services\Reports;

use App\Services\Reports\Generators\PdfReportGenerator;
use App\Services\Reports\Generators\ExcelReportGenerator;
use App\Models\User;

class UserReportService
{
    protected $pdfGenerator;
    protected $excelGenerator;
    

    public function __construct(PdfReportGenerator $pdfGenerator, ExcelReportGenerator $excelGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
        $this->excelGenerator = $excelGenerator;
    }

    // Solo lógica de negocio
    public function obtenerUsuariosFiltrados(array $filtros = [])
    {
        $query = User::query();

        if (isset($filtros['estado']) && $filtros['estado'] !== '') {
            $query->where('status', $filtros['estado']);
        }

        if (!empty($filtros['desde'])) {
            $query->whereDate('created_at', '>=', $filtros['desde']);
        }

        if (!empty($filtros['hasta'])) {
            $query->whereDate('created_at', '<=', $filtros['hasta']);
        }

        return $query->get();
    }

    // Coordinación de lógica y formateo
    public function generarPdf(array $filtros = [])
    {
        $usuarios = $this->obtenerUsuariosFiltrados($filtros);

        $view='Reports.RptUsers';
        // Aquí se delega la generación del archivo
        return $this->pdfGenerator->generate($usuarios,$view)->download('usuarios.pdf');
    }



      public function generarExcel(array $filtros = [])
    {
          $usuarios = $this->obtenerUsuariosFiltrados($filtros);

                    return ExcelReportGenerator::make()
                    ->title('Reporte de Usuarios')
                    ->headers(['ID', 'Nombre', 'Email', 'Estado', 'Fecha de creación'])
                    ->data($usuarios, function ($usuario) {
                        return [
                            $usuario->id,
                            $usuario->name,
                            $usuario->email,
                            $usuario->status ? 'Activo' : 'Inactivo',
                            optional($usuario->created_at)->format('Y-m-d'),
                        ];
                    })
                    ->build()
                    ->download('usuarios.xlsx');
            }

}
