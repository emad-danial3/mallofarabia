<?php if($errors->all()): ?>
    <div class="alert alert-danger">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p><?php echo e($error); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<?php if(Session::has('message')): ?>
    <div class="alert alert-info">
        <?php echo e(Session::get('message')); ?>

    </div>
<?php endif; ?>
<?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/layouts/messages.blade.php ENDPATH**/ ?>