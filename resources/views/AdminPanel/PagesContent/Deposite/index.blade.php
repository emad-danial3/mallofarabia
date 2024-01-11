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
            @if(count($invoices) > 0)
                <table id="orderHeadersTable" style="width: 100%" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Invoice Date</th>
                        <th>Total Orders Cash</th>
                        <th>Total Day Cash</th>
                        <th>Total Orders Visa</th>
                        <th>Deposite value</th>
                        <th>Deposite Reference</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach($invoices as $row)
                @php
                if($row->deposit_amount)
                {
                    $deposite_text = $row->deposit_amount ;
                }else
                {
                   $deposite_text = "<button data-i='{{ $row->id }}' class='btn btn-success update_invoice'>Add</button>" ; 
                }
                @endphp
                <tr id="{{ $row->id }}">

                <td class="day">{{ $row->day }}</td>

                <td class="">{{ $row->total_order}} </td>
                <td class="total_cash">{{ $row->total_cash_amount - $row->return_total_cash_amount }} </td>
                <td>{{ $row->total_visa_amount }} </td>
                <td>{{ $row->deposit_amount }} </td>
                <td>{{ $row->deposit_refrence }} </td>

                </tr>
                @endforeach
                    </tbody>
                
                </table>
                <div class="pagination justify-content-center mt-2">


                </div>
                @else
                <h1 class="text-center">there is no invoices yet</h1>
                @endif
        <!-- /.card-body -->
    </div>
    <div class="d-flex justify-content-center">
{{ $invoices->links('pagination::bootstrap-4') }}
</div>
 <!-- Modal -->
        <div class="modal fade" id="update_modal" tabindex="-1" role="dialog"
             aria-labelledby="update_modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">Add Deposite to <span id="day"></span> total cash : <span id="cash"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <form id="update_form">
                    <div class="modal-body">
                        <div class="row">
                                
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Deposit Amount</label>
                                    <input class="form-control" type="number" min="0" id="amount" required name="amount" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Deposit Refrence</label>
                                    <input class="form-control" type="number" min="0" id="refrence" required name="refrence">
                                </div>
                            </div>

                        </div>
                       
                    </div>
                    <input type="hidden" name="id" id="invoice_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                        <button id="update_btn" type="button" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    @push('scripts')
    <script type="text/javascript">
        function update_invoice(id)
        {
            var tr = $('#'+id);
            var total_cash = tr.find('.total_cash').html();
            var day = tr.find('.day').html();
            $('#day').html(day);
            $('#cash').html(total_cash);
            $('#update_modal').modal('show');

        }
    $(document).ready(function () {
        $('.update_invoice').on('click',function(){
            var id = $(this).attr('i');
            update_invoice(id);
        });
        $('#update_btn').on('click',function(){

        });
    });
    </script>
    @endpush
@endsection
