<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
        <script src="main.js"></script>
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <div class="bg-light border-right" id="sidebar-wrapper">
                @include('partials.nav')
            </div>
            <div class="container">
                <div class="card" style="margin-top:2%;">
                    <div class="card-body">
                        <h5 class="card-title">Departamento 1</h5>
                        <p class="card-text">Ultima entrada</p>
                        <a href="#" class="btn btn-primary">Entrar</a>
                    </div>
                </div>
                <div class="card" style="margin-top:2%;">
                    <div class="card-body">
                        <h5 class="card-title">Departamento 2</h5>
                        <p class="card-text">Ultima entrada</p>
                        <a href="#" class="btn btn-primary">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>