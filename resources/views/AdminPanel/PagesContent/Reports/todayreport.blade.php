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
                    <form class="form-inline row" method="get" action="{{url('admin/generalReports/todayreport')}}">
                        <div class="form-group  mb-2 col-md-3">
                            <label for="date_from" class="text-right mr-2">Date </label>
                            <input type="date" id="date_from" name="date_from" @if(app('request')->input('date_from')) value="{{app('request')->input('date_from')}}" @endif  class="form-control" placeholder="Date From" required>
                        </div>
                        <div class="form-group  mb-2 col-md-3">
                            <select id="admin_id" name="admin_id" class="form-control">
                                <option value="">Chose Admin</option>
                                @foreach($Admins as $Admin)
                                    <option value="{{$Admin->id}}"  @if(app('request')->input('admin_id') == $Admin->id)selected @endif>{{$Admin->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 col-md-2">Search</button>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-md-9">

                            <div id="piechart" style="width: 900px; height: 500px;"></div>

                        </div>
                        <div class="col-md-3">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Total Orders Cash: {{$ordersSalesTotalsCash}}</th>
                                    <input type="hidden" value="{{$ordersSalesTotalsCash}}" id="ordersSalesTotalsCash">
                                </tr>
                                <tr>
                                    <th scope="col">Total Orders Visa: {{$ordersSalesTotalVisa}}</th>
                                    <input type="hidden" value="{{$ordersSalesTotalVisa}}" id="ordersSalesTotalVisa">
                                </tr>

                                </thead>
                            </table>
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
