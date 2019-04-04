@extends('layout')

<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
<script src="https://cdn.ckeditor.com/4.11.3/standard-all/ckeditor.js"></script>

<div class="d-flex" id="wrapper">
<div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Start Bootstrap </div>
      <div class="list-group list-group-flush">
        <a href="{{route('articles.index')}}" class="list-group-item list-group-item-action bg-light">Home</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Shortcuts</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>
      </div>
    </div>
<style>
  .uper {
    margin-top: 40px;
  }
</style>
@section('content')
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
    <div class="container-fluid">
      <form method="post" action="{{ route('articles.store') }}">
        <div class="form-group">
              @csrf
              <label for="name">Article Title:</label>
              <input type="text" class="form-control" name="article_title"/>
        </div>
          <div class="form-group">
              <label for="price">Article Description :</label>
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

          <button type="submit" class="btn btn-primary">Add</button>
      </form>
    </div>
  </div>
</div>
@endsection
