<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="<?php echo e(url('dashboard')); ?>/dist/img/AdminLTELogonew.png" alt="AdminLTE Logo"
             class="brand-image  elevation-3"
        >
        <span class="brand-text font-weight-light">Mall Of Arabia
            <br>
            <?php echo e(session('current_user_name') .' ( Pc '.session('current_pc') .')'); ?>

        </span>
       
        
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                    <li class="nav-item ">
                        <a href="<?php echo e(route('login')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Home
                            </p>
                        </a>

                    </li>
                    <?php if(session('current_user_role') != 'cashier' &&
                    session('current_user_role') != 'accountant'): ?>
                    <li class="nav-item ">
                        <a href="<?php echo e(route('users.index')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Admins
                            </p>
                        </a>

                    </li>
                    <?php endif; ?>

                   




                    <li class="nav-item has-treeview">
                        <a href="<?php echo e(route('products.index')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-cart-plus"></i>
                            <p>
                                Products
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-atom"></i>
                            <p>
                                Orders
                                <i class="fas fa-angle-right right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('orderHeaders.index')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Orders List</p>
                                </a>
                            </li>
                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('return.orders')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Return Orders List</p>
                                </a>
                            </li>

                            <?php if(session('current_user_role') != 'accountant' ): ?>
                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('orderHeaders.storeorder')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Add Order</p>
                                </a>
                            </li>
                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('orderHeaders.returnorder')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Add Return Order</p>
                                </a>
                            </li>
                            <?php endif; ?>

                        </ul>
                    </li>





                  

                    <?php if(session('current_user_role') != 'cashier'): ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Reports
                                <i class="fas fa-angle-right right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <!--  <li class="nav-item ps-1">
                                <a href="<?php echo e(route('generalReports.report')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Sales Report Total</p>
                                </a>
                            </li> -->


                          <!--   <li class="nav-item ps-1">
                                <a href="<?php echo e(route('generalReports.reports')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Sales Report</p>
                                </a>
                            </li> -->
                             <li class="nav-item ps-1">
                                <a href="<?php echo e(route('deposites')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Deposites</p>
                                </a>
                            </li> 
                           <!--   <li class="nav-item ps-1">
                                <a href="<?php echo e(route('generalReports.todayreport')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Sales Today</p>
                                </a>
                            </li> -->
                              <li class="nav-item ps-1">
                                <a href="<?php echo e(route('balance_report_data')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Balance Item Report</p>
                                </a>
                            </li>
                             <li class="nav-item ps-1">
                                <a href="<?php echo e(route('sale_item_report_data')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Sales Item Report</p>
                                </a>
                            </li>
                            <li class="nav-item ps-1">
                            <a href="<?php echo e(route('sale_report_data')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Full Sales  Report </p>
                            </a>
                            </li>

                        </ul>
                    </li>
                    <?php endif; ?>
<!-- 
                    <li class="nav-item">
                        <a href="<?php echo e(route('orderHeaders.getOracleNumberByOrderId')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Oracle Number</p>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a href="<?php echo e(route('products.barcode')); ?>" class="nav-link">

                            <i class="nav-icon fa-solid fa-barcode"></i>
                            <p> Product barcode</p>
                        </a>
                    </li>

                <li class="nav-item">
                        <a href="<?php echo e(route('logout')); ?>" class="nav-link">
                            <i class="nav-icon fa-solid fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH C:\Users\bishoy.sobhy\Desktop\laravel\mall\mallofarabia\resources\views/AdminPanel/layouts/sidebar.blade.php ENDPATH**/ ?>