<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Reporte')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        header {
            margin-bottom: 30px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        h1, h2 {
            margin: 0;
        }

        .report-meta {
            margin-top: 10px;
            font-size: 11px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>
<body>

    <header>
        <h2>@yield('title', 'Reporte')</h2>
        <div class="report-meta">
            Fecha de generación: {{ date('Y-m-d H:i') }}
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        Generado automáticamente por el sistema - {{ config('app.name', 'MiAplicación') }}
    </footer>

</body>
</html>
