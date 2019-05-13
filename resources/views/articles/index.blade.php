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
        
        <script>
            $(document).ready( function () {
                $('#dataTable').DataTable({
                    "ordering": false,
                    "info": false,
                    "language": {
                        "lengthMenu": "Desplegar _MENU_ artículos por página.",
                        "zeroRecords": "No se ha encontrado nada.",
                        "infoEmpty": "No hay artículos disponibles",
                        "loadingRecords": "Cargando...",
                        "processing":     "Procesando...",
                        "search":         "Buscar: ",
                        "paginate": {
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        }
                    },
                    "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]]
                });
            });
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
                <div class="uper">
                    @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                    <br>
                    @endif
                    
                    <!-- Table -->
                    <table id="dataTable" class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Última modificación</th>
                                <!--<th scope="col" colspan="2">Acción</th>-->
                                <th scope="col"></th>
                                @if ((Auth::user()->role) == "admin")
                                <th scope="col"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="tableData">
                            @foreach($articles as $article)
                            <tr>
                                <td>{{$article->title}}</td>
                                <td>{{App\Article::getOwner($article)->name}}</td>
                                <td id={{$article->id}}>{{$article->updated_at}}</td>
                                <script>
                                    var id = @json($article->id);
                                    var date = document.getElementById(id).innerHTML.split(" ");
                                    var dmy = date[0].split("-");
                                    document.getElementById(id).innerHTML = dmy[2]+"-"+dmy[1]+"-"+dmy[0]+" / "+date[1];
                                </script>
                                <!--
                                <td id={{$article->id}}>{{$article->description}}</td>
                                <script type="text/javascript">
                                    var id = @json($article->id);
                                    document.getElementById(id).innerHTML = @json($article->description);
                                </script>
                                -->
                                <td><a href="{{ route('articles.show',$article->id)}}" class="btn btn-primary">Ver</a></td>
                                @if ((Auth::user()->role) == "admin")
                                <td>
                                    <form action="{{ route('articles.destroy', $article->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <div>
            </div>
        </div>
    </body>
</html>
