<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
            </form>
        </li>
    </ul>
</nav>
<?php /**PATH C:\laragon\www\comida-app\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>