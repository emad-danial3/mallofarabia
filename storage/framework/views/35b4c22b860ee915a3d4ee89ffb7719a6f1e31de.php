<?php $__env->startSection('content'); ?>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('generalReports.report')); ?>">Reports</a></li>

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
                    <form class="form-inline row" method="get" action="<?php echo e(url('admin/generalReports/todayreport')); ?>">
                        <div class="form-group  mb-2 col-md-3">
                            <label for="date_from" class="text-right mr-2">Date </label>
                            <input type="date" id="date_from" name="date_from" <?php if(app('request')->input('date_from')): ?> value="<?php echo e(app('request')->input('date_from')); ?>" <?php endif; ?>  class="form-control" placeholder="Date From" required>
                        </div>
                        <div class="form-group  mb-2 col-md-3">
                            <select id="admin_id" name="admin_id" class="form-control">
                                <option value="">Chose Admin</option>
                                <?php $__currentLoopData = $Admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($Admin->id); ?>"  <?php if(app('request')->input('admin_id') == $Admin->id): ?>selected <?php endif; ?>><?php echo e($Admin->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 col-md-2">Search</button>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-md-9">

                            <div id="piechart" style="width: 900px; height: 500px;"></div>

                        </div>
                        <div class="col-md-3">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Total Orders Cash: <?php echo e($ordersSalesTotalsCash); ?></th>
                                    <input type="hidden" value="<?php echo e($ordersSalesTotalsCash); ?>" id="ordersSalesTotalsCash">
                                </tr>
                                <tr>
                                    <th scope="col">Total Orders Visa: <?php echo e($ordersSalesTotalVisa); ?></th>
                                    <input type="hidden" value="<?php echo e($ordersSalesTotalVisa); ?>" id="ordersSalesTotalVisa">
                                </tr>

                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- /.row -->
        </div><!-- /.container-fluid -->


    </section>

    <?php $__env->startPush('scripts'); ?>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var Cash = parseFloat($('#ordersSalesTotalsCash').val());
                var Visa = parseFloat($('#ordersSalesTotalVisa').val());
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['Cash', Cash],
                    ['Visa', Visa],
                ]);

                var options = {
                    title: (Cash > 0 || Visa > 0) ? 'My Total Sales' : ''
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/Reports/todayreport.blade.php ENDPATH**/ ?>