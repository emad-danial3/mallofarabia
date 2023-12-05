<?php $__env->startSection('content'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo e(route('generalReports.reports')); ?>">Report Product
                                Sales</a></li>
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
            <form method="get" action="<?php echo e(route('generalReports.reports')); ?>">
                <div class="row">
                    <div class="col-md-1 row ">
                        <div class="form-group col-12">
                            <input type="text" name="name" class="form-control" id="name" <?php if(app('request')->input('name')): ?>value="<?php echo e(app('request')->input('name')); ?>" <?php endif; ?> placeholder="ID">
                        </div>
                    </div>
                    <div class="col-md-3 row ">
                        <div class="form-group col-12">
                            <input type="text" name="product_name" class="form-control" id="product_name" <?php if(app('request')->input('product_name')): ?>value="<?php echo e(app('request')->input('product_name')); ?>" <?php endif; ?> placeholder=" Product Name">
                        </div>
                    </div>
                    <div class="col-md-2 row ">
                        <div class="form-group col-12">
                            <input type="text" name="product_code" class="form-control" id="product_code" <?php if(app('request')->input('product_code')): ?>value="<?php echo e(app('request')->input('product_code')); ?>" <?php endif; ?> placeholder=" Product Code">
                        </div>
                    </div>
                    <div class="form-group  mb-2 col-md-2">
                        <input type="text" id="date_from" name="date_from" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" <?php if(isset($date_from) && $date_from !='' ): ?> value="<?php echo e($date_from); ?>" <?php endif; ?> class="form-control" placeholder="Date From" required>
                    </div>
                    <div class="form-group  mb-2 col-md-2">
                        <input type="text" id="date_to" name="date_to" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" <?php if(isset($date_to) && $date_to !='' ): ?> value="<?php echo e($date_to); ?>" <?php endif; ?> class="form-control" placeholder="Date To" required>
                    </div>
                    <div class="form-group col-2">
                        <button type="submit" class="btn btn-success form-control"><i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body card-body pt-0 pb-0">
            <form method="post" action="<?php echo e(route('generalReports.export')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="form-group col-4">
                        <input type="text" name="start_date" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" class="form-control" required placeholder="Start Date">
                    </div>
                    <div class="form-group col-4">
                        <input type="text" name="end_date" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" class="form-control" required placeholder="End Date">
                    </div>


                    <div class="form-group col-4">
                        <input type="hidden" name="payment_status" id="payment_status">
                        <button type="submit" class="btn btn-primary form-control"><i class="fa fa-file"></i> Export
                            Sheet
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- /.card-header -->
        <div class="card-body" style="overflow-x:scroll">
            <?php if(count($productsReport) > 0): ?>
                <table id="orderHeadersTable" style="width: 100%" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        
                        <th>Product ID</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Total Quantity</th>
                        <th>Total Sales</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $productsReport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            
                            <td><?php echo e($row->product_id); ?></td>
                            <td><?php echo e($row->oracle_short_code); ?></td>
                            <td><?php echo e($row->name_en); ?></td>
                            <td><?php echo e($row->total_quantity); ?></td>
                            <td><?php echo e(number_format( floatval($row->total_sales), 2, '.', ',')); ?></td>
                            <td><?php echo e($row->created_at); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>

                </table>
                <div class="pagination justify-content-center mt-2">

                    <?php if(isset($productsReport) && $productsReport->lastPage() > 1): ?>
                        <ul class="pagination align-items-center">
                        <?php
                            $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                            $from = $productsReport->currentPage() - $interval;
                            if($from < 1){
                              $from = 1;
                            }

                            $to = $productsReport->currentPage() + $interval;
                            if($to > $productsReport->lastPage()){
                              $to = $productsReport->lastPage();
                            }
                        ?>
                        <!-- first/previous -->
                            <?php if($productsReport->currentPage() > 1): ?>
                                <li class="page-item">
                                    <a href="<?php echo e($productsReport->url(1)."&date_from=".app('request')->input('date_from')."&date_to=".app('request')->input('date_to')); ?>" aria-label="First" class="page-link">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a href="<?php echo e($productsReport->url($productsReport->currentPage() - 1)."&date_from=".app('request')->input('date_from')."&date_to=".app('request')->input('date_to')); ?>" aria-label="Previous" class="page-link">
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <!-- links -->
                            <?php for($i = $from; $i <= $to; $i++): ?>
                                <?php
                                    $isCurrentPage = $productsReport->currentPage() == $i;
                                ?>
                                <li class="page-item <?php echo e($isCurrentPage ? 'active' : ''); ?>" style="padding: 5px">
                                    <a class="page-link" href="<?php echo e(!$isCurrentPage ? $productsReport->url($i)."&date_from=".app('request')->input('date_from')."&date_to=".app('request')->input('date_to') : ''); ?>">
                                        <?php echo e($i); ?>

                                    </a>
                                </li>
                            <?php endfor; ?>
                        <!-- next/last -->
                            <?php if($productsReport->currentPage() < $productsReport->lastPage()): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($productsReport->url($productsReport->currentPage() + 1)."&date_from=".app('request')->input('date_from')."&date_to=".app('request')->input('date_to')); ?>" aria-label="Next">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($productsReport->url($productsReport->lastpage())."&date_from=".app('request')->input('date_from')."&date_to=".app('request')->input('date_to')); ?>" aria-label="Last">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <h1 class="text-center">NO DATA</h1>
            <?php endif; ?>
        </div>
        <!-- /.card-body -->
    </div>


    <?php $__env->startPush('scripts'); ?>
        <script type="text/javascript">
            var base_url = window.location.origin;

            function urlParamfun(name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results == null) {
                    return null;
                }
                else {
                    return results[1] || 0;
                }
            }

            $('#select-all').click(function () {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function () {
                    this.checked = checked;
                });
            })

            $(document).ready(function () {
                var type = urlParamfun('type');
                console.log(type);
            });

        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/Reports/reports.blade.php ENDPATH**/ ?>