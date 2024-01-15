@extends('AdminPanel.layouts.main')
@section('content')
<style>
    #refresh {
        margin-top:30px;
    }
    .btn-group .btn{
        margin:0 3px;
    }
</style>

 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('sale_report_data')}}"> sale report</a></li>
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
        <div class="card-body" style="overflow-x:scroll">
           
                <table id="products-table" style="width: 100%" class="display table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>day</th>
                        <th>total quantity</th>
                        <th>total transaction</th>
                        <th>total discount</th>
                        <th>total visa</th>
                        <th>total cash</th>
                        <th>refund</th>
                        <th>net sales</th>
                        <th title ="average order sale amount">atv</th>
                        <th title ="average order quantity count">ipc</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as  $invoice)
                        <tr>
                           <th>{{$invoice->day}}</th>
                           <th>{{$invoice->total_quantites}}</th>
                           <th>{{$invoice->total_orders_count}}</th>
                           <th>{{$invoice->total_discount}}</th>
                           <th>{{$invoice->total_visa_amount}}</th>
                           <th>{{$invoice->total_cash_amount}}</th>
                           <th>{{$invoice->total_refund}}</th>
                           <th>{{$invoice->total_orders}}</th>
                           <th>{{$invoice->invoice_average_amount}}</th>
                           <th>{{$invoice->invoice_average_quantity}}</th>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
        </div>
        <!-- /.card-body -->
    </div>


    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
   
    <script>

    $(document).ready(function () {
    
     draw_table();
   
      function draw_table()
      {
      
      $('#products-table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [
                [ 10, 50, 100, -1 ],
                [ '10', '50', '100', 'Show all' ]
                ],
                buttons: [
                   'print','copy', {
                extend: 'excel',
                title: 'تقرير بيع'
            }
            ,'pageLength' 
                ]
        });
      }
    });
    </script>

    @endpush
@endsection
