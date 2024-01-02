@extends('AdminPanel.layouts.main')
@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('users.index')}}">Users</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('AdminPanel.layouts.messages')
<div class="card-body">
        {{-- 
           <h3 class="card-title float-right">
            <a class="btn btn-warning" href="{{route('users.create')}}">Create New User</a>
            </h3>
            --}}
        </div>

        @if(count($users) > 0)
                <table id="usersTable"   class="display"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>

                        <th>Email</th>
                        <th>Role</th>

                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td >{{$row->name}}</td>
                            <td >{{$row->email}}</td>
                            <td >{{$row->role}}</td>

                          
                            <td>
                                {{--   <a class="btn btn-dark" href="{{route('users.edit',$row)}}">Edit</a>
                                <a class="btn btn-success" href="{{route('users.show',$row)}}">Show</a> --}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <script>
                    $(document).ready( function () {
                        $('#usersTable').DataTable();
                    } );
                </script>


            @else
                <h1 class="text-center">NO DATA</h1>
            @endif
        </div>
        <!-- /.card-body -->
    </div>

    <!-- Modal Create Cancel Order Request -->
   

@endsection
 @push('scripts')
        <script type="text/javascript">
         function goToMakeUserNew(user_id) {
                console.log(user_id)
                $("#user_id").val(user_id);
            }
        </script>
    @endpush
