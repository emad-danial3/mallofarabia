<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="<?php echo e(url('dashboard')); ?>/dist/img/AdminLTELogonew.png" alt="AdminLTE Logo"
             class="brand-image  elevation-3"
        >
        <span class="brand-text font-weight-light">Mall Of Arabia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-right right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('users.index')); ?>" class="nav-link">
                                    <i class="far  fa-eye"></i>
                                    <p>All Users</p>
                                </a>
                            </li>






                        </ul>
                    </li>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('accountTypes.index')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-people-arrows"></i>
                                <p>Account types</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a href="<?php echo e(route('companies.index')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Companies</p>
                        </a>
                    </li>


                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-yen-sign"></i>
                            <p>
                                Product Category
                                <i class="fas fa-angle-right right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('productsCategories.mainCategory',['parent_id' => null])); ?>"
                                   class="nav-link">
                                    <i class="nav-icon fas fa-pager"></i>
                                    <p>Main Category</p>
                                </a>
                            </li>

                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('productsCategories.subCategory')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-pager"></i>
                                    <p>Sub Category</p>
                                </a>
                            </li>
                        </ul>
                    </li>


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
                                    <p>Orders</p>
                                </a>
                            </li>






















                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('orderHeaders.storeorder')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Add Order</p>
                                </a>
                            </li>

                        </ul>
                    </li>










                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                Purchase Invoices
                                <i class="fas fa-angle-right right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('purchaseInvoices.index')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Purchases</p>
                                </a>
                            </li>


                            <li class="nav-item ps-1">

                                <a href="<?php echo e(route('purchaseInvoices.create')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Add Purchase</p>
                                </a>

                            </li>


                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Reports
                                <i class="fas fa-angle-right right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('generalReports.report')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Sales Report Total</p>
                                </a>
                            </li>


                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('generalReports.reports')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Sales Report</p>
                                </a>
                            </li>
                            <li class="nav-item ps-1">
                                <a href="<?php echo e(route('orderHeaders.reports')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Purchase Reports</p>
                                </a>
                            </li>
                             <li class="nav-item ps-1">
                                <a href="<?php echo e(route('generalReports.todayreport')); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Sales Today</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo e(route('orderHeaders.getOracleNumberByOrderId')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Oracle Number</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('products.barcode')); ?>" class="nav-link">

                            <i class="nav-icon fa-solid fa-barcode"></i>
                            <p> Product barcode</p>
                        </a>
                    </li>

                <li class="nav-item">
                        <a href="<?php echo e(route('generalReports.logout')); ?>" class="nav-link">
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
<?php /**PATH E:\emad\mall_of_arabia_store\resources\views/AdminPanel/layouts/sidebar.blade.php ENDPATH**/ ?>