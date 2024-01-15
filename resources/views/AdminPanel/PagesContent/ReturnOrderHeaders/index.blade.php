@extends('AdminPanel.layouts.main')
@section('content')

 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
   
   
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('return.orders')}}">Return Orders</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('AdminPanel.layouts.messages')

    <div class="card">






        <!-- /.card-header -->
        <div class="card-body" >
            @if(count($orderHeaders) > 0)
                <table id="orderHeadersTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>return Invoice Number</th>
                        <th>order Invoice Number</th>
                        <th>Total Order</th>
                        <th>Cash</th>
                        <th>Visa</th>
                        <th>Visa Refernce</th>
                        <th>Casher</th>
                        <th>User Name</th>
                        <th>User phone</th>
                        <th>View</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orderHeaders as $row)
                        <tr>

                            <td>{{$row->id}}</td>
                            <td> <a href="{{route('orderHeaders.view',$row->reference_order_id )}}">{{$row->reference_order_id}}</td>

                            <td>{{$row->total_order}} </td>
                            <td>{{$row->cash_amount}} </td>
                            <td>{{$row->visa_amount}} </td>
                            <td>{{$row->payment_code}} </td>

                            <td>{{($row->client)?$row->admin->name:''}}</td>
                            <td>{{($row->client)?$row->client->name:''}}</td>

                            <td>{{(isset($row->client))?$row->client->mobile:''}}</td>



                            <td>
                                <a class="btn btn-primary" href="{{route('return.view',$row )}}" target="_blank">View</a>
                            </td>
                       
                            <td>{{$row->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
               
                @endif
        <!-- /.card-body -->
    </div>


    







 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
    @push('scripts')
        <script type="text/javascript">
        

            $(document).ready(function () {});

           $('#orderHeadersTable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [
                [ 10, 50, 100, -1 ],
                [ '10', '50', '100', 'Show all' ]
                ] ,
                buttons: [
                   'print','copy', {
                extend: 'excel',
                title: 'تقرير مرتجعات'
            }
            ,'pageLength' 
                ]
        });



        </script>
    @endpush
@endsection
