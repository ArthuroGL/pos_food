<aside class="main-sidebar sidebar-light-navy elevation-4">
    <!-- Logo -->
    <div class="brand-link text-center">
        <img src="{{ asset('images/food-dinner-svgrepo-com.svg') }}" alt="Logo Empresa" style="max-height: 40px;">
    </div>

    <div class="sidebar">
        <!-- Panel de Usuario -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center text-center">
            <div class="image">
                <img src="{{ asset('images/user-id-svgrepo-com.svg') }}" class="img-circle mb-1" alt="User Image" style="width: 60px; height: 60px;">
            </div>
            <div class="info">
                <p class="d-block text mt-2">{{ Auth::user()->name }}</p>
                <span class="text small font-weight-bold">
                    @if(Auth::user()->is_role == 2)
                        Administrador
                    @elseif(Auth::user()->is_role == 1)
                        Cocina
                    @else
                        Mesero
                    @endif
                </span>
                <div class="text small">{{ Auth::user()->email }}</div>
            </div>
        </div>

        <!-- Menú de navegación -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <li class="nav-header">MENÚ PRINCIPAL</li>

                {{-- Inicio - visible para todos --}}
                <li class="nav-item">
                    <a href="{{ Auth::user()->getDashboardRoute() }}" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>Inicio</p>
                    </a>
                </li>

                {{-- Productos - solo Admin y Mesero --}}
                @if(in_array(Auth::user()->is_role, [0, 2]))
                    <li class="nav-item">
                        <a href="{{ route('productos.index') }}" class="nav-link">
                            <i class="fas fa-box nav-icon"></i>
                            <p>Productos</p>
                        </a>
                    </li>
                @endif

                {{-- Reportes y Usuarios - solo Admin --}}
                @if(Auth::user()->is_role == 2)
                    <li class="nav-item">
                        <a href="{{ route('reportes.index') }}" class="nav-link">
                            <i class="fas fa-chart-line nav-icon"></i>
                            <p>Reportes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users') }}" class="nav-link">
                            <i class="fas fa-users-cog nav-icon"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                @endif

                {{-- Ver Comandas - solo Mesero y Admin --}}
                @if(in_array(Auth::user()->is_role, [0, 2]))
                    <li class="nav-item">
                        <a href="{{ route('comandas.index') }}" class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Ver Comandas</p>
                        </a>
                    </li>
                @endif

                {{-- Cocina - solo Cocina y Admin --}}
                @if(in_array(Auth::user()->is_role, [1, 2]))
                    <li class="nav-item">
                        <a href="{{ route('comandas.vistaCocina') }}" class="nav-link">
                            <i class="fas fa-utensils nav-icon"></i>
                            <p>Cocina</p>
                        </a>
                    </li>
                @endif

                {{-- Salir --}}
                <li class="nav-item mt-3">
                    <a href="#" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Salir</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
