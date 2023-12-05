<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="{{url('dashboard')}}/dist/img/AdminLTELogonew.png" alt="AdminLTE Logo"
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
                                <a href="{{route('users.index')}}" class="nav-link">
                                    <i class="far  fa-eye"></i>
                                    <p>All Users</p>
                                </a>
                            </li>
{{--                            <li class="nav-item ps-1">--}}
{{--                                <a href="{{route('users.index',['has_credit_cart'=>0])}}" class="nav-link">--}}
{{--                                    <i class="far  fa-eye"></i>--}}
{{--                                    <p>Users without Cried card</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                        </ul>
                    </li>
                    @can('users')
                        <li class="nav-item">
                            <a href="{{route('accountTypes.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-people-arrows"></i>
                                <p>Account types</p>
                            </a>
                        </li>
                    @endcan

                    <li class="nav-item">
                        <a href="{{route('companies.index')}}" class="nav-link">
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
                                <a href="{{route('productsCategories.mainCategory',['parent_id' => null])}}"
                                   class="nav-link">
                                    <i class="nav-icon fas fa-pager"></i>
                                    <p>Main Category</p>
                                </a>
                            </li>

                            <li class="nav-item ps-1">
                                <a href="{{route('productsCategories.subCategory')}}" class="nav-link">
                                    <i class="nav-icon fas fa-pager"></i>
                                    <p>Sub Category</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item has-treeview">
                        <a href="{{route('products.index')}}" class="nav-link">
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
                                <a href="{{route('orderHeaders.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Orders</p>
                                </a>
                            </li>

{{--                            <li class="nav-item ps-1">--}}
{{--                                <a href="{{route('orderHeaders.ExportShippingSheetSheet')}}" class="nav-link">--}}
{{--                                    <i class="nav-icon fas fa-shopping-bag"></i>--}}
{{--                                    <p>Shipping Sheet</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                            <li class="nav-item ps-1">--}}
{{--                                @if(Auth::guard('admin')->user()->id == 1 || Auth::guard('admin')->user()->id == 17 )--}}
{{--                                    <a href="{{route('orderHeaders.ChangeStatusForOrder')}}" class="nav-link">--}}
{{--                                        <i class="nav-icon fas fa-shopping-bag"></i>--}}
{{--                                        <p>Change Order Status</p>--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                            <li class="nav-item ps-1">--}}
{{--                                <a href="{{route('orderHeaders.create')}}" class="nav-link">--}}
{{--                                    <i class="nav-icon fas fa-shopping-bag"></i>--}}
{{--                                    <p>Add Order</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                            <li class="nav-item ps-1">
                                <a href="{{route('orderHeaders.storeorder')}}" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Add Order</p>
                                </a>
                            </li>

                        </ul>
                    </li>

{{--                    <li class="nav-item">--}}
{{--                        <a href="{{route('oracleInvoices.index')}}" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-shopping-bag"></i>--}}
{{--                            <p>Oracle Invoice Report</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}



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
                                <a href="{{route('purchaseInvoices.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Purchases</p>
                                </a>
                            </li>


                            <li class="nav-item ps-1">

                                <a href="{{route('purchaseInvoices.create')}}" class="nav-link">
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
                                <a href="{{route('generalReports.report')}}" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Sales Report Total</p>
                                </a>
                            </li>


                            <li class="nav-item ps-1">
                                <a href="{{route('generalReports.reports')}}" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Sales Report</p>
                                </a>
                            </li>
                            <li class="nav-item ps-1">
                                <a href="{{route('orderHeaders.reports')}}" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Purchase Reports</p>
                                </a>
                            </li>
                             <li class="nav-item ps-1">
                                <a href="{{route('generalReports.todayreport')}}" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Sales Today</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('orderHeaders.getOracleNumberByOrderId')}}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Oracle Number</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('products.barcode')}}" class="nav-link">

                            <i class="nav-icon fa-solid fa-barcode"></i>
                            <p> Product barcode</p>
                        </a>
                    </li>

                <li class="nav-item">
                        <a href="{{route('generalReports.logout')}}" class="nav-link">
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
