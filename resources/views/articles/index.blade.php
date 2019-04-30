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
                        <thead>
                            <tr>
                                <td>Article Title</td>
                                <td>Article Description</td>
                                <td colspan="2">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                                <td><a href="{{ route('articles.show',$article->id)}}">{{$article->title}}</a></td>
                                <td id={{$article->id}}>{{$article->description}}</td>
                                <script type="text/javascript">
                                    var id = @json($article->id);
                                    document.getElementById(id).innerHTML = @json($article->description);
                                </script>
                                <td><a href="{{ route('articles.edit',$article->id)}}" class="btn btn-primary">Edit</a></td>
                                <td>
                                    <form action="{{ route('articles.destroy', $article->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        @if ((Auth::user()->role) == "admin")
                                        <button class="btn btn-danger" type="submit">Delete</button>
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
