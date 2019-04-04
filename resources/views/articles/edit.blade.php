@extends('layout')
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
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

            @section('content')
            <div class="card uper">
                <div class="card-header">
                    Edit Articles
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
                            <label for="name">Article Name:</label>
                            <input type="text" class="form-control" name="article_title" value={{ $article->title }} />
                        </div>
                        <div class="form-group">
                            <label for="price">Article Description :</label>
                            <input type="text" class="form-control" name="article_description" value={{ $article->description }} />
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
        @endsection
    </body>
</html>