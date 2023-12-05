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
{{--    <div class="card">--}}
{{--        <div class="card-body">--}}

{{--            <h3 class="card-title float-right">--}}
{{--                <a class="btn btn-warning" href="{{route('users.create')}}">Create New User</a>--}}
{{--            </h3>--}}
{{--        </div>--}}
{{--        <div class="card-header" style="float: right">--}}
{{--            <h3 class="card-title">--}}
{{--                <form method="post" action="{{route('users.importUserSheet')}}" enctype="multipart/form-data">--}}
{{--                    @csrf--}}
{{--                    <input type="file"  name="file" required>--}}
{{--                    <button type="submit" class="btn btn-danger">Import User Sheet</button>--}}
{{--                </form>--}}
{{--            </h3>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="card">--}}
{{--        <div class="card-header" style="float: right">--}}
{{--            <h3 class="card-title">--}}
{{--                <form method="post" action="{{route('users.ExportUserSheet')}}" enctype="multipart/form-data">--}}
{{--                    @csrf--}}
{{--                    <div class="form-group col-12">--}}
{{--                        <label class="col-form-label" for="start_date">Start Date</label>--}}
{{--                        <input type="date" name="start_date" required>--}}
{{--                    </div>--}}

{{--                    <div class="form-group col-12">--}}
{{--                        <label class="col-form-label" for="end_date">End Date</label>--}}
{{--                        <input type="date" name="end_date" required>--}}
{{--                    </div>--}}

{{--                    <div class="form-group col-12">--}}
{{--                        <button type="submit" class="btn btn-success">Export User Sheet</button>--}}
{{--                    </div>--}}


{{--                </form>--}}
{{--            </h3>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    --}}
    <div class="card">
{{--        <div class="card-body">--}}

{{--            <form method="get" action="{{route('users.index')}}">--}}
{{--            <input type="text" id="searchtext" name="name">--}}
{{--                <button type="submit" class="btn btn-danger">Search</button>--}}
{{--            </form>--}}
{{--        </div>--}}


        <!-- /.card-header -->
        <div class="card-body">
{{--            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">--}}

        @if(count($users) > 0)
                <table id="usersTable"   class="display"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
{{--                        <th>Front Id Image</th>--}}
{{--                        <th>Back Id Image</th>--}}
{{--                        <th>National Id </th>--}}
{{--                        <th>Serial</th>--}}
                        <th>Mobile</th>
{{--                        <th>Email</th>--}}
{{--                        <th>password</th>--}}
                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td width="150">{{$row->full_name}}</td>
{{--                            <td>--}}
{{--                                @if(isset($row->front_id_image))--}}
{{--                                    @if(strlen($row->front_id_image) > 35)--}}
{{--                                        <a href="./../{{$row->front_id_image}}" target="_blank">Front_ID_Image</a>--}}
{{--                                    @else--}}
{{--                                        <a href="https://4unettinghub.com/{{$row->front_id_image}}" target="_blank">Front_ID_Image</a>--}}
{{--                                    @endif--}}
{{--                                @else--}}
{{--                                    no Image--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                @if(isset($row->front_id_image))--}}
{{--                                    @if(strlen($row->front_id_image) > 35)--}}
{{--                                        <a href="./../{{$row->back_id_image}}" target="_blank">Back_ID_Image</a>--}}
{{--                                    @else--}}
{{--                                        <a href="https://4unettinghub.com/{{$row->back_id_image}}" target="_blank">Back_ID_Image</a>--}}
{{--                                    @endif--}}
{{--                                @else--}}
{{--                                    no Image--}}
{{--                                @endif--}}
{{--                            </td>--}}

{{--                            <td>{{$row->nationality_id}}</td>--}}
{{--                            <td>{{$row->account_id}}</td>--}}
                            <td>{{$row->phone}}</td>
{{--                            <td>{{$row->email}}</td>--}}
{{--                            <td>{{$row->initial_password}}--}}
                            </td>
                            <td>
                                <a class="btn btn-dark" href="{{route('users.edit',$row)}}">Edit</a>
                                <a class="btn btn-success" href="{{route('users.show',$row)}}">Show</a>
{{--                            @if($row->created_at < '2023-04-19')--}}
{{--                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalNewUserRequest" onclick="goToMakeUserNew('{{$row->id}}')">--}}
{{--                                       Make New--}}
{{--                                </button>--}}
{{--                            @endif--}}
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
    <div class="modal fade" id="exampleModalNewUserRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalNewUserRequestTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order Cancel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('users.makeUserNewRecruit')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <h5 class="modal-title" id="exampleModalLongTitle">Do You want to Make User New Recruit</h5>
                            <br>
                            <br>
                            <input type="hidden" name="user_id" id="user_id" class="form-control">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success form-control" onclick="$('#exampleModalNewUserRequest').modal('hide');">
                                    Yes
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
 @push('scripts')
        <script type="text/javascript">
         function goToMakeUserNew(user_id) {
                console.log(user_id)
                $("#user_id").val(user_id);
            }
        </script>
    @endpush
