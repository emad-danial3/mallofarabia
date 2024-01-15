@extends('AdminPanel.layouts.main')
@section('content')
<style type="text/css">
    .status {
        cursor: default!important;
    }
</style>
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
                        <li class="breadcrumb-item active"><a href="{{route('get_pcs')}}">PC Control</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('AdminPanel.layouts.messages')

    <div class="card">
       
    <div class=" d-none alert "></div>


       

        <!-- /.card-header -->
        <div class="card-body" style="overflow-x:scroll">
            @if(count($pcs) > 0)
                <table id="orderHeadersTable" style="width: 100%" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                         <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach($pcs as $row)
                 <tr id="{{ $row->id }}">
                    <td>{{ $row->name }}</td>
                    <td>
                       <span class="btn status {{ $row->is_closed ? 'btn-danger' : 'btn-success' }} ">
                            {{ $row->is_closed ? 'Closed' : 'Open' }}
                        </span>
                    </td>
                    <td>
                      <button class="change_status btn {{ $row->is_closed ? 'btn-success' : 'btn-danger' }}" data-status="{{ $row->is_closed }}" data-pc-id="{{ $row->id }}">
                            {{ $row->is_closed ? 'Open' : 'Close' }}
                        </button>
                    </td>
                </tr>
                @endforeach
                    </tbody>
                
                </table>
                <div class="pagination justify-content-center mt-2">


                </div>
                @else
                <h1 class="text-center">There are no PCs active; please contact your administrator.</h1>
                @endif
        <!-- /.card-body -->
    </div>
   


    @push('scripts')
    <script type="text/javascript">
       
    $(document).ready(function () {
        $('.change_status').on('click',function(){
            $('.alert').addClass('d-none');
            $('.btn.change_status').prop('disabled', true);
            $(this).html('<i class="fa fa-spinner"></i>');
            var pc_id = $(this).data('pc-id');
            var status = $(this).data('status');
            var is_closed = 0 ;
            if(status == 0)var is_closed = 1 ;
            
            var data = {
                    "pc_id": pc_id,
                    "is_closed": is_closed ,
                }
                $.ajax({
                    url: '{{ route('update_pc_status');}}',
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
                        $('.alert').removeClass('alert-success');
                        $('.alert').removeClass('alert-danger');
                      if(response.status != 200)
                      {
                        $('.alert').addClass('alert-danger');
                        $('.alert').html(response.message);
                      }else{
                        $('#'+pc_id).find('.status').html(get_status(is_closed)).removeClass('alert-danger').removeClass('alert-success').addClass(get_class(is_closed));
                        $('#'+pc_id).find('.change_status').data('status',is_closed).html(get_status_order(is_closed)).removeClass('alert-danger').removeClass('alert-success').addClass(get_class_order(is_closed));
                        $('.alert').addClass('alert-success');
                        $('.alert').html(response.message);
                        
                      }
                        $('.alert').removeClass('d-none');
                        $('.btn.change_status').prop('disabled', false);
                    },
                    error: function (response) {
                        alert(response)
                    }
                });
        });
        function get_status(is_closed)
        {
            if(is_closed)
            {
                return 'Closed';
            }
            return 'Open' ;
        }
        function get_status_order(is_closed)
        {
            if(is_closed)
            {
                return 'Open';
            }
            return 'Close' ;
        }
        function get_class(is_closed)
        {
            if(is_closed)
            {
                return 'alert-danger';
            }
            return 'alert-success' ;
        }
        function get_class_order(is_closed)
        {
            if(is_closed)
            {
                return 'alert-success';
            }
            return 'alert-danger' ;
        }
    });
    </script>
    @endpush
@endsection
