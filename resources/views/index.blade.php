@extends('layout')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
    <script src="main.js"></script>
</head>
<body>
    <div class="d-flex" id="wrapper">
    <div class="bg-light border-right" id="sidebar-wrapper">
    @include('nav')
</div>
</div>
</body>
</html>