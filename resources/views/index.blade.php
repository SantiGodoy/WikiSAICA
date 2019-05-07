<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Wikisaica</title>
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
            <div class="container-fluid" style = "margin-left: 0;">
                <h1 id="firstHeading" class="firstHeading">Bienvenidos/as a WikiSaica</h1>
                <h5 id="firstHeading" class="firstHeading">Aquí podrás ver los últimos artículos que se han añadido por cada departamento o  <a href="{{ route('articles.index')}}">buscar</a> entre todos los artículos disponibles.</h4>
                <table width="100%">
                <?php $i = 0;?>
                    @foreach($departments as $department)
                        <?php if($i % 2 == 0) print "<tr>"?>
                                <td width="50%">
                                    <div class="card" style="margin-top:2%;">
                                        <div class="card-body">        
                                            <h5 class="card-title"><a class= "card-title" href="{{ route('departments.show',$department->id) }}">{{$department->name}}</a></h5>
                                            @if(App\Article::getArticle($department->id))
                                            <a href="{{ route('articles.show',App\Article::getArticle($department->id)->id)}}" class="card-text">{{App\Article::getArticle($department->id)->title}}</a> <!-- COMPROBAR BIEN ESTO. TÍTULO DEL ÚLTIMO ARTÍCULO SUBIDO CON RESPECTO AL DEPARTAMENTO-->
                                            @else
                                            <br>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                        <?php ++$i;
                        if($i % 2 == 0) print "</tr>"?>
                    @endforeach
                </table>
                <br>
            </div>
        </div>
    </body>
</html>