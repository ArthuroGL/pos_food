@php
$rol = Auth::user()->is_role; // 0: Mesero, 1: Cocina, 2: Administrador
$currentRoute = Route::currentRouteName();
@endphp

{{-- BARRA LATERAL (SIDEBAR) --}}
<aside id="pos-sidebar-container" class="pos-sidebar fixed top-0 bottom-0 left-0 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40 bg-white shadow-xl flex flex-col w-72 h-screen">

    {{-- Botón Flotante / Semi-integrado de Cierre (Estilo POS Moderno) --}}

    <button onclick="togglePosSidebar()"
        id="pos-sidebar-close-trigger"
        class="absolute top-6 -right-4 h-8 w-8 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-orange-600 shadow-md hover:shadow-lg flex items-center justify-center cursor-pointer transition-all duration-300 z-50 hover:scale-105 active:scale-95 group focus:outline-none hidden">
        <i id="pos-collapse-icon" class="fas fa-chevron-left text-xs transition-transform duration-300"></i>
    </button>

    <div class="flex flex-col flex-1 px-4 py-6 overflow-y-auto">

        {{-- Encabezado e Identidad --}}
        <div class="flex items-center justify-between pb-5 mb-5 border-b border-slate-200 shrink-0">
            <div class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-500 text-white">
                    <i class="fas fa-utensils text-sm"></i>
                </span>
                <div class="leading-none">
                    <h1 class="text-sm font-black text-slate-950 uppercase tracking-wider m-0">Comandas</h1>
                    <span class="text-[10px] font-bold text-slate-400 tracking-tight">Estación Operativa</span>
                </div>
            </div>
            {{-- Botón de cierre clásico para Móviles --}}
            <button onclick="togglePosSidebar()" class="md:hidden text-slate-400 hover:text-slate-900 p-1 cursor-pointer focus:outline-none">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        {{-- Operador Activo --}}
        <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl mb-5 shrink-0">
            <div class="relative shrink-0">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg overflow-hidden bg-slate-200 text-slate-700">
                    @if(Auth::user()->foto_de_perfil)
                    <img src="{{ asset('storage/' . Auth::user()->foto_de_perfil) }}"
                        alt="{{ Auth::user()->name }}"
                        class="h-full w-full object-cover">
                    @else
                    <span class="font-black text-sm font-mono">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </span>
                    @endif
                </div>
                <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-500 border-2 border-white"></span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-black text-slate-950 truncate m-0 leading-tight">{{ Auth::user()->name }}</p>
                <div class="mt-1">
                    @if($rol == 2)
                    <span class="badge-rol-admin">Administrador</span>
                    @elseif($rol == 1)
                    <span class="badge-rol-cocina">Cocina</span>
                    @else
                    <span class="badge-rol-mesero">Mesero</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Navegación Plana --}}
        <nav class="flex-1 space-y-1">
            <span class="pos-sidebar-header">Menú Principal</span>

            @php
            $dashboardRoute = $rol == 2 ? 'admin.dashboard' : ($rol == 1 ? 'cocina.dashboard' : 'mesero.dashboard');
            @endphp
            <a href="{{ route($dashboardRoute) }}"
                class="{{ $currentRoute === $dashboardRoute ? 'pos-sidebar-link-active' : 'pos-sidebar-link' }}">
                <i class="fas fa-home text-sm shrink-0 w-5 text-center"></i>
                <span>Inicio</span>
            </a>

            <span class="pos-sidebar-header">Operación</span>

            @if(in_array($rol, [0, 2]))
            <a href="{{ route('productos.index') }}"
                class="{{ str_contains($currentRoute, 'productos') ? 'pos-sidebar-link-active' : 'pos-sidebar-link' }}">
                <i class="fas fa-box text-sm shrink-0 w-5 text-center"></i>
                <span>Productos</span>
            </a>
            @endif

            @if(in_array($rol, [0, 2]))
            <a href="{{ route('comandas.index') }}"
                class="{{ str_contains($currentRoute, 'comandas.index') || Request::is('comandas') ? 'pos-sidebar-link-active' : 'pos-sidebar-link' }}">
                <i class="fas fa-list-alt text-sm shrink-0 w-5 text-center"></i>
                <span>Ver Comandas</span>
            </a>
            @endif

            @if(in_array($rol, [1, 2]))
            <a href="{{ route('comandas.vistaCocina') }}"
                class="{{ $currentRoute === 'comandas.vistaCocina' ? 'pos-sidebar-link-active' : 'pos-sidebar-link' }}">
                <i class="fas fa-fire text-sm shrink-0 w-5 text-center"></i>
                <span>Cocina</span>
            </a>
            @endif

            @if($rol == 2)
            <span class="pos-sidebar-header">Control Interno</span>

            <a href="{{ route('reportes.index') }}"
                class="{{ str_contains($currentRoute, 'reportes') ? 'pos-sidebar-link-active' : 'pos-sidebar-link' }}">
                <i class="fas fa-chart-bar text-sm shrink-0 w-5 text-center"></i>
                <span>Reportes</span>
            </a>

            <a href="{{ route('users') }}"
                class="{{ $currentRoute === 'users' || str_contains($currentRoute, 'registration') ? 'pos-sidebar-link-active' : 'pos-sidebar-link' }}">
                <i class="fas fa-users text-sm shrink-0 w-5 text-center"></i>
                <span>Usuarios</span>
            </a>
            @endif
        </nav>
    </div>
</aside>

{{-- Cortina translúcida unificada (Soporta clics externos en Desktop y Móvil) --}}
<div id="sidebar-overlay" onclick="togglePosSidebar()" class="fixed inset-0 bg-slate-900/10 backdrop-blur-[1px] z-30 hidden transition-opacity duration-300 opacity-0 cursor-pointer"></div>

