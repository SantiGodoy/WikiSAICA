<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Panel de administración</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
        <script src="https://cdn.ckeditor.com/4.11.3/standard-all/ckeditor.js"></script>

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
                                <th scope="col">Departamento</th>
                                <th scope="col">Título</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Fecha de subida</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                                <td>{{App\Department::getDepartment($article->department_id)->name}}</td>
                                <td>{{$article->title}}</td>
                                <td>{{App\Article::getOwner($article)->name}}</td>
                                <td id={{$article->id}}>{{$article->updated_at}}</td>
                                <script>
                                    var id = @json($article->id);
                                    var date = document.getElementById(id).innerHTML.split(" ");
                                    var dmy = date[0].split("-");
                                    document.getElementById(id).innerHTML = dmy[2]+"-"+dmy[1]+"-"+dmy[0]+" / "+date[1];
                                </script>
                                <td><a href="{{ route('article',$article->id)}}" class="btn btn-primary">Ver</a></td>
                                <td><a href="{{ route('admin.edit',$article->id)}}" class="btn btn-primary">Permitir</a></td>
                                <td>
                                    <form action="{{ route('admin.destroy', $article->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Rechazar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('admin.show', 3)}}" class="btn btn-primary">Estadísticas</a>
                <div>
            </div>
        </div>
    </body>
</html>
