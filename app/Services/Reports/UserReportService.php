<?php

namespace App\Services\Reports;

use App\Generators\UsersPdfGenerator;
use App\Generators\UsersExcelGenerator;
use App\Models\User;

class UserReportService
{
    protected $pdfGenerator;
    protected $excelGenerator;

    public function __construct(UsersPdfGenerator $pdfGenerator, UsersExcelGenerator $excelGenerator)
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

        // Aquí se delega la generación del archivo
        return $this->pdfGenerator->generate($usuarios)->download('usuarios.pdf');
    }



      public function generarExcel(array $filtros = [])
    {
        $usuarios = $this->obtenerUsuariosFiltrados($filtros);

        // Aquí se delega la generación del archivo
        return $this->excelGenerator->generate($usuarios);
    }
}
