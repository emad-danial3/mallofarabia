
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script src="<?php echo e(url('dashboard')); ?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery -->
<script src="<?php echo e(url('dashboard')); ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo e(url('dashboard')); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(url('dashboard')); ?>/dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="<?php echo e(url('dashboard')); ?>/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo e(url('dashboard')); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- Summernote -->
<script src="<?php echo e(url('dashboard')); ?>/plugins/summernote/summernote-bs4.min.js"></script>

<?php echo $__env->yieldPushContent('scripts'); ?>
<script>


    $('.btn-delete').click(function () {
        swal({
            title: "DO You Want To Do This",
            icon: "warning",
            // buttons: true,
            buttons: {
                cancel: "No",
                ok: "Ok"
            },
            dangerMode: true,
        })
            .then((confirmed) => {
                if (confirmed) {
                    $(this).parents('form').submit()
                }
            });
    });
</script>
</body>
</html>
<?php /**PATH C:\Users\bishoy.sobhy\Desktop\laravel\mall\mallofarabia\resources\views/AdminPanel/layouts/footer.blade.php ENDPATH**/ ?>