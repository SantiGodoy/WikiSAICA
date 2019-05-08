<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Editar</title>
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
                        Editar artículo
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
                        <form method="post" action="{{ route('articles.update', $article->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <label for="name">Título:</label>
                                <input type="text" class="form-control" name="article_title" value="{{ $article->title }}"/>
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
                                        CKEDITOR.instances['article_description'].setData(@json($article->description));
                                    </script>
                            </div>
                            <br>
                            <div>
                              <input multiple="multiple" name="documents[]" type="file">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
