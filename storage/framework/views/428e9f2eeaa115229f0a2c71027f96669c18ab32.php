<?php $__env->startSection('content'); ?>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Products</a></li>

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


                        <form class="form-inline row" method="get" action="<?php echo e(url('admin/products/change/barcode')); ?>">
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="name" class="text-right mr-2">Product Name </label>
                                <input type="text" id="name" name="name" <?php if(isset($name) && $name !='' ): ?> value="<?php echo e($name); ?>" <?php endif; ?> class="form-control" placeholder="Product Name">
                            </div>
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="oracle_short_code" class="text-right mr-2">Item Code </label>
                                <input type="text" id="oracle_short_code" name="oracle_short_code" <?php if(isset($oracle_short_code) && $oracle_short_code !='' ): ?> value="<?php echo e($oracle_short_code); ?>" <?php endif; ?> class="form-control" placeholder="Item Code" style="text-align: left">
                            </div>
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="barcode" class="text-right mr-2">Barcode </label>
                                <input type="text" id="barcode" name="barcode" <?php if(isset($barcode) && $barcode !='' ): ?> value="<?php echo e($barcode); ?>" <?php endif; ?> class="form-control" placeholder="BarCode" style="text-align: left">
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

                        <?php if(isset($data)): ?>

                        <?php endif; ?>

                                        <?php if(isset($data)): ?>
                                            <table class="table table-striped" style="direction: ltr">
                                                <thead>
                                                <tr>
                                                    <th scope="col"><h3> Product ID</h3></th>
                                                    <th scope="col"><h3> Product Name</h3></th>
                                                    <th scope="col"><h3> Product Item</h3></th>
                                                    <th scope="col"><h3> Product Barcode</h3></th>
                                                    <th scope="col"><h3> Product Price</h3></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                            <th scope="col"><h3> <?php echo e($data->id); ?></h3></th>
                                            <th scope="col"><h3> <?php echo e($data->name_en); ?></h3></th>
                                            <th scope="col"><h3> <?php echo e($data->oracle_short_code); ?></h3></th>
                                            <th scope="col"><h3> <?php echo e($data->barcode); ?></h3></th>
                                            <th scope="col"><h3> <?php echo e($data->price); ?> LE </h3> </th>
                                                </tbody>
                                            </table>
                                        <?php endif; ?>

                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                    <?php if(isset($data) && isset($data->id) && $data->id > 0): ?>
                <div class="col-md-12">
                    <div class="card card-primary mr-5">
                        <input type="hidden" id="update_product_id" value="<?php echo e($data->id); ?>">
                        <div class="form-group mx-sm-3 mb-2 col-md-3 mt-4">
                                <label for="barcode" class="text-right mr-2">New Barcode </label>
                                <input type="text" id="newbarcode" name="newbarcode" <?php if(isset($data) && isset($data->barcode)): ?> value="<?php echo e($data->barcode); ?>" <?php endif; ?> class="form-control" placeholder="Barcode" style="text-align: left">
                        </div>
                         <button id="updateBarcode" class="btn btn-primary mb-4 col-md-2 ml-4">Update</button>
                    </div>
                </div>
                <?php endif; ?>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->


    </section>
 <?php $__env->startPush('scripts'); ?>
        <script type="text/javascript">

              $(document).ready(function () {
   $("#updateBarcode").click(function () {
 var base_url            = window.location.origin;
                    console.log("updateBarcode Function");
                    let path     = base_url + "/admin/products/updateNewBarcode";
                    var update_product_id = $('#update_product_id').val();
                    var newbarcode = $('#newbarcode').val();
                    var ff       = {
                        "update_product_id": update_product_id,
                        "newbarcode": newbarcode,
                    }

                    $.ajax({
                        url: path,
                        type: 'POST',
                        cache: false,
                        data: JSON.stringify(ff),
                        contentType: "application/json; charset=utf-8",
                        traditional: true,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        success: function (response) {
                            if (response.data) {
                                console.log(response.data);

                                 swal({
                                    text: "update Product ",
                                    title: "Successful",
                                    timer: 1500,
                                    icon: "success",
                                    buttons: false,
                                });

                                location.reload(true);
                            }
                        },
                        error: function (response) {
                            console.log(response)
                            alert('error');
                        }
                    });
                });
   });
        </script>

    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/Products/barcode.blade.php ENDPATH**/ ?>