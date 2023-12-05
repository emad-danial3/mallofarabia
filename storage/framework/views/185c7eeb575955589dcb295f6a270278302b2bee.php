<?php $__env->startSection('content'); ?>


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Products</a></li>
                        <li class="breadcrumb-item active"><?php echo e(isset($product)?'Edit / '.$product->full_name :'ADD'); ?></li>
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
                        <form action="<?php echo e((isset($product))?route('products.update',$product):route('products.store')); ?>"
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
                                        <label for="name">oracle Code</label>
                                        <div class="row">
                                            <input type="text" name="oracle_code" class="form-control col-md-4"
                                                   placeholder="Enter Name" id="oracle_code">
                                            <select id="short_code" name="item_code" class="form-select form-control  col-md-4">
                                            </select>
                                            <input type="text" placeholder="Search By code.." id="myInput"
                                                   onkeyup="filterFunction()" class="form-control col-md-4">
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="name">full_name</label>
                                    <input type="text" name="full_name" class="form-control"
                                           placeholder="Enter Name"
                                           value="<?php if(old('full_name')): ?><?php echo e(old('full_name')); ?><?php elseif(isset($product->full_name)): ?><?php echo e($product->full_name); ?><?php endif; ?>"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label for="name">name_ar</label>
                                    <input type="text" name="name_ar" class="form-control"
                                           placeholder="Enter Name"
                                           value="<?php if(old('name_ar')): ?><?php echo e(old('name_ar')); ?><?php elseif(isset($product->name_ar)): ?><?php echo e($product->name_ar); ?><?php endif; ?>"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label for="name">name_en</label>
                                    <input type="text" name="name_en" class="form-control"
                                           placeholder="Enter Name"
                                           value="<?php if(old('name_en')): ?><?php echo e(old('name_en')); ?><?php elseif(isset($product->name_en)): ?><?php echo e($product->name_en); ?><?php endif; ?>"
                                           required>
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
                                    <div class="form-group col-md-3">
                                        <label for="name">Old Price</label>
                                        <input type="number" name="old_price" id="old_price"
                                               class="form-control" step="0.01"
                                               placeholder="Old Price"
                                               value="<?php if(old('old_price')): ?><?php echo e(old('old_price')); ?><?php elseif(isset($product->old_price)): ?><?php echo e($product->old_price); ?><?php endif; ?>"
                                               required>
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
                                    <label for="name">Barcode</label>
                                    <input type="text" name="barcode" id="barcode" class="form-control"
                                           placeholder="Enter barcode"
                                           value="<?php if(old('barcode')): ?><?php echo e(old('barcode')); ?><?php elseif(isset($product->barcode)): ?><?php echo e($product->barcode); ?><?php endif; ?>"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label for="name">description_ar</label>
                                    <input type="text" name="description_ar" id="description_ar" class="form-control"
                                           placeholder="Enter Name"
                                           value="<?php if(old('description_ar')): ?><?php echo e(old('description_ar')); ?><?php elseif(isset($product->description_ar)): ?><?php echo e($product->description_ar); ?><?php endif; ?>"
                                           required>
                                </div>


                                <div class="form-group">
                                    <label for="name">description_en</label>
                                    <input type="text" name="description_en" class="form-control"
                                           placeholder="Enter Name"
                                           value="<?php if(old('description_en')): ?><?php echo e(old('description_en')); ?><?php elseif(isset($product->description_en)): ?><?php echo e($product->description_en); ?><?php endif; ?>"
                                           required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Stock status</label>
                                        <select class="form-control" name="stock_status" id="stock_status">
                                            <option
                                                <?php if(isset($product->stock_status) && $product->stock_status  == 'out stock'): ?> <?php echo e('selected'); ?><?php endif; ?> value="out stock">
                                                out stock
                                            </option>
                                            <option
                                                <?php if(isset($product->stock_status) && $product->stock_status  == 'in stock'): ?> <?php echo e('selected'); ?><?php endif; ?> value="in stock">
                                                in stock
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name">Visible Status on web</label>
                                        <select class="form-control" name="visible_status" id="visible_status">
                                            <option
                                                <?php if(isset($product->visible_status) && $product->visible_status  == '1'): ?> <?php echo e('selected'); ?><?php endif; ?> value="1">
                                                Yes
                                            </option>
                                            <option
                                                <?php if(isset($product->visible_status) && $product->visible_status  == '0'): ?> <?php echo e('selected'); ?><?php endif; ?> value="0">
                                                No
                                            </option>
                                        </select>
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

                                <div class="form-group">
                                    <label for="image">Product Image</label>
                                    <input type="file" class="form-control" name="image"
                                           <?php if(!isset($product)): ?>required <?php endif; ?>>
                                    <br>
                                    <?php if(isset($product->image)): ?>

                                        <?php if(strlen($product->image) > 35): ?>
                                            <img src="<?php echo e($product->image); ?>" width="250" height="250">
                                        <?php else: ?>
                                            <img src="<?php echo e(url($product->image)); ?>" width="250" height="250">
                                        <?php endif; ?>


                                    <?php endif; ?>
                                </div>

                                <?php if(isset($categories)): ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name">
                                            Category
                                        </label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <select name="category_id" class="form-control col-md-12 col-xs-12">
                                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($category->id); ?>">
                                                        <?php if(isset($category->parent)&& isset($category->parent->name_en)): ?><?php echo e($category->parent->name_en); ?> <?php endif; ?>
                                                        =>
                                                        <?php echo e($category->name_en); ?>

                                                        
                                                        
                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>

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
                                <div class="row" style="border: 1px solid #e7e7e7;border-radius: 5px;">
                                    <h3 class="col-md-12">Product Forms Sizes & Colors</h3>
                                    <div class="col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">Option</th>
                                                <th scope="col">Value</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="productForms">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group mb-2">
                                                    <label for="options" class="sr-only">Option</label>
                                                    <select class="form-control" id="options">
                                                        <option>Chose Option</option>
                                                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($option->id); ?>" name="<?php echo e($option->name_en); ?>">
                                                                <?php echo e($option->name_en); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-2">
                                                    <label for="option" class="sr-only">Option Value</label>
                                                    <select class="form-control " id="optionValues">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-2">
                                                    <label for="optionQuantity" class="sr-only">Quantity</label>
                                                    <input type="number" min="0" class="form-control" id="optionQuantity" placeholder="Quantity">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-2">
                                                    <label for="optionPrice" class="sr-only">Price</label>
                                                    <input type="number" min="0" class="form-control" id="optionPrice" placeholder="Price">

                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-primary" id="addFormButton">
                                                    Add Form
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                console.log(div)
                a = div.getElementsByTagName("option");
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

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/Products/edit.blade.php ENDPATH**/ ?>