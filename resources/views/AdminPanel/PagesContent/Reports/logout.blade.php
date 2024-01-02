@extends('AdminPanel.layouts.main')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('generalReports.report')}}">Reports</a></li>

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
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>Business sales today</h1>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4><span class="h5">Casher name : </span> {{$admin}}</h4>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4><span class="h5">From date : </span> {{$date_from}}</h4>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4><span class="h5">To date: </span> {{$date_to}}</h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-8">

                            <div id="piechart" style="width: 900px; height: 500px;"></div>

                        </div>
                        <div class="col-md-4">
                            <table class="table table-striped">
                                <thead>

                                 <tr>
                                    <th scope="col">Total Sales: {{$total}} LE</th>
                                    <th scope="col">Orders Count: {{$totalcount}}</th>
                                </tr>

                                <tr>
                                    <th scope="col">Total Orders Cash: {{$ordersSalesTotalsCash}} LE</th>
                                    <th scope="col">Orders Count: {{$ordersSalesTotalsCashCount}}</th>
                                    <input type="hidden" value="{{$ordersSalesTotalsCash}}" id="ordersSalesTotalsCash">
                                </tr>

                                <tr>
                                    <th scope="col">Total Orders Visa: {{$ordersSalesTotalVisa}} LE</th>
                                     <th scope="col">Orders Count: {{$ordersSalesTotalsCashCount}}</th>
                                    <input type="hidden" value="{{$ordersSalesTotalVisa}}" id="ordersSalesTotalVisa">
                                </tr>

                                </thead>
                            </table>
                             <div class="text-center w-100">
                            <a class="btn btn-danger mb-2 mx-auto w-100" id="logoutButton" href="{{ url('logout') }}"> {{trans('website.Logout',[],session()->get('locale'))}}</a>
                            </div>
                        </div>

                    </div>


                </div>
            </div>



            <!-- /.row -->
        </div><!-- /.container-fluid -->

    </section>

    @push('scripts')

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var Cash = parseFloat($('#ordersSalesTotalsCash').val());
                var Visa = parseFloat($('#ordersSalesTotalVisa').val());
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['Cash', Cash],
                    ['Visa', Visa],
                ]);

                var options = {
                    title: (Cash > 0 || Visa > 0) ? 'My Total Sales' : ''
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>
    @endpush
@endsection
