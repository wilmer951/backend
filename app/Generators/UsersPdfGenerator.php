<?php

namespace App\Generators;


use PDF; // Alias registrado para Barryvdh\DomPDF\Facade


   class UsersPdfGenerator
{
    public function generate($usuarios)
    {
        return PDF::loadView('reports.Users', compact('usuarios'));
    }
}

