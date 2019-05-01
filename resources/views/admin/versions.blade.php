<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
        <script src="https://cdn.ckeditor.com/4.11.3/standard-all/ckeditor.js"></script>
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
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Modificador</th>
                                <th scope="col" colspan="1">Acción</th>
                                <th scope="col">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                                <td>{{$article->title}}</td>
                                <td>{{App\Article::getOwner($article)->name}}</td>
                                <td>{{App\Article::getModifier($article)->name}}</td>
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

                                <!--
                                <td><a href="{{ route('articles.show',$article->id)}}" class="btn btn-primary">Ver</a></td>
                                <td>
                                    @if ((Auth::user()->role) == "admin")
                                    <form action="{{ route('articles.destroy', $article->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                    @endif
                                </td>
                                -->
                          
                                <td>{{$article->last_action}}</td>
                                <td id={{$article->id}}>{{$article->updated_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <div>
            </div>
        </div>
    </body>
</html>
