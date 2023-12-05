<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo e(route('products.index')); ?>">Products</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <?php echo $__env->make('AdminPanel.layouts.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <div class="card">

        <div class="card-header" style="float: right">
            <h3 class="card-title float-right">
                <a class="btn btn-warning" href="<?php echo e(route('products.create')); ?>">Create New Product</a>
            </h3>

            <h3 class="card-title">
                <form method="post" action="<?php echo e(route('products.changeStatus')); ?>">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select name="stock_status" id="stock_status" class="form-control">
                                <option value="out stock">out stock</option>
                                <option value="in stock">in stock</option>
                            </select>
                        </div>
                        <button type="button"  onclick="getselectedId()" class="btn btn-danger form-control">Change Selected</button>
                    </div>
                </form>
            </h3>
        </div>


        <div class="card-header" style="float: right">
            <h3 class="card-title">
                <button type="button"  onclick="getselectedIdForExport()" class="btn btn-dark">Export Selected</button>
            </h3>
            <h3 class="card-title">
                <button type="button"  onclick="getAddIdForExport()" class="btn btn-success mx-2">Export All</button>
            </h3>
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <form method="get" action="<?php echo e(route('products.index')); ?>">
                    <div class="row">
                        <div class="col-md-3">
                                <input class="form-control" type="text" placeholder="name" id="searchtext" name="name">
                        </div>

                        <div class="col-md-3">
                                <input class="form-control" type="text" placeholder="oracle code" id="searchtext" name="item_code">
                        </div>
                        <div class="col-md-2">
                                <input class="form-control" type="text" placeholder="bar code" id="searchtext" name="barcode">
                        </div>

                        <div class="col-md-2">
                            <select class="form-control" id="searchtext" name="category_id">
                                <option value="">ALL</option>
                                <?php $__currentLoopData = \App\Models\Category::whereNull('parent_id')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value->id); ?>"><?php echo e($value->name_ar); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-info">Search</button>
                        </div>
                    </div>
                </form>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php if(count($products) > 0): ?>
                <table id="productsTable"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th> <input type="checkbox" id="select-all"></th>
                        <th>Name EN</th>
                        <th>Name AR</th>
                        <th>Categories</th>
                        <th>price</th>
                        <th>Quantity</th>
                        <th>stock Status</th>
                        <th>oracle Code</th>
                        <th>bar Code</th>
                        <th>tax</th>

                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><input type="checkbox" name="checkbox[]" value="<?php echo e($row->id); ?>"/></td>
                            <td ><?php echo e($row->name_en); ?></td>
                            <td ><?php echo e($row->name_ar); ?></td>
                            <td ><?php $__currentLoopData = $row->productCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(isset($productCategory->category)&&$productCategory->category['parent_id']== null): ?>
                                        <?php echo e($productCategory->category['name_en']); ?>

                                    <?php elseif(isset($productCategory->category)): ?>
                                        --<?php echo e($productCategory->category['name_en']); ?>


                                    <?php endif; ?>
                                    <br><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                            <td ><?php echo e($row->price); ?></td>
                            <td ><?php echo e($row->quantity); ?></td>
                            <td ><?php echo e($row->stock_status); ?></td>
                            <td ><?php echo e($row->oracle_short_code); ?></td>
                            <td ><?php echo e($row->barcode); ?></td>
                            <td ><?php echo e($row->tax); ?></td>

                            <td>
                                <a class="btn btn-dark" href="<?php echo e(route('products.edit',$row)); ?>">Edit</a>
                              <br>
                              <br>
                              <br>
                                <a class="btn btn-success" href="<?php echo e(route('products.show',$row)); ?>">View</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>














                </table>


             <div class="pagination justify-content-center mt-2">

                    <?php if(isset($products) && $products->lastPage() > 1): ?>
                        <ul class="pagination align-items-center">
                        <?php
                            $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                            $from = $products->currentPage() - $interval;
                            if($from < 1){
                              $from = 1;
                            }

                            $to = $products->currentPage() + $interval;
                            if($to > $products->lastPage()){
                              $to = $products->lastPage();
                            }
                        ?>
                        <!-- first/previous -->
                            <?php if($products->currentPage() > 1): ?>
                                <li class="page-item">
                                    <a href="<?php echo e($products->url(1)."&name=".app('request')->input('name')."&category_id".app('request')->input('category_id')); ?>" aria-label="First" class="page-link">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a href="<?php echo e($products->url($products->currentPage() - 1)."&name=".app('request')->input('name')."&category_id".app('request')->input('category_id')); ?>" aria-label="Previous" class="page-link">
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <!-- links -->
                            <?php for($i = $from; $i <= $to; $i++): ?>
                                <?php
                                    $isCurrentPage = $products->currentPage() == $i;
                                ?>
                                <li class="page-item <?php echo e($isCurrentPage ? 'active' : ''); ?>" style="padding: 5px">
                                    <a class="page-link" href="<?php echo e(!$isCurrentPage ? $products->url($i)."&name=".app('request')->input('name')."&category_id".app('request')->input('category_id') : ''); ?>">
                                        <?php echo e($i); ?>

                                    </a>
                                </li>
                            <?php endfor; ?>
                        <!-- next/last -->
                            <?php if($products->currentPage() < $products->lastPage()): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($products->url($products->currentPage() + 1)."&name=".app('request')->input('name')."&category_id".app('request')->input('category_id')); ?>" aria-label="Next">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($products->url($products->lastpage())."&name=".app('request')->input('name')."&category_id".app('request')->input('category_id')); ?>" aria-label="Last">
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

            function getselectedId()
            {
                var ids =[];
                var stock_status = $('#stock_status').val();
                $('input[type="checkbox"]').each(function() {
                        if (this.checked)
                        {
                            ids.push(this.value);
                        }
                });
                window.location.href = "<?php echo e(route('products.changeStatus')); ?>?products_ids="+ids+"&stock_status="+stock_status;
            }

            function getselectedIdForExport()
            {
                var ids =[];
                $('input[type="checkbox"]').each(function() {
                    if (this.checked)
                    {
                        ids.push(this.value);
                    }
                });
                window.location.href = "<?php echo e(route('products.ExportProductsSheet')); ?>?products_ids="+ids;

            }

            function getAddIdForExport()
            {

                window.location.href = "<?php echo e(route('products.ExportProductsSheet')); ?>?products_ids=0";

            }
            $('#select-all').click(function() {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function() {
                    this.checked = checked;
                });
            })

        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/Products/index.blade.php ENDPATH**/ ?>