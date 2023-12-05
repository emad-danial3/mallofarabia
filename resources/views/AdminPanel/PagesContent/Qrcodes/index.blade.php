@extends('AdminPanel.layouts.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('registerLinks.index')}}">Qr Codes </a></li>
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
        <div class="card-body">
            @if(count($qrCodes) > 0)
                <table id="areasTable"  class="table table-bordered table-striped" >
                    <thead>
                    <tr>
                        <th> <input type="checkbox" id="select-all"> </th>
                        <th>Code</th>
                        <th># Uses</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>IS Available</th>
                        <th>Get QR</th>
                    </tr>
                    </thead>
                    <tbody>

                    <a href="{{route('qrCodes.create')}}"><button type="button"  class="btn btn-warning mb-4 float-right">Create New
                    </button></a>
                    @foreach($qrCodes as $row)
                        <tr>
                            <td><input type="checkbox" name="checkbox[]" value="{{$row->id}}"/></td>
                            <td>{{$row->code}}</td>
                            <td>{{$row->uses}}</td>
                            <td>{{$row->account_type}}</td>
                            <td>{{$row->start_date}}</td>
                            <td>{{$row->end_date}}</td>
                            <td>{{$row->is_available}}</td>
                            <td>
                                  <button onclick="generateQRCode({{$row}})" type="button" class="btn btn-outline-success " data-toggle="modal" data-target="#exampleModal">Get Code</button>

                                <form action="{{route('changeCodeStatus')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="is_available" value="{{($row->is_available == 1)?0:1}}">
                                    <input type="hidden" name="id" value="{{$row->id}}">
                                    <button  class="btn btn-primary ">change Available</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th># Uses</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>IS Available</th>
                    </tr>
                    </tfoot>
                </table>
                <div class="pagination">

                </div>

            @else
                <h1 class="text-center">NO DATA</h1>
            @endif
        </div>
        <!-- /.card-body -->


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Qr Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div id="qrcode-container">
                                    <div id="qrcode" class="qrcode"></div>
                                    <h3 id="qrcode_type" class="qrcode"></h3>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>

    </div>


    <script type="text/javascript">
        var arr = {1:'Diamond', 2:'Gold', 3:'Silver', 4:'Event(29-3)Diamond', 5:'Event(29-3)Gold', 6:'Event(29-3)Silver'}
    function generateQRCode(row) {
         let qrcodeContainer = document.getElementById("qrcode");
            qrcodeContainer.innerHTML = "";
            let obj='{ "code" : "'+row.code+'" , "type" : "'+row.account_type +'" }';
            var img = document.createElement('img');
            img.src =
                'https://chart.apis.google.com/chart?cht=qr&chs=300x300&chl='+obj;
            document.getElementById('qrcode').appendChild(img);
            let qrcodeType = document.getElementById("qrcode_type").innerHTML = "Type : " + arr[row.account_type];


            // console.log(row)
            // let qrcodeContainer = document.getElementById("qrcode");
            // qrcodeContainer.innerHTML = "";
            // console.log(new QRCode(qrcodeContainer, '{ "code" : "'+row.code+'" , "type" : "'+row.account_type +'" }'));
            // document.getElementById("qrcode-container").style.display = "block";
        }
        // function generateQRCode(row) {
        //     // console.log(row)
        //     // let qrcodeContainer = document.getElementById("qrcode");
        //     // qrcodeContainer.innerHTML = "";
        //     // console.log(new QRCode(qrcodeContainer, '{ "code" : "'+row.code+'" , "type" : "'+row.account_type +'" }'));
        //     // document.getElementById("qrcode-container").style.display = "block";
        // }
    </script>

@endsection
