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
                <div style="margin-top: 30px;">
                    <h1 id="firstHeading" class="firstHeading" >{{$article->title}}</h1>
                    <div style="text-align: left;">
                        <a href="{{ route('articles.edit',$article->id)}}">Edit</a>
                    </div>
                    <br>

                    <div class = "column" style="float: right; width: 30%">
                        <table class="table table-bordered">
                          <tbody>
                            <tr>
                              <td>Creado por</td>
                              <td class="text-left">{{$user->name}}</td>
                            </tr>
                            <tr>
                              <td>Último usuario modificado</td>
                              <td style="text-align: left">{{$userUpdate->name}}</td>
                            </tr>
                              <tr>
                              <td>Fecha de creación</td>
                              <td style="text-align: left">{{$article->created_at}}</td>
                            </tr>
                             <tr>
                              <td>Departamento</td>
                              <td style="text-align: left">{{$department->name}}</td>
                            </tr>
                          </tbody>
                        </table>
                    </div>

                         <div id={{$article->id}}>{{$article->description}}>
                        <script type="text/javascript">
                            var id = @json($article->id);
                            document.getElementById(id).innerHTML = @json($article->description);
                        </script>

                        </div>
                        <br>
                     <div style="text-align: right; right: 5%; position: absolute; width: 100% bottom: 5%; margin-bottom: 3%">
                            <i>Last modified: {{$article->updated_at}}</i>
                    </div>
                </div>

            </div>

        </div>
    </body>
</html>
