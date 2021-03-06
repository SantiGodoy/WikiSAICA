<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Nuevo artículo</title>
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
                <div class="card uper">
                    <div class="card-header">
                        Añadir artículo
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <br>
                        @endif
                        <div class="container-fluid">
                            <form method="post" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                                <div class="form-group">
                                    @csrf
                                    <label for="name">Título:</label>
                                    <input type="text" class="form-control" name="article_title" autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <label for="price">Descripción:</label>
                                    <textarea style="width: 100%;" id ="article_description" name="article_description"></textarea><br/>
                                    <script>
                                        CKEDITOR.replace('article_description', {
                                        fullPage: false,
                                        extraPlugins: 'docprops',
                                        // Disable content filtering because if you use full page mode, you probably
                                        // want to  freely enter any HTML content in source mode without any limitations.
                                        allowedContent: true,
                                        height: 350
                                        });
                                    </script>
                                    <script>
                                        function getData() {
                                        //Get data written in first Editor
                                        var editor_data = CKEDITOR.instances['article_description'].getData();
                                        //Set data in Second Editor which is written in first Editor
                                        document.getElementById("description").innerHTML = editor_data;
                                    }
                                    </script>
                                </div>
                                <br>
                                <div>
                                  <input multiple="multiple" name="documents[]" type="file">
                                </div>
                                <br>
                                <div class="form-group mb-2">
                                <label for="Department">Departmento</label>
                                <select class="form-control" style="width: 250px" id="Department" name="Department">
                                    <option value=0>Laboratorio</option>
                                    <option value=1>Máquinas</option>
                                    <option value=2>SGMI</option>
                                    <option value=3>Informática</option>
                                    <option value=4>Calidad</option>
                                    <option value=5>Comercial</option>
                                    <option value=6>RRHH</option>
                                    <option value=7>Adminstración</option>
                                    <option value=8>Operaciones</option>
                                </select>
  </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Añadir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
