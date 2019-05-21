<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />

        <!-- JQuery v3.4.0 & DataTable -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
        <link rel="stylesheet" href="{{ URL::asset('css/jquery.dataTables.min.css')}}"/>
        <script src="{{ asset('js/dataTable.js')}}"></script>
        <!--Load the AJAX API-->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart2);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
            ['Laboratorio', {!! json_encode($stats[0]) !!}],
            ['Maquinas', {!! json_encode($stats[1]) !!}],
            ['SGMI', {!! json_encode($stats[2]) !!}],
            ['Informatica', {!! json_encode($stats[3]) !!}],
            ['Calidad', {!! json_encode($stats[4]) !!}],
            ['Comercial', {!! json_encode($stats[5]) !!}],
            ['RRHH', {!! json_encode($stats[6]) !!}],
            ['Administracion', {!! json_encode($stats[7]) !!}],
            ['Operaciones', {!! json_encode($stats[8]) !!}]
            ]);

            // Set chart options
            var options = {'title':'Indice de proyectos',
                        'height':500,
                        'backgroundColor': '#f8fafc'};

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        function drawChart2() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');

            <?php for($i = 0; $i < sizeof($users); $i++){
                ?>
                data.addRow([{!! json_encode($users[$i]->id_user) !!}, {!! json_encode($users[$i]->articlesnumber)!!}]);
                <?php
            } ?>
              

            // Set chart options
            var options = {'title':'Articulos por usuario',
                        'height':500,
                        'backgroundColor': '#f8fafc'};

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div_users'));
            chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <div class="bg-light border-right" id="sidebar-wrapper">
                @include('partials.nav')
            </div>

            <style>
                .uper {
                    margin-top: 40px;
                }
            </style>
        <div class="container">
        <center>
        <br>
        <h2>Estadísticas de uso por departamento</h2>
        <?php
        ?>
        <br>
            <div id="chart_div"></div>
            <h2>Usuarios que más aportan</h2>
            <div id="chart_div_users"></div>
        </center>
        </div>
