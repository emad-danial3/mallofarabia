@extends('AdminPanel.layouts.main')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('orderHeaders.index')}}">Orders</a></li>
                        <li class="breadcrumb-item"><a href="#">Refund Invoice</a></li>

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
                        <div class="alert alert-primary" role="alert" id="infoMessage" style="display: none">

                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @foreach($invoicesNumber as $invoiceNumber)


                            <div class="container page-break" style="direction: rtl;">
                                <div class="row">


                                    <table class="table table-borderless">

                                        <tbody>
                                        <tr>
                                            <td style="width: 15%;" ;="" class="col">
                                                <span style="font-weight:bolder">مسلـسـل بـيــع </span>
                                                <br>
                                                <span style="font-weight:bolder">التـاريـــخ فـــى </span>
                                                <br>
                                                <span style="font-weight:bolder">اســــم العمـيــل </span>
                                                <br>
                                                <span style="font-weight:bolder">تاريـخ الايصال  </span>
                                                <br>
                                                <span style="font-weight:bolder">توقيت الايصال  </span>


                                            </td>
                                            <td style="width: 20%;" ;="" class="col">



                                                <span>{{$orderHeader->id}}</span>
                                                <br>
                                                <span>
			                 <?php
                                                    $creatat=$orderHeader->created_at;
                                                    $creatdate=substr($creatat, 0,10);
                                                    $creattime=substr($creatat,10)
                                                    ?>
                                                    {{$creatdate}}
</span>
                                                <br>
                                                <span>{{$user->full_name}}</span>
                                                <br>

                                                <span>{{$creatdate}}</span>
                                                <br>

                                                <span>{{$creattime}}</span>

                                            </td>
                                            <td style="width: 30%;" class="col">	<img style="width: 80%;"  src="https://4unettinghub.com/website/test/img/logo%20netting%20hup%20.png">
                                            </td>

                                            <td style="width: 15%;" ;="" class="col">

                                                <span style="font-weight:bolder;">Promo Code  </span>
                                                <br>
                                                <span style="font-weight:bolder;margin-left:20px;">تليــفــون رقم  </span>
                                                <br>
                                                <span style="font-weight:bolder;margin-left:20px;">شكاوى العملاء  </span>
                                                <br>
                                                <span style="font-weight:bolder;margin-left:20px;">E-Mail  </span>


                                            </td>
                                            <td style="width: 20%;" ;="" class="col">
                                                <span>#N/A</span>
                                                <br>

                                                <span style="unicode-bidi: plaintext;">{{$user->phone}}</span>
                                                <br>
                                                <span style="unicode-bidi: plaintext;">0122 5865555</span>
                                                <br>
                                                <span>{{$user->email}}</span>

                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>


                                    <div class="col-md-3">
                                        <table style="border-color:black;" class="table table-bordered">

                                            <?php
                                            $or14=$orderHeader->total_order*14%100;
                                            ?>
                                            <tbody>

                                            <tr>
                                                <th style="text-align: center;" >صافى القيمة</th>
                                                <td style="text-align: center;">{{$orderHeader->total_order}}</td>

                                            </tr>


                                            <tr>
                                                <th style="text-align: center;" >عدد الاصناف</th>
                                                <td style="text-align: center;">{{count($invoicesLines)}} </td>

                                            </tr>

                                            <tr>
                                                <th style="text-align: center;" >اجمالى الكمية</th>
                                                <td style="text-align: center;">{{$orderHeader->total_order + $orderHeader->shipping_account}} </td>

                                            </tr>



                                            </tbody>
                                        </table>

                                    </div>

                                    <form  action="{{route('orderHeaders.update',$orderHeader)}}" method="post" enctype="multipart/form-data" class="col-md-9">

                                        @csrf
                                        <input type="hidden" value="{{$orderHeader->total_order}}" id="total_order" name="total_order">
                                        {{method_field('PUT')}}

                                    <table style="border-color:black;" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center;" scope="col">اسم الصنف</th>
                                            <th style="text-align: center;" scope="col">الكمية</th>
                                            <th style="text-align: center;" scope="col">السعر</th>
                                            <th style="text-align: center"><input type="checkbox" id="select-all"> All </th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $i = 1;
                                        ?>

                                        @foreach($invoicesLines as $orderlines)
                                            {{--                    <p></p>{{$orderlines->oracle_num}}--}}

                                            @if($invoiceNumber->oracle_num == $orderlines->oracle_num)
                                                <tr>
                                                    {{--                            {{$orderlines->oracle_num}}--}}
                                                    <td style="text-align: center;">{{$orderlines->psku}}</td>
                                                    <td style="text-align: center;">{{$orderlines->olquantity}}</td>
                                                    <td style="text-align: center;">{{$orderlines->olprice}}</td>

                                                    <td style="text-align: center;"><input type="checkbox" class="select-all" id="{{$orderlines->product_id}}" price="{{$orderlines->olprice}}"   quantity="{{$orderlines->olquantity}}"  name="product_ids[]" value="{{$orderlines->product_id}}"/></td>

                                                </tr>
                                            @endif
                                        @endforeach


                                        </tbody>
                                    </table>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">Refund Invoice</button>
                                        </div>
                                    </form>



                                </div>
                                <div class="row">
                                   <div class="col-md-12">
                                       <br>
                                       <br>
                                       <br>
                                       <br>
                                       <br>
                                   </div>
                                </div>
                            </div>

                        @endforeach


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


    </section>
    @push('scripts')
        <script>

            var url_string = (window.location).href;
            var url = new URL(url_string);
            var message = url.searchParams.get("message");
            var cartProducts = [];
            $(document).ready(function () {
                if(message && message !=''){
                    $("#infoMessage").show('slow');
                    $("#infoMessage").html(message);
                    setTimeout(function() {
                        $("#infoMessage").hide('slow');
                    }, 5000);
                }
            });



                $('#select-all').click(function() {
                var checked = this.checked;
                $('.select-all').each(function() {
                    this.checked = checked;
                });
            });

            $('.select-all').click(function() {
                var checked = this.checked;
               if(checked == true){
                   let price=$("#"+this.id).attr("price");
                   let quantity=$("#"+this.id).attr("quantity");
                   let multy=parseFloat(price) * parseInt(quantity);

                   let fnum=parseFloat(multy);
                   let fnumold=$("#total_order").val();
                   let diff=(fnumold-fnum);
                   $("#total_order").val(diff);
               }
            });

        </script>
    @endpush
@endsection

