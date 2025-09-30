<?php

namespace App\Services\Reports\Generators;


use PDF; // Alias registrado para Barryvdh\DomPDF\Facade


   class PdfReportGenerator
{
    public function generate($data, $viewName)
    {
        return PDF::loadView($viewName, ['usuarios' => $data]);
    }
}
