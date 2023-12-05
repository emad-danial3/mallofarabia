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
                    <form class="form-inline row" method="get" action="{{url('admin/generalReports/report')}}">
                        <div class="form-group  mb-4 col-md-3">
                            <label for="date_from" class="text-right mr-2">Type</label>
                            <select name="type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="order" @if(app('request')->input('type') == 'order')selected @endif>
                                    Order
                                </option>
                                <option value="user" @if(app('request')->input('type') == 'user')selected @endif>User
                                </option>
                            </select>

                        </div>
                        <div class="form-group  mb-2 col-md-3">
                            <label for="date_from" class="text-right mr-2">Date From </label>
                            <input type="date" id="date_from" name="date_from" @if(app('request')->input('type') == 'order')selected @endif @if(isset($date_from) && $date_from !='' ) value="{{$date_from}}" @endif class="form-control" placeholder="Date From" required>
                        </div>
                        <div class="form-group  mb-2 col-md-3">
                            <label for="date_to" class="text-right mr-2">Date To </label>
                            <input type="date" id="date_to" name="date_to" @if(isset($date_to) && $date_to !='' ) value="{{$date_to}}" @endif class="form-control" placeholder="Date To" required>
                        </div>

                        <button type="submit" class="btn btn-primary mb-2 col-md-2">Search</button>
                    </form>
                    <hr>
                    <div class="row">
                        @if(app('request')->input('type') == 'order')
                            <div class="col-md-12 text-center">
                                <h2> Paid Sales</h2>
                            </div>
                        @endif
                        <div class="col-md-8">

                            <div id="piechart" style="width: 900px; height: 500px;"></div>

                        </div>
                        <div class="col-md-4">
                            <br>
                            <br>
                            <br>
                            <table class="table table-striped">
                                <thead>
                                @if(app('request')->input('type') == 'order')
                                    <tr>
                                        <th scope="col">Total Orders : {{number_format($ordersSalesTotal)}}</th>
                                        <th scope="col">Orders Count: {{$totalcount }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Sales Web  : {{number_format($ordersSalesWeb)}}</th>
                                        <th scope="col">Orders Count: {{$ordersSalesTotalsWebCount}}</th>
                                        <input type="hidden" value="{{$ordersSalesWeb}}" id="ordersSalesWeb">
                                    </tr>
                                    <tr>
                                        <th scope="col">Sales Mobile : {{number_format($ordersSalesmobile)}}</th>
                                        <th scope="col">Orders Count: {{$ordersSalesTotalsmobileCount}}</th>
                                        <input type="hidden" value="{{$ordersSalesmobile}}" id="ordersSalesmobile">
                                    </tr>
                                    <tr>
                                        <th scope="col">Sales Bazar : {{number_format($ordersSalesAdmin)}}</th>
                                        <th scope="col">Orders Count: {{$ordersSalesTotalsAdminCount}}</th>
                                        <input type="hidden" value="{{$ordersSalesAdmin}}" id="ordersSalesAdmin">
                                    </tr>
                                    <tr>
                                        <th scope="col">Sales Bazar OnLine : {{number_format($ordersSalesonLine)}}</th>
                                        <th scope="col">Orders Count: {{$ordersSalesTotalsonLineCount}}</th>
                                        <input type="hidden" value="{{$ordersSalesonLine}}" id="ordersSalesonLine">
                                    </tr>
                                @endif
                                @if(app('request')->input('type') == 'user')
                                    <tr>
                                        <th scope="col">Total Recruits Users : {{$usersCount}}</th>
                                    </tr>
                                @endif

                                </thead>
                            </table>
                        </div>

                        @if(app('request')->input('type') == 'order')
                            <div class="col-md-12 text-center">
                                <h2> Registered Sales</h2>
                            </div>
                        @endif

                        <div class="col-md-8">

                            <div id="piechartre" style="width: 900px; height: 500px;"></div>

                        </div>

                        <div class="col-md-4">
                            <br>

                            <table class="table table-striped">
                                <thead>
                                @if(app('request')->input('type') == 'order')
                                    <tr>
                                        <th scope="col">Total Orders : {{number_format($ordersSalesTotalre)}}</th>
                                        <th scope="col">Orders Count: {{$totalcountre}}</th>

                                    </tr>
                                    <tr>
                                        <th scope="col">Sales Web  : {{number_format($ordersSalesWebre)}}</th>
                                        <th scope="col">Orders Count: {{$ordersSalesTotalsWebCountre}}</th>
                                        <input type="hidden" value="{{$ordersSalesWebre}}" id="ordersSalesWebre">
                                    </tr>
                                    <tr>
                                        <th scope="col">Sales Mobile : {{number_format($ordersSalesmobilere)}}</th>
                                        <th scope="col">Orders Count: {{$ordersSalesTotalsmobileCountre}}</th>
                                        <input type="hidden" value="{{$ordersSalesmobilere}}" id="ordersSalesmobilere">
                                    </tr>
                                    <tr>
                                        <th scope="col">Sales Bazar : {{number_format($ordersSalesAdminre)}}</th>
                                        <th scope="col">Orders Count: {{$ordersSalesTotalsAdminCountre}}</th>
                                        <input type="hidden" value="{{$ordersSalesAdminre}}" id="ordersSalesAdminre">
                                    </tr>
                                    <tr>
                                        <th scope="col">Sales Bazar OnLine : {{number_format($ordersSalesonLinere)}}</th>
                                        <th scope="col">Orders Count: {{$ordersSalesTotalsonLineCountre}}</th>
                                        <input type="hidden" value="{{$ordersSalesonLinere}}" id="ordersSalesonLinere">
                                    </tr>
                                @endif

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
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var Web=parseFloat($('#ordersSalesWeb').val());
                var Mobile=parseFloat($('#ordersSalesmobile').val());
                var Bazar=parseFloat($('#ordersSalesAdmin').val());
                var onLine=parseFloat($('#ordersSalesonLine').val());
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['Web',     Web],
                    ['Mobile',      Mobile],
                    ['Bazar',  Bazar],
                    ['Bazar OnLine', onLine],
                ]);

                var options = {
                    title: Web>0? 'My Total Sales Paid':''
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);


                var Webre=parseFloat($('#ordersSalesWebre').val());
                var Mobilere=parseFloat($('#ordersSalesmobilere').val());
                var Bazarre=parseFloat($('#ordersSalesAdminre').val());
                var onLinere=parseFloat($('#ordersSalesonLinere').val());
                var datare = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['Web',     Webre],
                    ['Mobile',      Mobilere],
                    ['Bazar',  Bazarre],
                    ['Bazar OnLine', onLinere],
                ]);

                var optionsre = {
                    title: Web>0? 'My Total Sales Registered':''
                };

                var chartre = new google.visualization.PieChart(document.getElementById('piechartre'));

                chartre.draw(datare, optionsre);
            }
        </script>
    @endpush
@endsection
