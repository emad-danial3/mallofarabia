<?php $__env->startSection('content'); ?>


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('adminDashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('users.index')); ?>">Users</a></li>
                        <li class="breadcrumb-item active"><?php echo e(isset($user)?'Edit / '.$user->full_name :'ADD'); ?></li>
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
                        <form  action="<?php echo e((isset($user))?route('users.update',$user):route('users.store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo $__env->make('AdminPanel.layouts.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo csrf_field(); ?>
                            <?php echo e(isset($user)?method_field('PUT'):''); ?>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">full_name</label>
                                    <input type="text" name="full_name" class="form-control"
                                           placeholder="Enter Name" value="<?php if(old('full_name')): ?><?php echo e(old('full_name')); ?><?php elseif(isset($user->full_name)): ?><?php echo e($user->full_name); ?><?php endif; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input type="text" name="email" class="form-control"
                                           placeholder="Enter Email" value="<?php if(old('email')): ?><?php echo e(old('email')); ?><?php elseif(isset($user->email)): ?><?php echo e($user->email); ?><?php endif; ?>" required>
                                </div>
                                
                              

                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="number" name="phone" id="materialRegisterFormPassword"  class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock" name="mob1" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==11 && event.keyCode!=8) return false;"   value="<?php if(old('phone')): ?><?php echo e(old('phone')); ?><?php elseif(isset($user->phone)): ?><?php echo e($user->phone); ?><?php endif; ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="password">Password <span style="color: red"> ( Write if you want to change it ) </span> </label>
                                    <input type="password" placeholder="Password" class="form-control"  minlength="6" maxlength="8"  name="password"  >
                                </div>

                                <div class="form-group">
                                    <label for="front_id_image">Front ID Image</label>
                                    <input type="file" class="form-control" name="front_id_image"  <?php if(!isset($user)): ?>required <?php endif; ?>>
                                </div>

                                <div class="form-group">
                                    <label for="back_id_image">Back ID Image</label>
                                    <input type="file" class="form-control" name="back_id_image" <?php if(!isset($user)): ?>required <?php endif; ?>>
                                    <br>
                                    <?php if(isset($user->front_id_image)): ?>
                                        <img src="<?php echo e($user->front_id_image); ?>" width="250" height="250">
                                    <?php endif; ?>
                                    <?php if(isset($user->back_id_image)): ?>
                                        <img src="<?php echo e(url($user->back_id_image)); ?>" width="250" height="250">
                                    <?php endif; ?>
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
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('AdminPanel.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/PagesContent/Users/edit.blade.php ENDPATH**/ ?>