<?php $__env->startSection('content'); ?>


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('orderHeaders.index')); ?>">Purchase Invoices</a></li>

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
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?php echo e((isset($product))?route('purchaseInvoices.update',$product):route('purchaseInvoices.store')); ?>"
                              method="post" enctype="multipart/form-data">
                            <?php echo $__env->make('AdminPanel.layouts.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo csrf_field(); ?>
                            <?php echo e(isset($product)?method_field('PUT'):''); ?>


                            <input type="hidden" name="id" class="form-control"
                                   value="<?php if(old('id')): ?><?php echo e(old('id')); ?><?php elseif(isset($product->id)): ?><?php echo e($product->id); ?><?php endif; ?>"
                                   required>

                            <div class="card-body">
                                <?php if(! isset($products)): ?>
                                    <div class="form-group">
                                        <label for="name">Define Oracle Code</label>
                                        <div class="row">


                                            <select id="short_code" name="item_code" class="form-select form-control  col-md-4">
                                            </select>
                                            <input type="text" placeholder="Search By code .." id="myInput"
                                                   onkeyup="filterFunction()" class="form-control col-md-4">
                                        </div>

                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-12">
                                         <label for="name">Product Name</label>
                                        <input type="text" value="" id="description_ar" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="form-group col-md-3">
                                        <label for="name">price</label>

                                        <?php if(auth()->user()->id == 17 || !isset($product)): ?>
                                            <input type="number" name="price" id="price" class="form-control" step="any"
                                                   placeholder="Enter Price"
                                                   value="<?php if(old('price')): ?><?php echo e(old('price')); ?><?php elseif(isset($product->price)): ?><?php echo e($product->price); ?><?php endif; ?>"
                                                   required>
                                        <?php else: ?>
                                            <input type="hidden" name="price" id="price"
                                                   value="<?php if(old('price')): ?><?php echo e(old('price')); ?><?php elseif(isset($product->price)): ?><?php echo e($product->price); ?><?php endif; ?>"
                                            >
                                            <p><?php if(old('price')): ?><?php echo e(old('price')); ?><?php elseif(isset($product->price)): ?><?php echo e($product->price); ?><?php endif; ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="nu">tax</label>
                                        <input type="number" name="tax" id="tax" class="form-control" step="0.01"
                                               placeholder="Enter Tax"
                                               value="<?php if(old('tax')): ?><?php echo e(old('tax')); ?><?php elseif(isset($product->tax)): ?><?php echo e($product->tax); ?><?php endif; ?>"
                                               required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="name">Discount Rate</label>

                                        <?php if(auth()->user()->id == 17 || !isset($product)): ?>

                                            <input type="number" name="discount_rate" id="discount_rate"
                                                   class="form-control" step="0.01"
                                                   placeholder="Enter discount Rate"
                                                   value="<?php if(old('discount_rate')): ?><?php echo e(old('discount_rate')); ?><?php elseif(isset($product->discount_rate)): ?><?php echo e($product->discount_rate); ?><?php endif; ?>"
                                                   required>
                                        <?php else: ?>
                                            <input type="hidden" name="discount_rate" id="discount_rate"
                                                   value="<?php if(old('discount_rate')): ?><?php echo e(old('discount_rate')); ?><?php elseif(isset($product->discount_rate)): ?><?php echo e($product->discount_rate); ?><?php endif; ?>"
                                            >
                                            <p><?php if(old('discount_rate')): ?><?php echo e(old('discount_rate')); ?><?php elseif(isset($product->discount_rate)): ?><?php echo e($product->discount_rate); ?><?php endif; ?></p>
                                        <?php endif; ?>

                                    </div>

                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="price_after_discount" id="price_after_discount"
                                           class="form-control"
                                           placeholder="Enter Name"
                                           value="<?php if(old('price_after_discount')): ?><?php echo e(old('price_after_discount')); ?><?php elseif(isset($product->price_after_discount)): ?><?php echo e($product->price_after_discount); ?><?php endif; ?>"
                                           required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">quantity</label>
                                        <input type="number" name="quantity" class="form-control"
                                               placeholder="Enter Name"
                                               value="<?php if(old('quantity')): ?><?php echo e(old('quantity')); ?><?php elseif(isset($product->quantity)): ?><?php echo e($product->quantity); ?><?php endif; ?>"
                                               required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name">weight</label>
                                        <input type="number" name="weight" class="form-control" step="0.01"
                                               step="0.01" placeholder="Enter Name"
                                               value="<?php if(old('weight')): ?><?php echo e(old('weight')); ?><?php elseif(isset($product->weight)): ?><?php echo e($product->weight); ?><?php endif; ?>"
                                               required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="oracle_short_code">oracle short code</label>
                                    <input type="text" name="oracle_short_code" id="oracle_short_code"
                                           class="form-control"
                                           placeholder="Enter Name"
                                           value="<?php if(old('oracle_short_code')): ?><?php echo e(old('oracle_short_code')); ?><?php elseif(isset($product->oracle_short_code)): ?><?php echo e($product->oracle_short_code); ?><?php endif; ?>"
                                           required>
                                </div>

                                <?php if(isset($companies)): ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name">
                                            Company For Invoice
                                        </label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <select name="flag" class="form-control col-md-12 col-xs-12">
                                                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        <?php if(isset($product->flag) && $product->flag==$company->id): ?><?php echo e('selected'); ?><?php endif; ?>  value="<?php echo e($company->id); ?>">
                                                        <?php echo e($company->name_ar); ?>

                                                        <br> || <?php echo e($company->name_en); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>


                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Save Info</button>
                            </div>
                        </form>
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
        <?php if(isset($product)): ?>

            <?php if (isset($component)) { $__componentOriginal5bcbdaaf7c21914e4152d172513222ffb7df4dea = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Products\ProductCategory::class, ['productId' => $product->id,'categories' => $product->productCategory,'newCategories' => $newCategories]); ?>
<?php $component->withName('products.product-category'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bcbdaaf7c21914e4152d172513222ffb7df4dea)): ?>
<?php $component = $__componentOriginal5bcbdaaf7c21914e4152d172513222ffb7df4dea; ?>
<?php unset($__componentOriginal5bcbdaaf7c21914e4152d172513222ffb7df4dea); ?>
<?php endif; ?>
        <?php endif; ?>

    </section>

    <?php $__env->startPush('scripts'); ?>
        <script type="text/javascript">
            $('#price').on('change', function () {
                var new_price = this.value - ((this.value * $('#discount_rate').val()) / 100)
                $('#price_after_discount').val(new_price);
            });

            $('#discount_rate').on('change', function () {

                var new_price = $('#price').val() - (($('#price').val() * this.value) / 100)
                $('#price_after_discount').val(new_price);
            });

            $('#options').on('change', function () {

                var optionSelected = $("option:selected", this);
                var valueSelected  = optionSelected.val();

                $.ajax({
                    type: "GET",
                    url: "<?php echo e(route('getOptionValues')); ?>",
                    cache: false,
                    data: {id: valueSelected},
                    dataType: "json",
                    success: function (response) {
                        $('#optionValues').html('');
                        if (response.data.length > 0) {
                            for (let iii = 0; iii < response.data.length; iii++) {
                                let proObjff = response.data[iii];
                                let option   = '<option value="' + proObjff['id'] + '" name="' + proObjff['name_en'] + '">' + proObjff['name_en'] + '</option>';
                                $('#optionValues').append(option);
                            }
                        }
                    },
                    fail: function (Error) {
                        console.log(Error)
                    }
                });
            });


            $(document).ready(function () {
                // $('#oracle_code').focusout(function(){
                var item_code = $(this).val();
                $('#short_code option').remove();
                $.ajax({
                    type: "GET",
                    url: "<?php echo e(route('getOracleProducts')); ?>",
                    cache: false,
                    data: {item_code: item_code},
                    dataType: "json",
                    success: function (data) {
                        // console.log(data);
                        $.each(data, function (k, v) {
                            $('#short_code').append("<option class='form-control col-md-12 col-xs-12'   value=" + v['id'] + " >" + v['item_code'] + " </option>");
                        });
                    },
                    fail: function (Error) {
                        console.log(Error)
                    }
                });

                $('#short_code').on('change', function (e) {
                    var optionSelected = $("option:selected", this);
                    var valueSelected  = optionSelected.val();
                    $.ajax({
                        type: "GET",
                        url: "<?php echo e(route('getOracleProduct')); ?>",
                        cache: false,
                        data: {id: valueSelected},
                        dataType: "json",
                        success: function (data) {
                            $('#price').val(data['cust_price']);
                            $('#tax').val(data['percentage_rate']);
                            $('#description_ar').val(data['description']);
                            $('#oracle_short_code').val(data['item_code']);
                        },
                        fail: function (Error) {
                            console.log(Error)
                        }
                    });
                });

                // });

                $("#addFormButton").click(function () {

                    console.log("fdfdfd 11");
                    var option_id       = $('#options').val();
                    var option_value_id = $('#optionValues').val();
                    var option_quantity = $('#optionQuantity').val();
                    var option_price    = $('#optionPrice').val();
                    if (option_id > 0 && option_value_id > 0 && option_quantity > 0 && option_price > 0) {
                        var op_name         = $("#options option:selected");
                        var option_name     = op_name.attr('name');
                        var op_val          = $("#optionValues option:selected");
                        var option_val_name = op_val.attr('name');
                        $("#productForms").append(
                            '<tr><td> ' +
                            '  <input type="hidden" name="options[]" value="' + option_id + '"> <input type="hidden" name="optionValues[]" value="' + option_value_id + '"> <input type="hidden" name="optionQuantity[]" value="' + option_quantity + '"> <input type="hidden" name="optionPrice[]" value="' + option_price + '">'
                            + option_name + ' </td><td>' + option_val_name + '</td><td>' + option_quantity + '</td><td>' + option_price + '</td><td ><button type="button" onclick="this.parentElement.parentElement.style.display=`none`" style="border: 0px;color: red;">X</button></td></tr>'
                        );
                    }
                    $('#optionValues').html('');
                });

            });


            function filterFunction() {
                var input,
                    filter,
                    ul,
                    li,
                    a,
                    i;
                input  = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                div    = document.getElementById("short_code");
                // console.log(div)
                a      = div.getElementsByTagName("option");
                console.log(a)
                for (i = 0; i < a.length; i++) {
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                    }
                    else {
                        a[i].style.display = "none";
                    }
                }
            }

        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/PurchaseInvoices/form.blade.php ENDPATH**/ ?>