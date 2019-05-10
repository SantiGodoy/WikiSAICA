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

            <div class="container" style= " margin-left: 0">
                <div style="margin-top: 30px; position:static; min-height:85%;">
                    <h1 id="firstHeading" class="firstHeading" >{{$article->title}}</h1>
                    <div style="text-align: left;">
                        <a href="{{ route('articles.edit',$article->id)}}">Editar</a>
                    </div>
                    <br>

                    <div class = "column" style="float: right; width: 40%; padding-left:5%;">
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

                </div>
                <div>

                  <h5>Documentos: </h5>
                  @foreach($documents as $document)
                  <a href="{{route('download',$document)}}">{{$document}}</a>
                 <br>
                  @endforeach
                </div>

                <div style="text-align: right; right: 10%; position: static; width: 100% bottom: 5%; margin-bottom: 3%;">
                       <i style="margin-right:3%;">Última modificación: {{$article->updated_at}}</i>
               </div>

            </div>
        </div>
    </body>
</html>
