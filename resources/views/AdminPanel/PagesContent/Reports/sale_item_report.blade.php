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


    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('sale_item_report_data')}}">item sale report</a></li>
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
                        <th>اسم المنتج</th>
                        <th>باركود</th>
                        @foreach($all_days as $day)
                        <th>{{$day}}</th>
                        @endforeach
                        <th>توتال</th>
                        <th>توتال مبيعات</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($records as  $record)
                        <tr>
                            @foreach($record as $index => $value)
                            <th>{{$value}}</th>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>

                </table>
        </div>
        <!-- /.card-body -->
    </div>


    @push('scripts')
    
   
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
                title: 'تقرير الاصناف'
            }
            ,'pageLength' 
                ]
        });
      }
    });
    </script>

    @endpush
@endsection
