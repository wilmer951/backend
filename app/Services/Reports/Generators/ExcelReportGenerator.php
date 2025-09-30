<?php

namespace App\Services\Reports\Generators;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\Reports\Helpers\ExcelTemplateHelper;

class ExcelReportGenerator
{
    protected $spreadsheet;
    protected $sheet;
    protected $title;
    protected $headers;
    protected $rows = [];

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();
    }

    public static function make(): self
    {
        return new self();
    }

    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function headers(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    public function data(iterable $items, callable $rowMapper): self
    {
        foreach ($items as $item) {
            $this->rows[] = $rowMapper($item);
        }
        return $this;
    }

    public function build(): self
    {
        ExcelTemplateHelper::applyBaseLayout($this->sheet, $this->title, $this->headers);

        $row = 4;
        foreach ($this->rows as $rowData) {
            $col = 1;
            foreach ($rowData as $cell) {
                $this->sheet->setCellValue([$col, $row], $cell);
                $col++;
            }
            $row++;
        }

        ExcelTemplateHelper::autoSizeColumns($this->sheet, count($this->headers));

        return $this;
    }

    public function download(string $filename = 'reporte.xlsx'): StreamedResponse
    {
        $writer = new Xlsx($this->spreadsheet);
        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
