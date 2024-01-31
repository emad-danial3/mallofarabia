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
                        <th>Oralce id</th>
                        <th>day</th>
                        <th>total quantity</th>
                        <th>total transaction</th>
                        <th>total discount</th>
                        <th>total visa</th>
                        <th>total cash</th>
                        <th>refund</th>
                        <th>net sales</th>
                        <th>oils orders</th>
                        <th>oils return</th>
                        <th title ="average order sale amount">atv</th>
                        <th title ="average order quantity count">ipc</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as  $invoice)
                        <tr>
                        <th>{{$invoice->oracle_id}}
                            @if(session('user_id') == 1)
                            <button  data-id="{{$invoice->id}}" class="btn btn-info send_again">send again</button>
                            @endif
                        </th>
                           <th>{{$invoice->day}}</th>
                           <th>{{$invoice->total_quantites}}</th>
                           <th>{{$invoice->total_orders_count}}</th>
                           <th>{{$invoice->total_discount}}</th>
                           <th>{{$invoice->total_visa_amount}}</th>
                           <th>{{$invoice->total_cash_amount}}</th>
                           <th>{{$invoice->total_refund}}</th>
                           <th>{{$invoice->total_orders}}</th>
                          
                            <th>{{$invoice->total_orders_oil}}</th>
                            <th>{{$invoice->total_return_orders_oil}}</th>
                           <th>{{ round($invoice->invoice_average_amount,2)}}</th>
                           <th>{{round($invoice->invoice_average_quantity,2)}}</th>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                     <tr>
                       
                        <th>Oralce id</th>
                        <th>day</th>
                        <th>total quantity</th>
                        <th>total transaction</th>
                        <th>total discount</th>
                        <th>total visa</th>
                        <th>total cash</th>
                        <th>refund</th>
                        <th>net sales</th>
                        <th>oils orders</th>
                        <th>oils return</th>
                        <th title ="average order sale amount">atv</th>
                        <th title ="average order quantity count">ipc</th>
                       
                    </tr>
                    </tfoot>

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
    $('.send_again').on('click',function()
    {
        var path = '{{ route("send_invoice_again");}}';
        var id = $(this).data('id');
        var data = {
                    "id": id,
                }
                $.ajax({
                    url: path,
                    type: 'POST',
                    cache: false,
                    data: JSON.stringify(data),
                    contentType: "application/json; charset=utf-8",
                    traditional: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                      if(response.status != 200)
                      {
                         alert(response.message);
                      }else{
                        alert(response.message);
                        location.reload();
                      }
                    },
                    error: function (response) {
                        alert(response)
                    }
                });
    })
     draw_table();
   
      function draw_table()
      {
      var is_admin = {{ session('user_id') == 1 ? 'true' : 'false' }};

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
                 exportOptions: {
                            modifier: {
                            page: 'all'
                            },
                        columns: [1,2,3,4,5,6,8,9,10,11,12]
                        } ,
                title: 'تقرير بيع'
            }
            ,'pageLength' 
                ],
                "columnDefs": 
                [
                    {
                        "targets": [5,6,7,8], 
                        "render": function(data, type, row, meta) 
                        {
                            if (type === 'display') 
                            {
                                return format_number(data);
                            }
                            return data;
                        }
                    },
                    

                ],
            "footerCallback": function(row, data, start, end, display) {
            var api = this.api();
            var all_sale = 0 ;
            var all_orders_count = 0 ;
            var all_quantity_count = 0 ;
            var columnsToSum = [2,3,4,5, 6,7,8,9,10];
            columnsToSum.forEach(function(colIndex) {
            var total = api
                .column(colIndex)
                .data()
                .reduce(function(acc, val) {
                    return acc + parseFloat(val) ;
                }, 0);
            if(colIndex == 2) all_quantity_count = total ;
            if(colIndex == 3) all_orders_count = total ;
            if(colIndex == 8) all_sale = total ;
          
            $( api.column(colIndex).footer()).html('Total: ' + format_number(total) );
        
            });

           var all_atv = all_sale / all_orders_count ;
           var all_ipc = all_quantity_count  / all_orders_count ;

            $(api.column(11).footer()).html('Total ATV: ' + format_number(all_atv) );
            $(api.column(12).footer()).html('Total IPC: ' + format_number(all_ipc) );
        
            
        }
        });
      }
    });
    function format_number(number)
    {
        if(!number) return '0' ;
      return  parseFloat(number).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
                });
    }
    </script>

    @endpush
@endsection
