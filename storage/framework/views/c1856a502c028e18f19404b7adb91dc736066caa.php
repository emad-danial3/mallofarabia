<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('AdminPanel.layouts.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if(Auth::guard('admin')->user()->id == 24 ): ?>
    <?php else: ?>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="btn btn-success" href="<?php echo e(route('updateOracleProducts')); ?>">Update Oracle Codes</a>
                        

                        <br>
                        <br>
                        <br>
                        <a class="btn btn-danger" href="<?php echo e(route('updateOracleProductsPrice')); ?>">Update Products
                            Price</a>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $("#test").click(function () {
            $.ajax({

                url: "https://sales.atr-eg.com/api/RefreshNettinghubItems.php",
                beforeSend: function (xhr) {
                    xhr.overrideMimeType("text/plain; charset=x-user-defined");
                }
            })
                .done(function (data) {

                    $.ajax({
                        type: 'POST',  // http method
                        data: {myData: data},  // data to submit
                        url: "http://127.0.0.1:8000/api/updateTableJS",
                        beforeSend: function (xhr) {
                            xhr.overrideMimeType("text/plain; charset=x-user-defined");
                        }
                    })
                        .done(function (data) {
                            updateTableJS
                            if (console && console.log) {
                                console.log("Sample of data:", JSON.stringify(data));
                            }
                        });

                });
        });
        // $(document).ready(function(){
        //     $("#test").click(function(){
        //         $.get("", function(data, status){
        //             console.log("Data: " + data + "\nStatus: " + status);
        //         });
        //     });
        // });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/index.blade.php ENDPATH**/ ?>