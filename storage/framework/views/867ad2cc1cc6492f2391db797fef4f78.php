<!-- jQuery -->
<script src="<?php echo e(asset('vendor/jquery/jquery.min.js')); ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?php echo e(asset('vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>

<!-- AdminLTE -->
<script src="<?php echo e(asset('vendor/adminlte/dist/js/adminlte.min.js')); ?>"></script>

<!-- SweetAlert2 (si usas alertas) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Alertas por sesión -->
<?php if(session('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: "<?php echo e(session('success')); ?>",
        confirmButtonColor: '#3085d6'
    });
</script>
<?php endif; ?>

<?php if(session('error')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "<?php echo e(session('error')); ?>",
        confirmButtonColor: '#d33'
    });
</script>
<?php endif; ?>
<?php /**PATH C:\laragon\www\comida-app\resources\views/layouts/scripts.blade.php ENDPATH**/ ?>