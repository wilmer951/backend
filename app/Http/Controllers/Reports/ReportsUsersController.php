<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Reports\UserReportService;

class ReportsUsersController extends Controller
{
    protected $service;

    public function __construct(UserReportService $service)
    {
        $this->service = $service;
    }


    public function excel(Request $request)
    {
        return $this->service->generarExcel($request->all());
    }

    public function pdf(Request $request)
    {
        return $this->service->generarPdf($request->all());
    }
}
