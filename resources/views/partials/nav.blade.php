<div class="sidebar-heading"><center><a href="{{url('/')}}"><img width = 170px src="{{ URL::asset('img/saica.jpg') }}"></a></center></div>
<div class="list-group list-group-flush">
    <a href="{{route('articles.create')}}" class="list-group-item list-group-item-action bg-light">Crear artículo</a>
    <a href="{{route('users.index')}}" class="list-group-item list-group-item-action bg-light">Mis artículos</a>
    @if ((Auth::user()->role) == "admin")
    <a href="{{route('admin.index')}}" class="list-group-item list-group-item-action bg-light">Admin</a>
    @endif
    @if ((Auth::user()->role) == "admin")
    <a href="{{route('version.index')}}" class="list-group-item list-group-item-action bg-light">Versiones</a>
    @endif
    <a href="{{route('logout')}}" class="list-group-item list-group-item-action bg-light">Cerrar sesión</a>
</div>
