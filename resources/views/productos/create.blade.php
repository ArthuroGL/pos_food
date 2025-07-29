@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<h2 class="text-xl font-semibold mb-4">Nuevo producto</h2>

<form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">

    @csrf
    <div class="form-group">
        <label for="imagen">Imagen del producto:</label>
        <input type="file" name="imagen" id="imagen" class="form-control-file">
    </div>

    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required class="form-control">
    </div>

    <div class="form-group">
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" step="0.01" required class="form-control">
    </div>

    <div class="form-group">
        <label for="categoria_id">Categoría:</label>
        <select name="categoria_id" id="categoria_id" class="form-control" required>
            @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}">{{ ucfirst($categoria->nombre) }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="3" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label>Complementos:</label>
        <div class="form-check">
            <label><input type="checkbox" name="complementos[]" value="cebolla"> Cebolla</label>
        </div>
        <div class="form-check">
            <label><input type="checkbox" name="complementos[]" value="cilantro"> Cilantro</label>
        </div>
        <div class="form-check">
            <label><input type="checkbox" name="complementos[]" value="lechuga"> Lechuga</label>
        </div>
        <div class="form-check">
            <label><input type="checkbox" name="complementos[]" value="queso"> Queso</label>
        </div>
        <div class="form-check">
            <label><input type="checkbox" name="complementos[]" value="crema"> Crema</label>
        </div>
    </div>

    <button type="submit" class="btn btn-success mt-3">Guardar producto</button>
</form>
@endsection
