@extends('AdminPanel.layouts.main')
@section('content')


   
   
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
  <div class="card-body pb-0">
            <form method="get">
            <div class="row">
           <div class="form-group col-4">
               <label class="form-label">From</label>
               <input class="form-control" id="fromInput" type="date" name="from" value="{{$from}}">
           </div>
           <div class="form-group col-4">
               <label class="form-label">To</label>
               <input class="form-control" id="toInput" type="date" name="to" value="{{$to}}">
           </div>
           <div class="col-4">
               
           <button class="btn btn-primary" id="refresh" type="submit">Refresh</button>
           </div>
        </div>
           </form>
        </div>





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

                            <td>{{($row->shift)?$row->shift->cashier->name:''}}</td>
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
