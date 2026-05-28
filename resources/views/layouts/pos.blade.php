<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-100 text-slate-800">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title', 'Comandas')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>
<body class="h-full antialiased bg-slate-100 overflow-x-hidden">

    {{-- BARRA LATERAL (SIDEBAR) Y BARRA SUPERIOR (NAVBAR) INTEGRADA --}}
    @include('layouts.sidebar-and-navbar')

    {{-- CONTENEDOR DE VISTAS OPERATIVAS CON AJUSTE DINÁMICO --}}
    <main id="main-content" class="min-h-screen pt-20 md:pl-72 block transition-all duration-300 ease-in-out">
        <div class="max-w-full p-4 sm:p-6 lg:p-8">
            @yield('content')
        </div>
    </main>

    {{-- POPUPS DE CONTROL DE ESTADO --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Operación Éxito!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#0f172a',
            background: '#ffffff',
            color: '#0f172a'
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc2626',
            background: '#ffffff',
            color: '#0f172a'
        });
    </script>
    @endif

    @yield('scripts')
</body>
</html>
