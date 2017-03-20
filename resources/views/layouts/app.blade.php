<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{asset("css/app.css")}}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style>
            .panel-primary>.panel-heading {
                color: #fff;
                background-color: #3c8dbc;
                border-color: #3c8dbc;
            }

        </style>
</head>
<body  style="    background: #ecf0f5;">
    <div id="app" style="    background: #ecf0f5;
    margin-top: 10%;">
 
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{asset("js/app.js")}}"></script>
</body>
</html>
