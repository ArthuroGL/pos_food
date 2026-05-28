@extends('layouts.app')
@section('title', 'Panel de Meseros')
@section('content_header', 'Panel de Control')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Comidas</h3>
                <p>Gestión de platillos</p>
            </div>
            <div class="icon"><i class="fas fa-hamburger"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Mesas</h3>
                <p>Administrar ubicación</p>
            </div>
            <div class="icon"><i class="fas fa-chair"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>Productos</h3>
                <p>Inventario general</p>
            </div>
            <div class="icon"><i class="fas fa-boxes"></i></div>
        </div>
    </div>
</div>
@endsection
