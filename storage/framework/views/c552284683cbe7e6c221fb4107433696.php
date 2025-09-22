<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($title ?? 'Sistema de Comandas'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">

    <header class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">🍽️ Punto de Venta - Comida</h1>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php echo e($slot); ?>

    </main>

</body>
</html>
<?php /**PATH C:\laragon\www\comida-app\resources\views/components/layout.blade.php ENDPATH**/ ?>