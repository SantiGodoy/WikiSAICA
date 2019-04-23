<div class="sidebar-heading"><center><a href="{{url('/')}}"><img width = 170px src="{{ URL::asset('img/saica.jpg') }}"></a></center></div>
<div class="list-group list-group-flush">
    <a href="{{route('articles.index')}}" class="list-group-item list-group-item-action bg-light">Artículos</a>
    <a href="{{route('articles.create')}}" class="list-group-item list-group-item-action bg-light">Crear artículo</a>
    <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
    <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
    <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>
    @if ((Auth::user()->role) == "admin")
    <a href="{{route('admin.index')}}" class="list-group-item list-group-item-action bg-light">Admin</a>
    @endif
    <a href="{{route('logout')}}" class="list-group-item list-group-item-action bg-light">Cerrar sesión</a>
</div>