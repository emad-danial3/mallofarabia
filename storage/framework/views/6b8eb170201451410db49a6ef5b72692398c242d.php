<?php $__env->startSection('content'); ?>

    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-hospital-o"></i> <a href="<?php echo e(route('adminDashboard')); ?>">Home</a> / View
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php echo $__env->make('AdminPanel.layouts.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <table class="table table-hover table-striped">
                        <tbody>
                        <tr>
                            <th>Full Name</th>
                            <td><?php echo e($user->full_name); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/Users/show.blade.php ENDPATH**/ ?>