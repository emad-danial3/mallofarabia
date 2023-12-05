@extends('AdminPanel.layouts.main')
@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form  action="{{route('notifications.store')}}" method="post" enctype="multipart/form-data">
                            @include('AdminPanel.layouts.messages')
                            @csrf

                            <!-- Button trigger modal -->

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Emoji</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    @for($i=8511;$i<9686;$i++)
                                                        <div class="col-lg-2">
                                                            <span style='font-size:20px;background: #FFFFFF'>&#12{{$i}};</span>
                                                            <button type="button" class="btn-success"   value="&#12{{$i}};" onclick="copyFunction('&#12{{$i}};')"><i class="nav-icon fas fa-copy">&nbsp;Copy</i></button>
                                                        </div>
                                                    @endfor
                                                    @for($i=986;$i<1000;$i++)
                                                        <div class="col-lg-2">
                                                            <span style='font-size:20px;background: #FFFFFF'>&#8{{$i}};</span>
                                                            <button type="button" class="btn-success"  value="&#8{{$i}};" onclick="copyFunction('&#8{{$i}};')"><i class="nav-icon fas fa-copy">&nbsp;Copy</i></button>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="card-body">
                                <label for="title">Emoji</label>
                                <button type="button" class="btn btn-success" style="background:#0000000d;" data-toggle="modal" data-target="#exampleModal">
                                    &#128513;
                                </button>
                            </div>
                            <div class="card-body">
                                <label for="title">Title </label>
                              <textarea id="summernote2" name="title" required>

                              </textarea>
                            </div>

                            <div class="card-body">
                                <label for="body">Message</label>
                              <textarea id="summernote" name="body" required>

                              </textarea>
                            </div>
 <h3 class="modal-title">&nbsp; Send By</h3>
                            <table class="table table-hover table-striped">
                                <tbody>
                                <tr>
                                    <th>Notification</th>
                                    <td>
                                        <input type="checkbox" id="1" name="mediaType[]" value="1">
                                    </td>
                                </tr>

                                <tr>
                                    <th>SMS</th>
                                    <td>
                                        <input type="checkbox" id="2" name="mediaType[]" value="2">
                                    </td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>
                                        <input type="checkbox" id="3" name="mediaType[]" value="3">
                                    </td>
                                </tr>



                                </tbody>
                            </table>

                                 <div class="row">
                                   <div class="col-md-9">
                                       <h3 class="modal-title">&nbsp; Users</h3>
                                   </div>
                                   <div class="col-md-3">
                                           <div class="input-group">
                                               <input type="text" id="searchtext" name="name" class="form-control" placeholder="Search User Name" aria-label="Input group example" aria-describedby="btnGroupAddon2" onkeyup="myFunction()">
                                           </div>
                                   </div>
                               </div>


                            <table   class="table table-bordered table-striped" id="myTable">
                                <thead>
                                <tr>
                                    <th style="width: 30%"> <input type="checkbox" id="select-all"> Select All</th>
                                    <th>Name</th>
                                    <th> <button type="submit" class="btn btn-success">Send  Data</button></th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $row)
                                    <tr>
                                        <td><input type="checkbox" class="select-all" name="usersId[]" value="{{$row->id}}"/></td>
                                        <td colspan="2">{{$row->full_name}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Send  Data</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->

         <button onclick="window.scrollTo({ left: 0, top: document.body.scrollHeight, behavior: 'smooth' })" id="myBtn" title="Go to bottom"><i class="fa-sharp fa-solid fa-chevron-down"></i></button>
        <button onclick="window.scrollTo({ left: 0, top: 0, behavior: 'smooth' })" id="myBtn2" title="Go to bottom"><i class="fa-sharp fa-solid fa-chevron-up"></i></button>

    </section>
    @push('scripts')
        <script>
            $('#select-all').click(function() {
                var checked = this.checked;
                $('.select-all').each(function() {
                    this.checked = checked;
                });
            });
            $(function () {
                // Summernote
                $('#summernote').summernote();
                $('#summernote2').summernote();
            });
            $(function () {
                $("#example1").DataTable();
                 $("#myBtn").css({
                    "position": "fixed",
                    "bottom": "20px",
                    "right": "30px",
                    "z-index": "99",
                    "border": "none",
                    "outline": "none",
                    "background-color": "#bbb",
                    "color": "white",
                    "cursor": "pointer",
                    "padding": "7px",
                    "border-radius": "10px",
                    "font-size": "18px"
                });
                $("#myBtn").hover(function(){
                    $(this).css("background-color", "#555");
                }, function(){
                    $(this).css("background-color", "#bbb");
                });

                $("#myBtn2").css({
                    "position": "fixed",
                    "bottom": "20px",
                    "right": "70px",
                    "z-index": "99",
                    "border": "none",
                    "outline": "none",
                    "background-color": "#bbb",
                    "color": "white",
                    "cursor": "pointer",
                    "padding": "7px",
                    "border-radius": "10px",
                    "font-size": "18px"
                });
                $("#myBtn2").hover(function(){
                    $(this).css("background-color", "#555");
                }, function(){
                    $(this).css("background-color", "#bbb");
                });
            });

            function copyFunction(test)
            {
                navigator.clipboard.writeText(test);
            }

                function myFunction() {
                // Declare variables
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("searchtext");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");

                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }

        </script>
    @endpush
@endsection
