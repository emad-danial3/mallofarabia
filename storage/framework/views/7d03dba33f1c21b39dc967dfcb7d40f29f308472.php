<?php $__env->startSection('content'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo e(route('users.index')); ?>">Users</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <?php echo $__env->make('AdminPanel.layouts.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>











































    <div class="card">









        <!-- /.card-header -->
        <div class="card-body">


        <?php if(count($users) > 0): ?>
                <table id="usersTable"   class="display"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>




                        <th>Mobile</th>


                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($row->id); ?></td>
                            <td width="150"><?php echo e($row->full_name); ?></td>

























                            <td><?php echo e($row->phone); ?></td>


                            </td>
                            <td>
                                <a class="btn btn-dark" href="<?php echo e(route('users.edit',$row)); ?>">Edit</a>
                                <a class="btn btn-success" href="<?php echo e(route('users.show',$row)); ?>">Show</a>





                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <script>
                    $(document).ready( function () {
                        $('#usersTable').DataTable();
                    } );
                </script>


            <?php else: ?>
                <h1 class="text-center">NO DATA</h1>
            <?php endif; ?>
        </div>
        <!-- /.card-body -->
    </div>

    <!-- Modal Create Cancel Order Request -->
    <div class="modal fade" id="exampleModalNewUserRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalNewUserRequestTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order Cancel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo e(route('users.makeUserNewRecruit')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <h5 class="modal-title" id="exampleModalLongTitle">Do You want to Make User New Recruit</h5>
                            <br>
                            <br>
                            <input type="hidden" name="user_id" id="user_id" class="form-control">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success form-control" onclick="$('#exampleModalNewUserRequest').modal('hide');">
                                    Yes
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
 <?php $__env->startPush('scripts'); ?>
        <script type="text/javascript">
         function goToMakeUserNew(user_id) {
                console.log(user_id)
                $("#user_id").val(user_id);
            }
        </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/Users/index.blade.php ENDPATH**/ ?>