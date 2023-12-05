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
                        <li class="breadcrumb-item active"><a href="{{route('oracleInvoices.index')}}">Invoices</a></li>
                    </ol>
                </div>
                <div class="col-sm-12">
                    <div class="row mb-1 mt-2">
                        <div class="col-sm-5 row" style="border: 2px solid #f00;border-radius: 10px; padding: 5px">
                            <h3 class="col-md-12 text-red">Please Refresh Data On Click 2 Buttons</h3>
                            <div class="col-sm-5">
                                1
                                <a class="btn btn-outline-primary" href="{{route('updateOracleInvoices')}}">Update
                                    Oracle
                                    Invoices</a>
                            </div>
                            <div class="col-sm-5">
                               2 <a class="btn btn-outline-success" href="{{route('refreshOracleInvoices')}}">Refresh
                                    Invoices</a>
                            </div>
                        </div>
                        <div class="col-sm-1 row">
                        </div>
                        <div class="col-sm-6 row">
                            <h5 class="col-md-12">Total Invoices Count : {{$oracleInvoices->total()}}</h5>
                            <h5 class="col-md-12">Orders Not Sent Oracle : <a class="btn btn-primary" href="{{route('orderHeaders.index', ['send_t_o' => '0'])}}" target="_blank">{{$ordersCountNotSentToOracle}}</a></h5>
                            <h5 class="col-md-12">Orders Sent Oracle no return :  <a class="btn btn-primary" href="{{route('orderHeaders.index', ['send_t_o_not_return' => '1'])}}" target="_blank">{{$ordersCountSentToOracleNotReturn}}</a></h5>
                        </div>


                    </div>

                    <form method="post" action="{{route('oracleInvoices.ExportOracleInvoicesSheet')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-3">
                                <label class="col-form-label" for="start_date">Start Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="form-group col-3">
                                <label class="col-form-label " for="end_date">End Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>


                            <div class="form-group col-3">

                                <label class="col-form-label"> <i class="fa fa-file"></i> </label>
                                <button type="submit" class="btn btn-success form-control">Exports Orders Sheet</button>
                            </div>
                        </div>
                    </form>

                    <br>
                    <form method="get" action="{{route('oracleInvoices.index')}}">

                        <div class="row">
                            <div class="row col-3">
                            <div class="form-group col-6 mb-0">
                                <label class="mt-2">Payment Way</label>
                                <select name="wallet_status" class="form-control">
                                    <option value="">Select Way</option>
                                    <option value="cash" @if(app('request')->input('wallet_status') == 'cash')selected @endif>
                                        Cash
                                    </option>
                                    <option value="only_fawry" @if(app('request')->input('wallet_status') == 'only_fawry')selected @endif>
                                        Fawry
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-6 mb-0">
                                <label class="mt-2">Valid Status</label>
                                <select name="check_valid" class="form-control">
                                    <option value="">Chose Status</option>
                                    <option value="valid" @if(app('request')->input('check_valid') == 'valid')selected @endif >Valid</option>
                                    <option value="notvalid" @if(app('request')->input('check_valid') == 'notvalid')selected @endif >Not Valid</option>
                                </select>
                            </div>
                           </div>
                            <div class="row col-3">
                            <div class="form-group col-6">
                                <label class="col-form-label" for="name">Order ID 4U</label>
                                <input type="text" name="Order_ID" class="form-control" id="Order_ID" placeholder=" Invoice Number">
                            </div>


                            <div class="form-group col-6">
                                <label class="col-form-label" for="phone">Invoice Number 4U</label>
                                <input type="text" name="web_order_number" class="form-control" id="web_order_number" placeholder="Invoice Number 4U">
                            </div>
                            </div>
                            <div class="form-group col-2">
                                <label class="col-form-label" for="user_name">Invoice Oracle Number </label>
                                <input type="text" name="oracle_invoice_number" class="form-control" id="oracle_invoice_number" placeholder="Invoice Oracle Number">
                            </div>

                            <div class="row col-3">
                                <div class="form-group col-6">
                                    <label class="col-form-label" for="start_date">From Date</label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label class="col-form-label " for="end_date">To Date</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                            </div>

                            <div class="form-group col-1">
                                <label class="col-form-label"><i class="fa fa-search"></i></label>
                                <button type="submit" class="btn btn-info form-control">Search</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('AdminPanel.layouts.messages')

    <div class="card">

        <!-- /.card-header -->
        <div class="card-body" style="overflow-x:scroll">
            @if(count($oracleInvoices) > 0)
                <table id="orderHeadersTable" style="width: 100%" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Order ID 4U</th>
                        <th>Invoice Number 4U</th>
                        <th>Invoice Oracle Number</th>
                        <th>Payment Type</th>
                        <th>Payment Code</th>
                        <th>Total Order 4U</th>
                        <th>Total Oracle Amount</th>
                        <th>Total Oracle Actual Amount</th>
                        <th>General Total IN Oracle</th>
                        <th>Total Order Out Oracle</th>
                        <th>4U-Oracle(In+Out)</th>
                        <th>Validation</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($oracleInvoices as $row)
                        <tr>
                            <td>{{$row->Order_ID}}</td>
                            <td>{{$row->web_order_number}}</td>
                            <td>{{$row->oracle_invoice_number}}</td>
                            <td>{{$row->wallet_status == 'only_fawry' ? "Fawry":"Cash" }}</td>
                            <td>{{$row->payment_code > 0 ?$row->payment_code:'Cash'}}</td>
                            <td>{{$row->total_order}}</td>
                            <td>{{$row->order_amount}}</td>
                            <td>
                                {{$row->actual_amount}}
                                @if($row->actual_amount == 0)
                                <p class="text-danger">Invoice Canceled</p>
                                @endif
                            </td>
                            <td>{{$row->total_order_in_oracle}}</td>
                            <td>{{$row->total_order_out_oracle}}</td>
                            <td>{{number_format($row->total_4u_min_oracle, 2, '.', '')}}</td>
                            @if(($row->total_order-($row->total_order_in_oracle + $row->total_order_out_oracle)) >= -1 &&  ($row->total_order-($row->total_order_in_oracle+ $row->total_order_out_oracle)) <= 2 )
                                <td class="text-white" style="background-color:green "> Valid</td>
                            @else
                                <td class="text-white" style="background-color:red ">Not Valid</td>
                            @endif
                            <td>{{date('d-m-Y h:m a', strtotime($row->created_at))}}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                <div class="pagination justify-content-center mt-2">

                    @if (isset($oracleInvoices) && $oracleInvoices->lastPage() > 1)
                        <ul class="pagination align-items-center">
                        @php
                            $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                            $from = $oracleInvoices->currentPage() - $interval;
                            if($from < 1){
                              $from = 1;
                            }

                            $to = $oracleInvoices->currentPage() + $interval;
                            if($to > $oracleInvoices->lastPage()){
                              $to = $oracleInvoices->lastPage();
                            }
                        @endphp
                        <!-- first/previous -->
                            @if($oracleInvoices->currentPage() > 1)
                                <li class="page-item">
                                    <a href="{{ $oracleInvoices->url(1)."&type=".app('request')->input('type')}}" aria-label="First" class="page-link">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a href="{{ $oracleInvoices->url($oracleInvoices->currentPage() - 1)."&type=".app('request')->input('type') }}" aria-label="Previous" class="page-link">
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </a>
                                </li>
                            @endif
                        <!-- links -->
                            @for($i = $from; $i <= $to; $i++)
                                @php
                                    $isCurrentPage = $oracleInvoices->currentPage() == $i;
                                @endphp
                                <li class="page-item {{ $isCurrentPage ? 'active' : '' }}" style="padding: 5px">
                                    <a class="page-link" href="{{ !$isCurrentPage ? $oracleInvoices->url($i)."&type=".app('request')->input('type') : '' }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor
                        <!-- next/last -->
                            @if($oracleInvoices->currentPage() < $oracleInvoices->lastPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $oracleInvoices->url($oracleInvoices->currentPage() + 1)."&type=".app('request')->input('type') }}" aria-label="Next">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $oracleInvoices->url($oracleInvoices->lastpage())."&type=".app('request')->input('type') }}" aria-label="Last">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>

            @else
                <h1 class="text-center">NO DATA</h1>
            @endif
        </div>
        <!-- /.card-body -->
    </div>

    <button onclick="window.scrollTo({ left: 0, top: document.body.scrollHeight, behavior: 'smooth' })" id="myBtn" title="Go to bottom">
        <i class="fa-sharp fa-solid fa-chevron-down"></i></button>
    <button onclick="window.scrollTo({ left: 0, top: 0, behavior: 'smooth' })" id="myBtn2" title="Go to bottom">
        <i class="fa-sharp fa-solid fa-chevron-up"></i></button>



    <!-- Modal for CreateWaybill -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('orderHeaders.ExportOrderCharge')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="category">City</label>
                                <select id="category" name="user_city" required class="form-control">
                                    <option value="">select City</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="subcategory">Area</label>
                                <select id="subcategory" name="user_area" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <input type="hidden" name="order_id" id="order_id" class="form-control">
                            <input type="hidden" name="user_name" id="user_name_charge" class="form-control">
                            <input type="hidden" name="user_phone" id="user_phone" class="form-control">
                            {{--                            <input type="hidden" name="user_city" class="form-control" >--}}
                            <input type="hidden" name="user_address" id="user_address" class="form-control">
                            {{--                            <input type="hidden" name="user_area" class="form-control" >--}}
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success form-control" onclick="$('#exampleModalCenter').modal('hide');">
                                    شحن
                                </button>
                            </div>
                        </div>
                    </form>


                </div>

            </div>
        </div>
    </div>



    <!-- Modal CreatePickupRequest -->
    <div class="modal fade" id="exampleModalCreatePickupRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCreatePickupRequestTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order Pickup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('orderHeaders.CreatePickupRequest')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="categoryPickup">City</label>
                                <select id="categoryPickup" name="user_city" required class="form-control">
                                    <option value="">select City</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="subcategoryPickup">Area</label>
                                <select id="subcategoryPickup" name="user_area" class="form-control">
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="user_area">Pickup Date</label>
                                <input class="form-control" type="date" id="pickupDate" name="pickupDate" placeholder="pickup Date" required>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" name="order_id" id="order_id_pickup" class="form-control">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success form-control" onclick="$('#exampleModalCreatePickupRequest').modal('hide');">
                                    تحميل
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Cancel Request -->
    <div class="modal fade" id="exampleModalCancelRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCancelRequestTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order Cancel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('orderHeaders.cancelOrderCharge')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <h5 class="modal-title" id="exampleModalLongTitle">Do You want to Cancel Order</h5>
                            <br>
                            <br>
                            <input type="hidden" name="order_id" id="order_id_cancel" class="form-control">
                            <input type="hidden" name="waybillNumber" id="waybillNumber_cancel" class="form-control">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success form-control" onclick="$('#exampleModalCancelRequest').modal('hide');">
                                    Yes cancel
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Cancel Order Request -->
    <div class="modal fade" id="exampleModalCancelOrderRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCancelOrderRequestTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order Cancel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('orderHeaders.cancelOrderQuantity')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <h5 class="modal-title" id="exampleModalLongTitle">Do You want to Cancel Order And Return
                                Quantity</h5>
                            <br>
                            <br>
                            <input type="hidden" name="order_id" id="order_id_cancel_order" class="form-control">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success form-control" onclick="$('#exampleModalCancelOrderRequest').modal('hide');">
                                    Yes cancel
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            var base_url = window.location.origin;

            function urlParamfun(name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results == null) {
                    return null;
                }
                else {
                    return results[1] || 0;
                }
            }

            $("#orderType").change(function () {

                $('.loader').show();
                $('#orderHeadersTable').hide();
                var newtype = $(this).val();

                let path = base_url + "/admin/orderHeaders/getAllOrdersWithType";
                console.log("path", path);

                var dataObj = {
                    "type": newtype
                }

                $.ajax({
                    url: path,
                    type: 'POST',
                    cache: false,
                    data: JSON.stringify(dataObj),
                    contentType: "application/json; charset=utf-8",
                    traditional: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response.data) {
                            console.log(response);
                            if (response.status && response.status == 200) {
                                if (newtype == '') {
                                    window.location.href = "{{route('orderHeaders.index')}}"
                                }
                                window.location.href = "{{route('orderHeaders.index')}}?type=" + newtype;
                            }
                            else {
                                console.log("error  error");
                                console.log(response);
                            }
                            window.scrollTo({left: 0, top: document.body.scrollHeight, behavior: 'smooth'})
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error');
                    }
                });

            });

            $('#select-all').click(function () {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function () {
                    this.checked = checked;
                });
            })

            $(document).ready(function () {
                var type = urlParamfun('type');
                console.log(type);
                $("#payment_status").val(type);

                var allareasR2S = {
                    "ALSHARQIA": [
                        "10th of Ramdan City",
                        "Abu Hammad",
                        "Abu Kbeer",
                        "Al Hasiniya",
                        "Al Ibrahimiya",
                        "Al Salhiya Al Gedida",
                        "Al Sharqia",
                        "Awlad Saqr",
                        "Belbes",
                        "Darb Negm",
                        "Faqous",
                        "Hehya",
                        "Kafr Saqr",
                        "Mashtool Al Sooq",
                        "Meniya Alqamh",
                        "Zakazik"
                    ],
                    "ALEXANDRIA": [
                        "Abees",
                        "Abu Keer",
                        "Al Amriah",
                        "Al Bitash",
                        "Al Nahda Al Amria",
                        "Al Soyof",
                        "Alexandria",
                        "Asafra",
                        "Awaied-Ras Souda",
                        "Azarita",
                        "Bangar EL Sokar",
                        "Borg El Arab",
                        "City Center",
                        "El Borg El Kadem",
                        "El-Agamy",
                        "Glem",
                        "Kafer Abdou",
                        "Khorshid",
                        "Luran",
                        "Maamora",
                        "Mahtet El-Raml",
                        "Mandara",
                        "Manshia",
                        "Miami",
                        "Muntazah",
                        "Roshdy",
                        "San Stefano",
                        "Sedi Bisher",
                        "Sedi Gaber",
                        "Sedi Kreir",
                        "Smouha",
                        "Sporting",
                        "Stanly",
                        "Zezenya"
                    ],
                    "CAIRO": [
                        "Ain Shams",
                        "Al Azhar",
                        "Al Daher",
                        "Al Kalaa",
                        "Al Kasr Al Einy",
                        "Al Matareya",
                        "Al Moski",
                        "Al Rehab",
                        "Al Salam City",
                        "Al Zeitoun",
                        "Almaza",
                        "Amiria",
                        "Badr City",
                        "Cairo",
                        "Cornish Al Nile",
                        "Dar Al Salam",
                        "Down Town",
                        "El Herafieen",
                        "EL Marg",
                        "El Shorouk",
                        "El Tahrir",
                        "Ezbet El Nakhl",
                        "Fustat",
                        "Garden City",
                        "Gesr Al Suez",
                        "Ghamrah",
                        "Hadayek Al Qobah",
                        "Hadayek Al Zaiton",
                        "Hadayek Helwan",
                        "Hadayek Maadi",
                        "Heliopolis",
                        "Helmeya",
                        "Helmiet Elzaitoun",
                        "Helwan",
                        "Katamiah",
                        "Maadi",
                        "Maadi Degla",
                        "Madinty",
                        "Manial Al Rodah",
                        "Masaken Sheraton",
                        "Mirage City",
                        "Misr El Kadima",
                        "Mokattam",
                        "Nasr City",
                        "New Cairo",
                        "New El Marg",
                        "New Maadi",
                        "New Nozha",
                        "Ramsis",
                        "Rod El Farag",
                        "Sayeda Zeinab",
                        "Shubra",
                        "Zamalek"
                    ],
                    "GIZA": [
                        "6th of October",
                        "Agouza",
                        "Al Kom Al Ahmer",
                        "Al Moatamadia",
                        "Al Monib",
                        "Al Nobariah",
                        "Bolak Al Dakrour",
                        "Dokki",
                        "Faisal",
                        "Giza",
                        "Hadayeq El Ahram",
                        "Haram",
                        "Imbaba",
                        "Kit Kat",
                        "Manial",
                        "Mohandessin",
                        "Omraneya",
                        "Qism el Giza",
                        "Sakiat Mekki",
                        "Sheikh Zayed",
                        "Smart Village",
                        "Tirsa",
                        "Warraq"
                    ],
                    "ASYUT": [
                        "Abnoub",
                        "Abou Teag",
                        "Assuit Elgdeda",
                        "Asyut",
                        "Dayrout",
                        "El Badari",
                        "El Ghnayem",
                        "El Qusya",
                        "Elfath",
                        "Manflout",
                        "Sahel Selim",
                        "Serfa"
                    ],
                    "ALMENIYA": [
                        "Abo Korkas",
                        "Al Meniya",
                        "Bani Mazar",
                        "Dermwas",
                        "Eladwa",
                        "Malawi",
                        "Matai",
                        "Mghagha",
                        "Minya",
                        "Samaloot"
                    ],
                    "ISMAILIA": [
                        "Abo Sultan",
                        "Abu Swer",
                        "El Tal El Kebir",
                        "Elsalhia Elgdida",
                        "Fayed",
                        "Ismailia",
                        "Nfeesha",
                        "Qantara Gharb",
                        "Qantara Sharq",
                        "Srabioom"
                    ],
                    "ALBEHEIRA": [
                        "Abou Al Matamer",
                        "Abu Hummus",
                        "Al Beheira",
                        "Al Delengat",
                        "Al Mahmoudiyah",
                        "Al Rahmaniyah",
                        "Damanhour",
                        "Edfina",
                        "Edko",
                        "El Nubariyah",
                        "Etay Al Barud",
                        "Hosh Issa",
                        "Kafr El Dawwar",
                        "Kom Hamadah",
                        "Rashid",
                        "Shubrakhit",
                        "Wadi Al Natroun"
                    ],
                    "ASWAN": [
                        "Abu Simbel",
                        "Al Sad Al Aali",
                        "Aswan",
                        "Draw",
                        "Edfo",
                        "El Klabsha",
                        "Kom Ombo",
                        "Markaz Naser",
                        "Nasr Elnoba"
                    ],
                    "QENA": [
                        "Abu Tesht",
                        "Deshna",
                        "Farshoot",
                        "Naga Hamadi",
                        "Naqada",
                        "Qena",
                        "Qoos"
                    ],
                    "QALYUBIA": [
                        "Abu Zaabal",
                        "Al Khanka",
                        "Al Shareaa Al Gadid",
                        "Bahteem",
                        "Banha",
                        "El Kanater EL Khayrya",
                        "El Khsos",
                        "El Oboor",
                        "El Qalag",
                        "Kafr Shokr",
                        "Meet Nama",
                        "Mostorod",
                        "Om Bayoumi",
                        "Orabi",
                        "Qaha",
                        "Qalyoob",
                        "Qalyubia",
                        "Sheben Alkanater",
                        "Shoubra Alkhema",
                        "Tookh"
                    ],
                    "ALDAQAHLIYA": [
                        "Aga",
                        "Al Daqahliya",
                        "Al Mansoura",
                        "Belqas",
                        "Dekernes",
                        "El Sinblaween",
                        "Manzala",
                        "Meet Ghamr",
                        "Menit El Nasr",
                        "Nabroo",
                        "Shrbeen",
                        "Talkha"
                    ],
                    "BANISOUAIF": [
                        "Ahnaseaa",
                        "Bani Souaif",
                        "Bebaa",
                        "El Fashn",
                        "El Korimat",
                        "El Wastaa",
                        "Naser",
                        "New Bani Souaif",
                        "Smostaa"
                    ],
                    "SUEZ": [
                        "Ain Al Sukhna",
                        "Al Adabya",
                        "Al Suez",
                        "Ataka District",
                        "El Arbeen District",
                        "Elganaien District",
                        "Suez"
                    ],
                    "SOHAG": [
                        "Akhmem",
                        "Dar Elsalam",
                        "El Monshah",
                        "Elbalyna",
                        "Gerga",
                        "Ghena",
                        "Maragha",
                        "Saqatlah",
                        "Sohag",
                        "Tahta",
                        "Tema"
                    ],
                    "ALFAYOUM": [
                        "Al Fayoum",
                        "Atsa",
                        "Ebshoy",
                        "El Aagamen",
                        "Kofooer Elniel",
                        "Manshaa Abdalla",
                        "Manshaa Elgamal",
                        "New Fayoum",
                        "Sanhoor",
                        "Sersenaa",
                        "Sonores",
                        "Tameaa",
                        "Youssef Sadek"
                    ],
                    "ALGHARBIA": [
                        "Al Gharbia",
                        "Al Mahala Al Kobra",
                        "Alsanta",
                        "Basyoon",
                        "Kafr Alziat",
                        "Qotoor",
                        "Samanood",
                        "Tanta",
                        "Zefta"
                    ],
                    "ALMONUFIA": [
                        "Al Monufia",
                        "Ashmoon",
                        "Berket Al Sabei",
                        "Menoof",
                        "Quesna",
                        "Sadat City",
                        "Shebin El Koom",
                        "Shohada",
                        "Tala"
                    ],
                    "KAFRELSHEIKH": [
                        "Al Riadh",
                        "Balteem",
                        "Bela",
                        "Borollos",
                        "Desouq",
                        "Fooh",
                        "Hamool",
                        "Kafr El Sheikh",
                        "Metobas",
                        "Qeleen",
                        "Seedy Salem"
                    ],
                    "DAMIETTA": [
                        "Al Zarkah",
                        "Damietta",
                        "Fareskor",
                        "Kafr Saad",
                        "New Damietta",
                        "Ras El Bar"
                    ],
                    "LUXOR": [
                        "Armant Gharb",
                        "Armant Sharq",
                        "El Karnak",
                        "El Korna",
                        "Esnaa",
                        "Luxor"
                    ],
                    "MATROOH": [
                        "El Alamein",
                        "El Dabaa",
                        "Marsa Matrooh",
                        "Matrooh",
                        "Sidi Abdel Rahman"
                    ],
                    "REDSEA": [
                        "Gouna",
                        "Hurghada",
                        "Marsa Alam",
                        "Qouseir",
                        "Ras Ghareb",
                        "Red Sea",
                        "Safaga"
                    ],
                    "PORTSAID": [
                        "Port Fouad",
                        "Port Said",
                        "Zohoor District"
                    ]
                };

                for (let x in allareasR2S) {
                    let option = '<option class="' + x + '" value="' + x + '" > ' + x + '</option>';
                    $('#category').append(option);
                    $('#categoryPickup').append(option);
                    let optgroup = '<optgroup class="' + x + '"required>' +
                        '<option value="">select Area</option>';
                    for (let i = 0; i < allareasR2S[x].length; i++) {
                        optgroup += '<option value="' + allareasR2S[x][i] + '"> ' + allareasR2S[x][i] + '</option>';
                    }
                    optgroup += '</optgroup>';
                    $('#subcategory').append(optgroup);
                    $('#subcategoryPickup').append(optgroup);

                }


                $('#subcategory').find('optgroup').hide(); // initialize
                $('#subcategoryPickup').find('optgroup').hide(); // initialize
                $('#category').change(function () {
                    var $cat    = $(this).find('option:selected');
                    var $subCat = $('#subcategory').find('.' + $cat.attr('class'));
                    $('#subcategory').find('optgroup').not("'" + '.' + $cat.attr('class') + "'").hide(); // hide other optgroup
                    $subCat.show();
                    $subCat.find('option').first().attr('selected', 'selected');
                });
                $('#categoryPickup').change(function () {
                    var $cat    = $(this).find('option:selected');
                    var $subCat = $('#subcategoryPickup').find('.' + $cat.attr('class'));
                    $('#subcategoryPickup').find('optgroup').not("'" + '.' + $cat.attr('class') + "'").hide(); // hide other optgroup
                    $subCat.show();
                    $subCat.find('option').first().attr('selected', 'selected');
                });
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
                    "font-size": "18px",
                    "width": "50px",
                    "height": "50px",
                    "border-radius": "50%",
                });
                $("#myBtn").hover(function () {
                    $(this).css("background-color", "#555");
                }, function () {
                    $(this).css("background-color", "#bbb");
                });

                $("#myBtn2").css({
                    "position": "fixed",
                    "bottom": "20px",
                    "right": "85px",
                    "z-index": "99",
                    "border": "none",
                    "outline": "none",
                    "background-color": "#bbb",
                    "color": "white",
                    "cursor": "pointer",
                    "padding": "7px",
                    "font-size": "18px",
                    "width": "50px",
                    "height": "50px",
                    "border-radius": "50%",
                });
                $("#myBtn2").hover(function () {
                    $(this).css("background-color", "#555");
                }, function () {
                    $(this).css("background-color", "#bbb");
                });
            });


            function goToSpecificCharge(order_id, user_name, user_phone, user_address) {
                $("#order_id").val(order_id);
                $("#user_name_charge").val(user_name);
                $("#user_phone").val(user_phone);
                $("#user_address").val(user_address);
            }

            function goToSpecificPickup(order_id) {
                $("#order_id_pickup").val(order_id);
            }

            function goToSpecificCancel(order_id, waybillNumber) {
                $("#order_id_cancel").val(order_id);
                $("#waybillNumber_cancel").val(waybillNumber);
            }

            function goToSpecificCancelOrder(order_id) {
                console.log(order_id)
                $("#order_id_cancel_order").val(order_id);
            }

        </script>
    @endpush
@endsection
