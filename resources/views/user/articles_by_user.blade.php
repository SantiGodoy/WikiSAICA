<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Mis artículos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />

        <!-- JQuery v3.4.0 & DataTable -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
        <link rel="stylesheet" href="{{ URL::asset('css/jquery.dataTables.min.css')}}"/>
        <script src="{{ asset('js/dataTable.js')}}"></script>
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
                    <table class="table table-striped dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Última modificación</th>
                                <th scope="col">Acciones</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                                <td>{{$article->title}}</td>
                                <td>{{App\Article::getOwner($article)->name}}</td>
                            <!--    <td id={{$article->id}}>{{$article->updated_at}}</td> -->
                                    <td id={{$article->id_article}}>{{$article->updated_at}}</td>
                                <script>
                                  //  var id = @json($article->id);
                                      var id = @json($article->id_article);
                                    var date = document.getElementById(id).innerHTML.split(" ");
                                    var dmy = date[0].split("-");
                                    document.getElementById(id).innerHTML = dmy[2]+"-"+dmy[1]+"-"+dmy[0]+" / "+date[1];
                                </script>
                                <td><a href="{{ route('users.show',$article->id)}}" class="btn btn-primary">Ver</a></td>
                                <td>
                                  <!--  <form action="{{ route('users.destroy', $article->id)}}" method="post"> -->
                                        <form action="{{ route('users.destroy', $article->id_article)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        @if ((Auth::user()->role) == "admin")
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <div>
            </div>
        </div>
    </body>
</html>
