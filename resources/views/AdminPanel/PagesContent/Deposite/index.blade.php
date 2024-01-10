@extends('AdminPanel.layouts.main')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <div class="loader">
        <img class="card-img-top cartimage"
             src="{{asset('test/img/Loading_icon.gif')}}" alt="Card image cap">
    </div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('orderHeaders.index')}}">Orders</a></li>
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
            @if(count($orderHeaders) > 0)
                <table id="orderHeadersTable" style="width: 100%" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Invoice Date</th>
                        <th>Total Orders Cash</th>
                        <th>Cash</th>
                        <th>Visa</th>
                        <th>Visa Refernce</th>
                        <th>Casher</th>
                        <th>User Name</th>
                        <th>User phone</th>
                        <th>View</th>
                        <th>Print</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $row)
                        <tr>
                            
                            <td>{{$row->day}}</td>
                        
                            <td>{{$row->total_order}} </td>
                            <td>{{$row->cash_amount}} </td>
                            <td>{{$row->visa_amount}} </td>
                            <td>{{$row->payment_code}} </td>
                              
                            <td>{{($row->client)?$row->admin->name:''}}</td>
                            <td>{{($row->client)?$row->client->name:''}}</td>
                    
                            <td>{{(isset($row->client))?$row->client->mobile:''}}</td>
                          
                         
                          

                            <td>
                                <a class="btn btn-primary" href="{{route('orderHeaders.view',$row)}}" target="_blank">View</a>
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{route('orderHeaders.show',$row)}}" target="_blank">Print
                                    Invoice</a>
                            </td>
                            <td>{{$row->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                
                </table>
                <div class="pagination justify-content-center mt-2">


                </div>
                @endif
        <!-- /.card-body -->
    </div>
    <div class="d-flex justify-content-center">
{{ $orderHeaders->links('pagination::bootstrap-4') }}
</div>



    






   

    @push('scripts')
    @endpush
@endsection
