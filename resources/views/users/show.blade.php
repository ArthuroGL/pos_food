@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="container">
    <h1>Detalles del usuario</h1>
    <p><strong>Nombre:</strong> {{ $user->full_name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Teléfono:</strong> {{ $user->phone }}</p>
    <p><strong>Rol:</strong> {{ $user->getRoleNames()->implode(', ') }}</p>
</div>
@endsection
