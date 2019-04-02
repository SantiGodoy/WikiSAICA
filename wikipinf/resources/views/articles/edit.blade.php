@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
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
      </div><br />
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
@endsection

