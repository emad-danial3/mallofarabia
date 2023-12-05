@include('AdminPanel.layouts.header')
@include('AdminPanel.layouts.nav-bar')
@include('AdminPanel.layouts.sidebar')
<!-- /sidebar menu -->

<div class="content-wrapper">
<!-- page content -->
@yield('content')
<!-- /page content -->
</div>

@include('AdminPanel.layouts.footer')