{{-- BARRA SUPERIOR (NAVBAR) --}}
<header id="pos-navbar" class="fixed top-0 right-0 z-10 flex h-20 w-full md:w-[calc(100%-18rem)] items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6 transition-all duration-300 ease-in-out">

    {{-- Trigger + Métricas de la terminal --}}
    <div class="flex items-center gap-4">
        {{-- Botón Hamburguesa Alternativo --}}
        <button onclick="togglePosSidebar()" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 active:scale-95 transition-all cursor-pointer focus:outline-none">
            <i id="pos-hamburger-icon" class="fas fa-bars text-sm"></i>
        </button>

        <div class="h-4 w-[1px] bg-slate-200"></div>

        <div class="flex items-center gap-2">
            <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-slate-500 font-mono">
                Terminal: <span class="text-slate-950">EST_01</span>
            </span>
        </div>

        <div class="h-4 w-[1px] bg-slate-200 hidden lg:block"></div>

        {{-- Reloj de Estación --}}
        <div class="text-[10px] font-black uppercase tracking-widest text-orange-600 block mb-1 font-mono">
            <i class="fas fa-clock mr-1 animate-pulse"></i>
            <span id="navbar-live-clock" class="text-xs sm:text-sm font-black font-mono text-orange-950 tracking-tight">00:00:00</span>
        </div>
    </div>

    {{-- Acciones Globales --}}
    <div class="flex items-center gap-4">
        <div class="hidden sm:flex flex-col text-right leading-tight">
            <span class="text-[9px] font-black text-slate-400 font-mono uppercase tracking-wider">Fecha</span>
            <span class="text-xs font-black text-slate-900 mt-0.5">
                {{ Carbon\Carbon::now()->format('d/m/Y') }}
            </span>
        </div>

        <div class="h-8 w-[1px] bg-slate-200 hidden sm:block"></div>

        <button onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();"
            class="inline-flex items-center justify-center gap-2 h-10 px-4 border border-rose-200 hover:border-rose-300 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer active:scale-95 focus:outline-none">
            <i class="fas fa-power-off text-xs"></i>
            <span class="hidden sm:inline">Salir</span>
        </button>
    </div>
</header>

<form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

<script>
    function togglePosSidebar() {
        const sidebar = document.getElementById('pos-sidebar-container');
        const navbar = document.getElementById('pos-navbar');
        const mainContent = document.getElementById('main-content');
        const overlay = document.getElementById('sidebar-overlay');
        const closeTrigger = document.getElementById('pos-sidebar-close-trigger');
        const collapseIcon = document.getElementById('pos-collapse-icon');
        const isMobile = window.innerWidth < 768;

        if (isMobile) {
            // --- MÓVIL (Comportamiento Drawer clásico) ---
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.add('opacity-100'), 10);
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.remove('opacity-100');
                setTimeout(() => overlay.classList.add('hidden'), 300);
                document.body.style.overflow = '';
            }
        } else {
            // --- DESKTOP / TABLETS (Ajuste estructural dinámico) ---
            if (sidebar.classList.contains('md:translate-x-0')) {
                // COLAPSAR MENÚ
                sidebar.classList.remove('md:translate-x-0');
                sidebar.classList.add('md:-translate-x-full');

                navbar.classList.remove('md:w-[calc(100%-18rem)]');
                navbar.classList.add('w-full');

                mainContent.classList.remove('md:pl-72');
                mainContent.classList.add('md:pl-0');

                // OCULTAR la flecha flotante por completo al cerrar
                if (closeTrigger) {
                    closeTrigger.classList.add('hidden');
                    closeTrigger.classList.remove('md:flex');
                }

                // Ocultar overlay en escritorio de forma limpia
                overlay.classList.remove('opacity-100');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            } else {
                // EXPANDIR MENÚ
                sidebar.classList.remove('md:-translate-x-full');
                sidebar.classList.add('md:translate-x-0');

                navbar.classList.remove('w-full');
                navbar.classList.add('md:w-[calc(100%-18rem)]');

                mainContent.classList.remove('md:pl-0');
                mainContent.classList.add('md:pl-72');

                // MOSTRAR la flecha flotante cuando el menú está visible
                if (closeTrigger) {
                    closeTrigger.classList.remove('hidden');
                    closeTrigger.classList.add('md:flex');
                }
                if (collapseIcon) {
                    collapseIcon.classList.remove('rotate-180');
                }

                // Activar overlay sutil para permitir el clic de cierre externo
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.add('opacity-100'), 10);
            }
        }
    }

    // Persistencia y manejo dinámico del redimensionamiento de pantalla
    window.addEventListener('resize', () => {
        const overlay = document.getElementById('sidebar-overlay');
        // Si cambia drásticamente el tamaño limpia los estados intermedios del overlay y scroll
        if (window.innerWidth >= 768) {
            document.body.style.overflow = '';
        } else {
            const sidebar = document.getElementById('pos-sidebar-container');
            if (sidebar && sidebar.classList.contains('-translate-x-full')) {
                overlay.classList.add('hidden');
                overlay.classList.remove('opacity-100');
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const navbarClock = document.getElementById('navbar-live-clock');

        function updateGlobalClock() {
            const now = new Date();
            if (navbarClock) {
                navbarClock.textContent = String(now.getHours()).padStart(2, '0') + ':' +
                    String(now.getMinutes()).padStart(2, '0') + ':' +
                    String(now.getSeconds()).padStart(2, '0');
            }
        }
        updateGlobalClock();
        setInterval(updateGlobalClock, 1000);
    });
</script>
