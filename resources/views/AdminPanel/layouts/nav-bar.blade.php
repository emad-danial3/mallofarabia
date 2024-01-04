<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user-alt"></i>
                <span class="badge badge-danger navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{route('generalReports.logout')}}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <span class="float-right text-sm text-danger"><i class="fas fa-sign-out-alt">Sign Out</i></span>
                    </div>
                    <!-- Message End -->
                </a>
            </div>
        </li>

    </ul>
</nav>
<!-- /.navbar -->
