<?php $__env->startSection('content'); ?>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('orderHeaders.index')); ?>">Orders</a></li>

                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">

                <div class="card-header">


                        <form class="form-inline row" method="get" action="<?php echo e(url('admin/orderHeaders/change/getOracleNumberByOrderId')); ?>">
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="date_from" class="text-right mr-2">Date From </label>
                                <input type="date" id="date_from" name="date_from" <?php if(isset($date_from) && $date_from !='' ): ?> value="<?php echo e($date_from); ?>" <?php endif; ?> class="form-control" placeholder="Date From">
                            </div>
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="date_to" class="text-right mr-2">Date To </label>
                                <input type="date" id="date_to" name="date_to" <?php if(isset($date_to) && $date_to !='' ): ?> value="<?php echo e($date_to); ?>" <?php endif; ?> class="form-control" placeholder="Date To">
                            </div>
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="name" class="text-right mr-2">Order Number </label>
                                <input type="text" id="name" name="name" <?php if(isset($name) && $name !='' ): ?> value="<?php echo e($name); ?>" <?php endif; ?> class="form-control" placeholder="Order Number" style="text-align: left">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2 col-md-2">Search</button>
                        </form>


                </div>
            </div>

                <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->

                                        <?php if(isset($orders) && count($orders) > 0): ?>
                                            <table class="table table-striped" style="direction: ltr">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col"><h3> Order Number</h3></th>
                                                    <th scope="col"><h3>Order Payment Status</h3></th>
                                                    <th scope="col"><h3>Oracle Numbers</h3></th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <th scope="row"><?php echo e($loop->iteration); ?></th>
                                                        <td> <h4><?php echo e($order->id); ?></h4></td>
                                                        <td> <h4><?php echo e($order->payment_status); ?></h4></td>
                                                        <td>
                                                            <?php if(isset($order->order_lines)): ?>

                                                                <?php $__currentLoopData = $order->order_lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <h4><?php echo e($line->oracle_num); ?></h4>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        <?php endif; ?>

                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->


    </section>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/OrderHeaders/oracle.blade.php ENDPATH**/ ?>