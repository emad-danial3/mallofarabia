<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo e(route('companies.index')); ?>">Companies</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <?php echo $__env->make('AdminPanel.layouts.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title float-right">
                <a class="btn btn-warning" href="<?php echo e(route('companies.create')); ?>">Create New Company</a>
            </h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <?php if(count($companies) > 0): ?>
                <table id="areasTable"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name EN</th>
                        <th>Name Ar</th>
                        <th>Status</th>
                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($row->id); ?></td>
                            <td width="150"><?php echo e($row->name_en); ?></td>
                            <td width="150"><?php echo e($row->name_ar); ?></td>
                            <td width="150"><?php echo e(($row->is_available==0)?'Out Stock':'In Stock'); ?></td>
                            <td>
                                <a class="btn btn-dark" href="<?php echo e(route('companies.edit',$row)); ?>">Edit</a>
                                <form action="<?php echo e(route('companyChangeStatus',$row->id)); ?>" method="post" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <?php if($row->is_available == 0): ?>
                                        <input type="hidden" name="is_available" value=1>
                                    <button class="btn btn-success" >In Stock</button>
                                    <?php elseif($row->is_available == 1): ?>
                                        <input type="hidden" name="is_available" value=0>
                                        <button  class="btn btn-danger" >Out Stock</button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name EN</th>
                        <th>Name Ar</th>
                        <th>Control</th>
                    </tr>
                    </tfoot>
                </table>
            <?php else: ?>
                <h1 class="text-center">NO DATA</h1>
            <?php endif; ?>
        </div>
        <!-- /.card-body -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/Companies/index.blade.php ENDPATH**/ ?>