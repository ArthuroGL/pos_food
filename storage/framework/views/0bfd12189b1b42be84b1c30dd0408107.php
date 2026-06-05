<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Sistema POS</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/fontawesome-free/css/all.min.css')); ?>">
</head>
<body class="h-full flex items-center justify-center p-4 bg-slate-50 font-sans antialiased selection:bg-orange-500 selection:text-white">

    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-orange-500 text-white shadow-sm shadow-orange-500/20 mb-3">
                <i class="fas fa-utensils text-xl"></i>
            </div>
            <h1 class="text-xl font-black text-slate-900 uppercase tracking-wider">Comandas POS</h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Acceso al Panel Operativo</p>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 md:p-8 shadow-xs">

            <?php if(session('error')): ?>
                <div class="mb-5 flex items-start gap-3 p-3.5 rounded-xl bg-rose-50 text-rose-700 border border-rose-200/60 text-xs font-bold transition-all animate-fade-in">
                    <i class="fas fa-exclamation-circle mt-0.5 text-rose-500"></i>
                    <span><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="mb-5 flex items-start gap-3 p-3.5 rounded-xl bg-blue-50 text-blue-700 border border-blue-200/60 text-xs font-bold transition-all animate-fade-in">
                    <i class="fas fa-info-circle mt-0.5 text-blue-500"></i>
                    <span><?php echo e(session('info')); ?></span>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('login_post')); ?>" method="POST" class="space-y-5">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="email" class="block text-xs font-black text-slate-500 mb-1.5 uppercase tracking-wider">
                        <i class="fas fa-envelope mr-1 text-slate-400"></i> Correo Electrónico
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all shadow-2xs"
                        placeholder="ejemplo@restaurante.com"
                        required
                        autocomplete="username"
                    >
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-black text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-lock mr-1 text-slate-400"></i> Contraseña
                        </label>
                    </div>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all shadow-2xs"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm shadow-orange-500/10 cursor-pointer active:scale-[0.98] select-none"
                    >
                        <span>Ingresar al Sistema</span>
                        <i class="fas fa-arrow-right text-[10px] transition-transform group-hover:translate-x-0.5"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center mt-6">
            <span class="inline-flex items-center gap-2 rounded-full bg-slate-200/50 px-3 py-1 border border-slate-200/40 text-[10px] font-bold text-slate-500 uppercase tracking-wide">
                <span class="relative flex h-1.5 w-1.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                </span>
                Terminal Autenticada
            </span>
        </div>

    </div>

</body>
</html>
<?php /**PATH C:\laragon\www\comida-app\resources\views/auth/login.blade.php ENDPATH**/ ?>