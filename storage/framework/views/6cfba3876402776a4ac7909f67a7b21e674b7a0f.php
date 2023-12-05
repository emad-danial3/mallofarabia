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
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>Business sales today</h1>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4><span class="h5">Casher name : </span> <?php echo e($admin); ?></h4>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4><span class="h5">From date : </span> <?php echo e($date_from); ?></h4>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4><span class="h5">To date: </span> <?php echo e($date_to); ?></h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-8">

                            <div id="piechart" style="width: 900px; height: 500px;"></div>

                        </div>
                        <div class="col-md-4">
                            <table class="table table-striped">
                                <thead>

                                 <tr>
                                    <th scope="col">Total Sales: <?php echo e($total); ?> LE</th>
                                    <th scope="col">Orders Count: <?php echo e($totalcount); ?></th>
                                </tr>

                                <tr>
                                    <th scope="col">Total Orders Cash: <?php echo e($ordersSalesTotalsCash); ?> LE</th>
                                    <th scope="col">Orders Count: <?php echo e($ordersSalesTotalsCashCount); ?></th>
                                    <input type="hidden" value="<?php echo e($ordersSalesTotalsCash); ?>" id="ordersSalesTotalsCash">
                                </tr>

                                <tr>
                                    <th scope="col">Total Orders Visa: <?php echo e($ordersSalesTotalVisa); ?> LE</th>
                                     <th scope="col">Orders Count: <?php echo e($ordersSalesTotalsCashCount); ?></th>
                                    <input type="hidden" value="<?php echo e($ordersSalesTotalVisa); ?>" id="ordersSalesTotalVisa">
                                </tr>

                                </thead>
                            </table>
                             <div class="text-center w-100">
                            <a class="btn btn-danger mb-2 mx-auto w-100" id="logoutButton" href="<?php echo e(url('signout')); ?>"> <?php echo e(trans('website.Logout',[],session()->get('locale'))); ?></a>
                            </div>
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

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/Reports/logout.blade.php ENDPATH**/ ?>