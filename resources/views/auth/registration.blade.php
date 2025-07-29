@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow">
                <div class="card-header bg-primary text-white">Registro de Usuario</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registration_post') }}">
                        @csrf

                        {{-- Nombre --}}
                        <div class="form-group mb-3">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        {{-- Apellidos --}}
                        <div class="form-row mb-3">
                            <div class="col">
                                <label>Apellido Paterno</label>
                                <input type="text" name="apellido_p" class="form-control" value="{{ old('apellido_p') }}" required>
                            </div>
                            <div class="col">
                                <label>Apellido Materno</label>
                                <input type="text" name="apellido_m" class="form-control" value="{{ old('apellido_m') }}" required>
                            </div>
                        </div>

                        {{-- Edad y Género --}}
                        <div class="form-row mb-3">
                            <div class="col">
                                <label>Edad</label>
                                <input type="number" name="edad" class="form-control" value="{{ old('edad') }}" required>
                            </div>
                            <div class="col">
                                <label>Género</label>
                                <select name="genero" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                        </div>

                        {{-- Tipo de Sangre y Alergias --}}
                        <div class="form-row mb-3">
                            <div class="col">
                                <label>Tipo de Sangre</label>
                                <input type="text" name="tipo_sangre" class="form-control" value="{{ old('tipo_sangre') }}">
                            </div>
                            <div class="col">
                                <label>Alergias</label>
                                <input type="text" name="alergias" class="form-control" value="{{ old('alergias') }}">
                            </div>
                        </div>

                        {{-- CURP --}}
                        <div class="form-group mb-3">
                            <label>CURP</label>
                            <input type="text" name="curp" class="form-control" value="{{ old('curp') }}" required maxlength="18">
                        </div>

                        {{-- Email, Phone, Mobile --}}
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col">
                                <label>Teléfono</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required maxlength="10">
                            </div>
                            <div class="col">
                                <label>Celular</label>
                                <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}" required maxlength="10">
                            </div>
                        </div>

                        {{-- Rol --}}
                        <div class="form-group mb-3">
                            <label>Tipo de Rol</label>
                            <select name="is_role" class="form-control" required>
                                <option value="">Seleccionar Rol</option>
                                <option value="2" {{ old('is_role') == '2' ? 'selected' : '' }}>Administrador</option>
                                <option value="1" {{ old('is_role') == '1' ? 'selected' : '' }}>Cocina</option>
                                <option value="0" {{ old('is_role') == '0' ? 'selected' : '' }}>Mesero</option>
                            </select>
                        </div>

                        {{-- Contraseña --}}
                        <div class="form-group mb-3">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
