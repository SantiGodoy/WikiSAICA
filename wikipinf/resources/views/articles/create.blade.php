@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Add Article
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
      <form method="post" action="{{ route('articles.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">Article Title:</label>
              <input type="text" class="form-control" name="article_title"/>
          </div>
          <div class="form-group">
              <label for="price">Article Description :</label>
              <input type="text" class="form-control" name="article_description"/>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div>
@endsection

