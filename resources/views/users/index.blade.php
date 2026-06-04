@extends('layouts.pos')

@section('title', 'Usuarios')
@section('view_title', '👥 Control de Personal')
@section('view_subtitle', 'Gestión de accesos, roles y perfiles operativos del sistema')

@section('content')
<div class="h-full w-full p-6 overflow-y-auto sheet-layout bg-slate-100 text-slate-800 scroll-custom flex flex-col">

    {{-- Contenedor de Centrado Maestro --}}
    <div class="w-full max-w-6xl mx-auto flex flex-col flex-1 gap-6">

        {{-- CABECERA: Títulos, Búsqueda y Botón de Registro --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight m-0">Usuarios registrados</h2>
                <p class="text-xs font-medium text-slate-400 mt-1 m-0">Lista de personal con permisos activos en la plataforma</p>
            </div>

            {{-- Bloque de herramientas alineado --}}
            <div class="w-full lg:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                {{-- Buscador Estilizado --}}
                <form method="GET" action="{{ route('users') }}" class="m-0 relative flex-1 sm:flex-initial">
                    <input type="text" name="search"
                           class="w-full sm:w-64 bg-white border border-slate-200 focus:border-orange-500 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-700 transition-all outline-hidden shadow-3xs placeholder-slate-400"
                           placeholder="Buscar usuario..." value="{{ request('search') }}">
                    <button type="submit" class="absolute right-3 inset-y-0 flex items-center text-slate-400 hover:text-slate-600 bg-transparent border-0 cursor-pointer text-xs" title="Buscar">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                {{-- Botón de Acción Principal --}}
                <a href="{{ route('registration') }}"
                   class="bg-orange-600 hover:bg-orange-700 active:scale-[0.98] transition-all text-white font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-orange-600/20 border-0 uppercase">
                    <i class="fas fa-user-plus text-xs"></i> Registrar nuevo usuario
                </a>
            </div>
        </div>

        {{-- GRID DE TARJETAS DE USUARIOS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($users as $user)
                <div class="group bg-white border border-slate-200 rounded-2xl p-5 flex flex-col items-center text-center shadow-2xs transition-all duration-300 hover:shadow-md hover:border-slate-300 relative overflow-hidden">

                    {{-- Indicador sutil de Rol en la esquina superior --}}
                    <div class="absolute top-3 right-3">
                        @if($user->is_role == 2)
                            <span class="bg-slate-900 text-white font-mono text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md">
                                Admin
                            </span>
                        @elseif($user->is_role == 1)
                            <span class="bg-orange-600 text-white font-mono text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md">
                                Cocina
                            </span>
                        @else
                            <span class="bg-slate-100 text-slate-600 border border-slate-200 font-mono text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md">
                                Staff
                            </span>
                        @endif
                    </div>

                    {{-- Contenedor de Avatar Modificado --}}
                    <div class="h-20 w-20 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center p-1 mb-4 shrink-0 shadow-3xs group-hover:scale-105 transition-transform duration-300 overflow-hidden">
                        <img src="{{ $user->profile_avatar_url }}"
                             alt="Avatar de {{ $user->name }}"
                             class="w-full h-full object-cover rounded-full"
                             onerror="this.onerror=null; this.src='{{ asset('images/cook-svgrepo-com.svg') }}'; this.className='w-full h-full object-contain';">
                    </div>

                    {{-- Datos Informativos --}}
                    <div class="w-full flex-1 min-w-0 mb-4">
                        <strong class="text-base font-black text-slate-900 tracking-tight block truncate" title="{{ $user->full_name }}">
                            {{ $user->full_name }}
                        </strong>
                        <span class="text-[11px] font-medium text-slate-400 block truncate mb-2" title="{{ $user->email }}">
                            {{ $user->email }}
                        </span>

                        <div class="inline-flex items-center gap-1 bg-orange-50 text-orange-800 border border-orange-100 px-2.5 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wide">
                            <i class="fas fa-shield-alt text-[9px] text-orange-400"></i>
                            {{ $user->getRoleNames()->implode(', ') ?: 'Sin Rol asignado' }}
                        </div>
                    </div>

                    {{-- Fila de Acciones / Controles Inferiores --}}
                    <div class="w-full pt-3 border-t border-slate-100 flex items-center justify-center gap-2">
                        {{-- Botón: Ver Ficha --}}
                        <a href="{{ route('users.view', $user->id) }}"
                           class="h-9 flex-1 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold rounded-xl flex items-center justify-center gap-1.5 border border-slate-200 transition-all shadow-3xs text-xs active:scale-95"
                           title="Ver expediente completo">
                            <i class="fas fa-eye text-[11px] text-slate-400"></i> Ver Perfil
                        </a>

                        {{-- Botón: Eliminar Seguro --}}
                        @if(Auth::user()->id !== $user->id)
                            <form action="{{ route('users.destroy', $user->id) }}"
                                  method="POST"
                                  class="m-0 form-eliminar-usuario">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="confirmarBajaUsuario(this, '{{ $user->full_name }}')"
                                        class="h-9 w-9 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl flex items-center justify-center border border-rose-200 transition-all shadow-3xs active:scale-95 cursor-pointer"
                                        title="Dar de baja del sistema">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-2xs">
                    <div class="flex flex-col items-center justify-center text-slate-300 gap-3">
                        <i class="fas fa-users-slash text-4xl"></i>
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            No se encontraron usuarios que coincidan con la búsqueda
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- SECCIÓN INFERIOR: Paginación Estilizada --}}
        @if($users->hasPages())
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-2xs flex justify-center custom-pagination-wrapper">
                {{ $users->appends(['search' => request('search')])->links() }}
            </div>
        @endif

    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmarBajaUsuario(button, nombreUsuario) {
        const form = button.closest('.form-eliminar-usuario');

        Swal.fire({
            title: '¿Revocar acceso?',
            text: `El usuario "${nombreUsuario}" perderá todos los permisos de ingreso al sistema POS.`,
            icon: 'warning',
            style: 'margin: 0',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, dar de baja',
            cancelButtonText: 'Conservar',
            background: '#ffffff',
            color: '#0f172a',
            customClass: {
                popup: 'rounded-2xl border border-slate-200 shadow-xl font-sans',
                title: 'text-lg font-black text-slate-900 tracking-tight',
                htmlContainer: 'text-xs font-medium text-slate-500',
                confirmButton: 'rounded-xl px-4 py-2.5 text-xs font-bold uppercase tracking-wide border-0',
                cancelButton: 'rounded-xl px-4 py-2.5 text-xs font-bold uppercase tracking-wide border-0'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection
