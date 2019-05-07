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
        
        <script type="text/javascript">
            function searchData() {
                var input = document.getElementById("searchInput");
                var filter = input.value.toUpperCase();
                var table = document.getElementById("tableData");
                var tr = table.getElementsByTagName("tr");
                var select = document.getElementById("searchSelect");
                for(var i=0; i<tr.length; i++){
                    var td = tr[i].getElementsByTagName("td")[select.options[select.selectedIndex].value];
                    if (td){
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1){
                            tr[i].style.display = "";
                        }
                        else 
                            tr[i].style.display = "none";
                    }
                }
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
                <div class="uper">
                    @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                    <br>
                    @endif
                    
                    <!-- Search -->
                    <input id="searchInput"class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" onkeyup="searchData()" autocomplete="off">
                    <select id="searchSelect" class="custom-select">
                        <option selected value="0">Título</option>
                        <option value="1">Autor</option>
                    </select>

                    <!-- Table -->
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Última modificación</th>
                                <th scope="col" colspan="2">Acción</th>
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
                                <td>
                                    @if ((Auth::user()->role) == "admin")
                                    <form action="{{ route('admin.destroy', $article->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                    @endif
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
