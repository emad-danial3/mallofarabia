<?php echo $__env->make('AdminPanel.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('AdminPanel.layouts.nav-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('AdminPanel.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- /sidebar menu -->

<div class="content-wrapper">
<!-- page content -->
<?php echo $__env->yieldContent('content'); ?>
<!-- /page content -->
</div>

<?php echo $__env->make('AdminPanel.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\Users\bishoy.sobhy\Desktop\laravel\mall\mallofarabia\resources\views/AdminPanel/layouts/main.blade.php ENDPATH**/ ?>