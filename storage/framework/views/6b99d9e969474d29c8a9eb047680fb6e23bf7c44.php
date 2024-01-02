
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('AdminPanel.layouts.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if(Auth::guard('admin')->user()->id == 24 ): ?>
    <?php else: ?>

    <style type="text/css">
        .casher .btn {
            height: 100px;
            color:white;
            width: 100%;
            font-size: 30px;
           padding-top: 20px;
        }
        .orange {
            background-color: orange;
        }
          .blue {
            background-color: blue;
        }
    </style>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="btn btn-success" href="<?php echo e(route('update_all')); ?>">Update Items Prices</a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row casher"> 
                <div class="col-sm-3">
                    <a class="btn orange" data-link="<?php echo e(route('close_shift_data')); ?>" id="closing_shift">Close shift</a>
                </div>
                <div class="col-sm-3">
                    <a class="btn blue" data-link="<?php echo e(route('close_day_data')); ?>"  id="closing_day">Close Day</a>
                </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


  <!-- Modal -->
<div class="modal fade" id="mediumModal" tabindex="-1" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel"></h5>
                <button type="button" class="close_modal" title="close"><i class="fa fa-times"></i></button>
            </div>
            <div id="modalContent" class="modal-body">
               
            </div>
            <div class="modal-footer">
                    <button class="btn btn-info close_modal" type="button" class="btn btn-secondary" >Close</button>
            </div>
        </div>
    </div>
</div>

    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
     $(document).ready(function(){

        $('.close_modal').on('click',function(){
            $('#mediumModal').modal('hide');
        });
        $('.casher .btn').on('click',function(){
            var url = $(this).data('link');
            var title = $(this).html();
            $('#mediumModalLabel').html(title + ' info');
            $.ajax({
                url: url ,
                type: 'GET',
                success: function (response) {
                // Display the response in the modal
                $('#modalContent').html(response);

                // Open the modal
                $('#mediumModal').modal('show');
                }
            });
        });
     });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\bishoy.sobhy\Desktop\laravel\mall\mallofarabia\resources\views/AdminPanel/PagesContent/index.blade.php ENDPATH**/ ?>