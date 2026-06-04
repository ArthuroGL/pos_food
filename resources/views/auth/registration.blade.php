@extends('layouts.pos')

@section('title', 'Registro de Usuario')
@section('view_title', '🔐 Alta de Personal')
@section('view_subtitle', 'Configura credenciales de acceso y perfiles de seguridad')

@section('content')
<div class="h-full w-full p-6 overflow-y-auto sheet-layout bg-slate-100 text-slate-800 scroll-custom flex flex-col">

    {{-- Contenedor de Centrado Maestro (Mismo ancho controlado de Formularios) --}}
    <div class="w-full max-w-4xl mx-auto flex flex-col flex-1">

        {{-- Cabecera con Botón de Regreso Integrado --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 w-full">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight m-0">Registro de nuevo usuario</h2>
                <p class="text-xs font-medium text-slate-400 mt-1 m-0">Llena la ficha administrativa del empleado para conceder acceso</p>
            </div>
            <a href="{{ route('users') }}"
               class="w-full sm:w-auto bg-slate-200 hover:bg-slate-300 active:scale-[0.98] transition-all text-slate-700 font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 border border-slate-300 uppercase">
                <i class="fas fa-arrow-left text-[10px]"></i> Cancelar y volver
            </a>
        </div>

        {{-- Tarjeta Maestra del Formulario --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden w-full mb-6">
            {{-- ⚠️ SE AGREGÓ: enctype="multipart/form-data" para permitir subida de archivos --}}
            <form method="POST" action="{{ route('registration_post') }}" enctype="multipart/form-data" class="m-0">
                @csrf

                <div class="p-6 md:p-8 space-y-6">

                    {{-- 📸 BLOQUE NUEVO: Carga e Identidad Visual del Operario --}}
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-orange-600 block mb-4 pb-1 border-b border-slate-100">
                            📸 Identidad Visual del Empleado
                        </span>

                        <div class="flex flex-col sm:flex-row items-center gap-6 bg-slate-50 border border-slate-200 p-5 rounded-2xl">
                            {{-- Previsualizador Circular --}}
                            <div class="relative h-24 w-24 bg-white border border-slate-200 rounded-full flex items-center justify-center p-1.5 shadow-2xs overflow-hidden shrink-0">
                                <img id="registration-avatar-preview"
                                     src="{{ asset('images/cook-svgrepo-com.svg') }}"
                                     alt="Previsualización"
                                     class="w-full h-full object-contain">
                            </div>

                            {{-- Selector y Especificaciones --}}
                            <div class="w-full flex flex-col justify-center text-center sm:text-left">
                                <label class="text-xs font-black uppercase tracking-wider text-slate-500 block mb-1">Fotografía del Perfil</label>
                                <p class="text-[11px] font-medium text-slate-400 mb-3">Formatos admitidos: JPG, JPEG o PNG. Peso máximo: 2MB.</p>

                                <div class="flex flex-col sm:flex-row gap-2">
                                    {{-- Input nativo oculto por estética corporativa --}}
                                    <input type="file" name="foto_de_perfil" id="foto_de_perfil" class="hidden" accept="image/*" onchange="previewRegistrationImage(this)">
                                    <button type="button"
                                            onclick="document.getElementById('foto_de_perfil').click()"
                                            class="bg-white hover:bg-slate-100 active:scale-[0.98] transition-all text-slate-700 font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 border border-slate-200 uppercase shadow-2xs">
                                        <i class="fas fa-image text-slate-400 text-xs"></i> Seleccionar Imagen
                                    </button>
                                    <button type="button"
                                            id="btn-remove-preview"
                                            onclick="resetRegistrationImage()"
                                            class="hidden bg-red-50 hover:bg-red-100 transition-all text-red-600 font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer items-center justify-center gap-2 border border-red-200 uppercase">
                                        <i class="fas fa-trash-alt text-xs"></i> Quitar
                                    </button>
                                </div>
                                @error('foto_de_perfil')
                                    <span class="text-red-500 text-xs font-black uppercase tracking-wide mt-2 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BLOQUE 1: Información de Identidad --}}
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-orange-600 block mb-4 pb-1 border-b border-slate-100">
                            📂 1. Información Personal Básica
                        </span>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            {{-- Nombre --}}
                            <div class="md:col-span-1">
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Nombre(s)</label>
                                <input type="text" name="name" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-hidden shadow-2xs"
                                       value="{{ old('name') }}" required autocomplete="off">
                            </div>

                            {{-- Apellido Paterno --}}
                            <div>
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Apellido Paterno</label>
                                <input type="text" name="apellido_p" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-hidden shadow-2xs"
                                       value="{{ old('apellido_p') }}" required autocomplete="off">
                            </div>

                            {{-- Apellido Materno --}}
                            <div>
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Apellido Materno</label>
                                <input type="text" name="apellido_m" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-hidden shadow-2xs"
                                       value="{{ old('apellido_m') }}" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    {{-- BLOQUE 2: Datos Médicos e Identificación Oficial --}}
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-orange-600 block mb-4 pb-1 border-b border-slate-100">
                            🩺 2. Indicadores Clínicos e Identificación
                        </span>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-5">
                            {{-- Edad --}}
                            <div class="md:col-span-1">
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Edad</label>
                                <input type="number" name="edad" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-black font-mono text-slate-800 transition-all outline-hidden shadow-2xs"
                                       value="{{ old('edad') }}" required>
                            </div>

                            {{-- Género --}}
                            <div class="md:col-span-1">
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Género</label>
                                <div class="relative">
                                    <select name="genero" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-700 transition-all outline-hidden shadow-2xs appearance-none cursor-pointer" required>
                                        <option value="" disabled selected>Elegir...</option>
                                        <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400 text-xs">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Tipo de Sangre --}}
                            <div class="md:col-span-1">
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Tipo de Sangre</label>
                                <input type="text" name="tipo_sangre" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-hidden shadow-2xs"
                                       value="{{ old('tipo_sangre') }}" placeholder="Ej. O+">
                            </div>

                            {{-- Alergias --}}
                            <div class="md:col-span-2">
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Alergias o Restricciones</label>
                                <input type="text" name="alergias" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-hidden shadow-2xs"
                                       value="{{ old('alergias') }}" placeholder="Ninguna, medicamentos, etc.">
                            </div>

                            {{-- CURP --}}
                            <div class="col-span-full">
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Clave Única de Registro de Población (CURP)</label>
                                <input type="text" name="curp" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-mono font-black uppercase tracking-widest text-slate-800 transition-all outline-hidden shadow-2xs"
                                       value="{{ old('curp') }}" required maxlength="18" placeholder="18 caracteres alfanuméricos">
                            </div>
                        </div>
                    </div>

                    {{-- BLOQUE 3: Contacto y Roles Operativos --}}
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-orange-600 block mb-4 pb-1 border-b border-slate-100">
                            📞 3. Canales de Contacto y Rol de Seguridad
                        </span>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            {{-- Email --}}
                            <div class="md:col-span-3">
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Dirección de Correo Electrónico (Login)</label>
                                <input type="email" name="email" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-hidden shadow-2xs"
                                       value="{{ old('email') }}" required placeholder="usuario@comandaspos.com">
                            </div>

                            {{-- Teléfono --}}
                            <div>
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Teléfono Fijo</label>
                                <input type="text" name="phone" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-mono font-bold text-slate-800 transition-all outline-hidden shadow-2xs"
                                       value="{{ old('phone') }}" required maxlength="10" placeholder="10 dígitos">
                            </div>

                            {{-- Celular --}}
                            <div>
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Teléfono Celular</label>
                                <input type="text" name="mobile" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-mono font-bold text-slate-800 transition-all outline-hidden shadow-2xs"
                                       value="{{ old('mobile') }}" required maxlength="10" placeholder="WhatsApp / Urgencias">
                            </div>

                            {{-- Tipo de Rol --}}
                            <div>
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Asignación de Rol</label>
                                <div class="relative">
                                    <select name="is_role" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-black text-slate-700 transition-all outline-hidden shadow-2xs appearance-none cursor-pointer" required>
                                        <option value="" disabled selected>Seleccionar Nivel...</option>
                                        <option value="2" {{ old('is_role') == '2' ? 'selected' : '' }}>🔑 Administrador</option>
                                        <option value="1" {{ old('is_role') == '1' ? 'selected' : '' }}>🍳 Personal de Cocina</option>
                                        <option value="0" {{ old('is_role') == '0' ? 'selected' : '' }}>🤵 Mesero / Operativo</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400 text-xs">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BLOQUE 4: Contraseñas --}}
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-orange-600 block mb-4 pb-1 border-b border-slate-100">
                            🛡️ 4. Llaves de Seguridad
                        </span>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            {{-- Contraseña --}}
                            <div>
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Contraseña de Acceso</label>
                                <input type="password" name="password" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-hidden shadow-2xs" required>
                            </div>

                            {{-- Confirmar Contraseña --}}
                            <div>
                                <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-hidden shadow-2xs" required>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer con Botón de Registro --}}
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                    <button type="submit"
                            class="w-full sm:w-auto bg-orange-600 hover:bg-orange-700 active:scale-[0.98] transition-all text-white font-black px-8 py-3.5 rounded-xl text-sm tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-orange-600/20 border-0 uppercase">
                        <i class="fas fa-save text-xs"></i> Registrar y Dar de Alta
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    const defaultAvatar = "{{ asset('images/cook-svgrepo-com.svg') }}";

    function previewRegistrationImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('registration-avatar-preview');
                previewImg.src = e.target.result;
                // Hacer que la imagen cubra el contenedor circular de forma uniforme
                previewImg.classList.remove('object-contain');
                previewImg.classList.add('object-cover', 'rounded-full');

                // Mostrar el botón de quitar de manera interactiva
                const btnRemove = document.getElementById('btn-remove-preview');
                btnRemove.classList.remove('hidden');
                btnRemove.classList.add('flex');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetRegistrationImage() {
        const fileInput = document.getElementById('foto_de_perfil');
        const previewImg = document.getElementById('registration-avatar-preview');
        const btnRemove = document.getElementById('btn-remove-preview');

        fileInput.value = ""; // Limpia el archivo del input
        previewImg.src = defaultAvatar; // Vuelve al estado base
        previewImg.classList.remove('object-cover', 'rounded-full');
        previewImg.classList.add('object-contain');

        btnRemove.classList.remove('flex');
        btnRemove.classList.add('hidden');
    }
</script>
@endsection
