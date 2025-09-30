<?php

namespace App\Services\Reports;

use App\Services\Reports\Generators\PdfReportGenerator;
use App\Services\Reports\Generators\ExcelReportGenerator;
use App\Models\Auth\LoginHistory;
use App\Models\User;


class LoginHistoryService
{
    protected $pdfGenerator;
    protected $excelGenerator;

    public function __construct(PdfReportGenerator $pdfGenerator, ExcelReportGenerator $excelGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
        $this->excelGenerator = $excelGenerator;
    }

    // Solo lógica de negocio
    public function obtenerLoginHistoryFiltrados(array $filtros = [])
    {
          $query= LoginHistory::select('id', 'user_id', 'ip_address', 'logged_in_at','user_agent')
                ->with(['user:id,username,email'])
                ->orderBy('logged_in_at', 'desc');



        if (!empty($filtros['desde'])) {
            $query->whereDate('logged_in_at', '>=', $filtros['desde']);
        }

        if (!empty($filtros['hasta'])) {
            $query->whereDate('logged_in_at', '<=', $filtros['hasta']);
        }

        return $query->get();
    }

    // Coordinación de lógica y formateo
    public function generarPdf(array $filtros = [])


    {
        $view='Reports.RptLoginHistory';
        
        
        $usuarios = $this->obtenerLoginHistoryFiltrados($filtros);
        
    
        // Aquí se delega la generación del archivo
        return $this->pdfGenerator->generate($usuarios,$view)->download('usuariosLogin.pdf');
    }





    public function generarExcel(array $filtros = [])
    {
        $loginHistories = $this->obtenerLoginHistoryFiltrados($filtros);

        return ExcelReportGenerator::make()
            ->title('Reporte de Historial de Login')
            ->headers(['ID', 'Usuario', 'Email', 'IP', 'Fecha de Login', 'User Agent'])
            ->data($loginHistories, function ($history) {
                return [
                    $history->id,
                    optional($history->user)->username,
                    optional($history->user)->email,
                    $history->ip_address,
                    optional($history->logged_in_at)->format('Y-m-d H:i:s'),
                    $history->user_agent,
                ];
            })
            ->build()
            ->download('historial_login.xlsx');
    }


};