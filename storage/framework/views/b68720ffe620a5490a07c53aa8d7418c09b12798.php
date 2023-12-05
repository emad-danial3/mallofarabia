<?php $__env->startSection('content'); ?>
 <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo e(route('orderHeaders.reports')); ?>">Invoices Reports</a></li>
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
            <form method="get" action="<?php echo e(route('orderHeaders.reports')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-1 row ">
                        <div class="form-group col-12">
                            <label class="col-form-label" for="name">ID</label>
                            <input type="text" name="name" class="form-control" id="name" <?php if(app('request')->input('name')): ?>value="<?php echo e(app('request')->input('name')); ?>" <?php endif; ?> placeholder="ID">
                        </div>
                    </div>
                    <div class="col-md-3 row ">
                        <div class="form-group col-12">
                            <label class="col-form-label" for="product_name">Product Name</label>
                            <input type="text" name="product_name" class="form-control" id="product_name" <?php if(app('request')->input('product_name')): ?>value="<?php echo e(app('request')->input('product_name')); ?>" <?php endif; ?> placeholder=" Product Name">
                        </div>
                    </div>
                    <div class="col-md-2 row ">
                        <div class="form-group col-12">
                            <label class="col-form-label" for="product_code">Product Code</label>
                            <input type="text" name="product_code" class="form-control" id="product_code" <?php if(app('request')->input('product_code')): ?>value="<?php echo e(app('request')->input('product_code')); ?>" <?php endif; ?> placeholder=" Product Code">
                        </div>
                    </div>

                    <div class="row col-4">
                        <div class="form-group col-6">
                            <label class="col-form-label" for="from_date">From Date</label>
                            <input type="date" name="from_date" id="from_date" <?php if(app('request')->input('from_date')): ?>value="<?php echo e(app('request')->input('from_date')); ?>" <?php endif; ?> class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label class="col-form-label" for="to_date">To Date</label>
                            <input type="date" name="to_date" <?php if(app('request')->input('to_date')): ?>value="<?php echo e(app('request')->input('to_date')); ?>" <?php endif; ?> id="to_date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-2">
                        <label class="col-form-label"><i class="fa fa-search"></i></label>
                        <button type="submit" class="btn btn-info form-control">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body" style="overflow-x:scroll">
            <?php if(count($purchaseInvoiceLines)>0): ?>
                <table id="orderHeadersTable" style="width: 100%" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        
                        <th>ID</th>
                        <th>Product code</th>
                        <th>Company name</th>
                        <th>Product name</th>
                        <th>Number of purchases</th>
                        <th>Average purchase price</th>
                        <th>The total amount</th>

                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $purchaseInvoiceLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td><?php echo e($row->id); ?></td>
                            <td><?php echo e($row->oracle_short_code); ?></td>
                            <td><?php echo e($row->name_en); ?></td>
                            <td><?php echo e($row->full_name); ?></td>
                            <td><?php echo e($row->lines_count); ?></td>
                            <td><?php echo e(number_format(( floatval($row->total_purchase_price) /  floatval($row->lines_count)), 2, '.', ',')); ?></td>
                            <td><?php echo e($row->total_purchase_quantity); ?></td>
                            <td><?php echo e($row->created_at); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>

                </table>
                <div class="pagination">

                    <?php if(isset($purchaseInvoiceLines) && $purchaseInvoiceLines->lastPage() > 1): ?>
                        <ul class="pagination">
                        <?php
                            $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                            $from = $purchaseInvoiceLines->currentPage() - $interval;
                            if($from < 1){
                              $from = 1;
                            }

                            $to = $purchaseInvoiceLines->currentPage() + $interval;
                            if($to > $purchaseInvoiceLines->lastPage()){
                              $to = $purchaseInvoiceLines->lastPage();
                            }
                        ?>
                        <!-- first/previous -->
                            <?php if($purchaseInvoiceLines->currentPage() > 1): ?>
                                <li>
                                    <a href="<?php echo e($purchaseInvoiceLines->url(1)."&type=".app('request')->input('type')); ?>" aria-label="First">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e($purchaseInvoiceLines->url($purchaseInvoiceLines->currentPage() - 1)."&type=".app('request')->input('type')); ?>" aria-label="Previous">
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <!-- links -->
                            <?php for($i = $from; $i <= $to; $i++): ?>
                                <?php
                                    $isCurrentPage = $purchaseInvoiceLines->currentPage() == $i;
                                ?>
                                <li class="<?php echo e($isCurrentPage ? 'active' : ''); ?>" style="padding: 5px">
                                    <a href="<?php echo e(!$isCurrentPage ? $purchaseInvoiceLines->url($i)."&type=".app('request')->input('type') : ''); ?>">
                                        <?php echo e($i); ?>

                                    </a>
                                </li>
                            <?php endfor; ?>
                        <!-- next/last -->
                            <?php if($purchaseInvoiceLines->currentPage() < $purchaseInvoiceLines->lastPage()): ?>
                                <li>
                                    <a href="<?php echo e($purchaseInvoiceLines->url($purchaseInvoiceLines->currentPage() + 1)."&type=".app('request')->input('type')); ?>" aria-label="Next">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e($purchaseInvoiceLines->url($purchaseInvoiceLines->lastpage())."&type=".app('request')->input('type')); ?>" aria-label="Last">
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
            function urlParamfun(name){
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results==null){
                    return null;
                }
                else{
                    return results[1] || 0;
                }
            }

            $('#select-all').click(function() {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function() {
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

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/PurchaseInvoices/reports.blade.php ENDPATH**/ ?>