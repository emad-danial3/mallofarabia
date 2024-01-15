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
                        <li class="breadcrumb-item active"><a href="{{route('balance_report_data')}}"> balance report</a></li>
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
        <div class="card-body" style="overflow-x:scroll">
           
                <table id="products-table" style="width: 100%" class="display table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>product name</th>
                        <th> code</th>
                        <th> barcode</th>
                        <th> quantity</th>
                        <th>price</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($products as  $p)
                        <tr>
                           <th>{{$p->name_en}}</th>
                           <th>{{$p->oracle_short_code}}</th>
                           <th>{{$p->barcode}}</th>
                           <th>{{$p->quantity}}</th>
                           <th>{{$p->price}}</th>
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
                title: 'تقرير أرصدة'
            }
            ,'pageLength' 
                ]
        });
      }
    });
    </script>

    @endpush
@endsection
