@extends('AdminPanel.layouts.main')
@section('content')
    @include('AdminPanel.layouts.messages')

    @if(Auth::guard('admin')->user()->id == 24 )
    @else
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="btn btn-success" href="{{route('updateOracleProducts')}}">Update Oracle Codes</a>
                        {{--                    <a class="btn btn-success" id="test">Update Oracle Codes</a>--}}

                        <br>
                        <br>
                        <br>
                        <a class="btn btn-danger" href="{{route('updateOracleProductsPrice')}}">Update Products
                            Price</a>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    @endif
@endsection
@push('scripts')
    <script>
        $("#test").click(function () {
            $.ajax({

                url: "https://sales.atr-eg.com/api/RefreshNettinghubItems.php",
                beforeSend: function (xhr) {
                    xhr.overrideMimeType("text/plain; charset=x-user-defined");
                }
            })
                .done(function (data) {

                    $.ajax({
                        type: 'POST',  // http method
                        data: {myData: data},  // data to submit
                        url: "http://127.0.0.1:8000/api/updateTableJS",
                        beforeSend: function (xhr) {
                            xhr.overrideMimeType("text/plain; charset=x-user-defined");
                        }
                    })
                        .done(function (data) {
                            updateTableJS
                            if (console && console.log) {
                                console.log("Sample of data:", JSON.stringify(data));
                            }
                        });

                });
        });
        // $(document).ready(function(){
        //     $("#test").click(function(){
        //         $.get("", function(data, status){
        //             console.log("Data: " + data + "\nStatus: " + status);
        //         });
        //     });
        // });
    </script>
@endpush

