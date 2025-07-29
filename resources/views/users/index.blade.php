@extends('layouts.app')

@section('title', 'Usuarios')

@section('content_header')
<h1>Usuarios registrados</h1>
@stop

@section('content')
<div class="container-fluid">
    {{-- Botón para registrar nuevo usuario --}}
    <div class="mb-3">
        <a href="{{ route('registration') }}" class="btn btn-primary" style="background-color: #3c8dbc;">
            <i class="fas fa-user-plus"></i> Registrar nuevo usuario
        </a>
    </div>

    {{-- Tarjeta contenedora --}}
    <div class="card card-info card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Lista de usuarios</h3>

            {{-- Buscador --}}
            <form method="GET" action="{{ route('users') }}">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Buscar" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default" title="Buscar">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Lista de usuarios en formato de tarjetas --}}
        <div class="row p-3">
            @forelse($users as $user)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card text-center h-100">
                    <h5 class="card-title">{{ $user->full_name }} </h5>
                    <div class="card-body">
                        <img src="{{ asset('images/cook-svgrepo-com.svg') }}" alt="User Image" class="img-circle elevation-1" style="width: 80px; height: 80px;">
                        <p class="card-text text-muted">{{ $user->email }}</p>
                        <span class="badge" style="background-color: #274472; color: white;">
                            @if($user->is_role == 1)
                            Admin
                            @else
                            Usuario
                            @endif
                        </span>
                        <p><strong>Rol:</strong> {{ $user->getRoleNames()->implode(', ') }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-around">
                        <a href="{{ route('users.view', $user->id) }}" class="btn btn-sm btn-info" style="background: #3c8dbc;" title="Ver información">
                            <i class="fas fa-eye"></i>
                        </a>

                        @if(Auth::user()->id !== $user->id)
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No hay usuarios registrados aún.</div>
            </div>
            @endforelse
        </div>


        {{-- Paginación --}}
        <div class="card-footer clearfix">
            {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@stop
