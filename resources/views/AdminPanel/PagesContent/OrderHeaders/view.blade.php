@extends('AdminPanel.layouts.main')
@section('content')


<style>
    .new-table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        margin: auto;
        width: 60%;
        padding: 10px;
    }

    .new-table td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    .new-table tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

@foreach($invoicesNumber as $invoiceNumber)


    <style>

        @media print {
            .page-break {
                display: block;
                page-break-after: always;
            }
        }

    </style>
    <div class="container page-break">
        <div class="row">


            <table class="table table-borderless" style="direction: rtl">

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
                            $creatat = $orderHeader->created_at;
                            $creatdate = substr($creatat, 0, 10);
                            $creattime = substr($creatat, 10)
                            ?>
                            {{$creatdate}}
</span>
                        <br>
                        <span>{{$user->name}}</span>
                        <br>

                        <span>{{$creatdate}}</span>
                        <br>

                        <span>{{$creattime}}</span>

                    </td>
                    <td style="width: 30%;" class="col">

                    </td>

                    <td style="width: 15%;" ;="" class="col">

                     
                        <span style="font-weight:bolder;margin-left:20px;">تليــفــون رقم  </span>
                        <br>
                        <span style="font-weight:bolder;margin-left:20px;">شكاوى العملاء  </span>
            


                    </td>
                    <td style="width: 20%;" ;="" class="col">

                        <span style="unicode-bidi: plaintext;">{{$user->mobile}}</span>
                        <br>
                        <span style="unicode-bidi: plaintext;">0122 5865555</span>
                        <br>
                      

                    </td>

                </tr>


                </tbody>
            </table>

<p class="col-md-12 text-right text-danger"> هذة النسخة ليست للعميل </p>
            <table style="border-color:black;direction: rtl" class="table table-bordered new-table col-md-12" >
                <thead>
                <tr>
                    <th style="text-align: center;" scope="col">اسم الصنف</th>
                    <th style="text-align: center;" scope="col">الكمية</th>
                    <th style="text-align: center;" scope="col">السعر</th>
                    <th style="text-align: center;" scope="col">م</th>

                </tr>
                </thead>
                <tbody>

                <?php
                $i = 1;
                ?>

<p class="col-md-12 text-right"> رقم الطلب :  {{$invoiceNumber->oracle_invoice_number}}</p>
                @foreach($invoicesLines as $orderlines)
                    @if($invoiceNumber->oracle_num == $orderlines->oracle_num)
                        <tr>
                            {{--                            {{$orderlines->oracle_num}}--}}
                            <td style="text-align: center;">{{$orderlines->psku}}</td>
                            <td style="text-align: center;">{{$orderlines->olquantity}}</td>
                            <td style="text-align: center;">{{$orderlines->olprice}}</td>


                            <td style="text-align: center;">{{$i++}}</td>

                        </tr>
                    @endif
                @endforeach


                </tbody>
            </table>


            <div class="col-md-12">
                <br>
                <table style="border-color:black;direction: rtl" class="table table-bordered new-table">

                    <?php
                    $or14 = $orderHeader->total_order * 14 % 100;
                    ?>
                    <tbody>


                    <tr>
                        <th style="text-align: center;">صافى القيمة</th>
                        <td style="text-align: center;">{{$orderHeader->total_order}}</td>


                    </tr>

                    <tr>
                        <th style="text-align: center;">عدد الاصناف</th>
                        <td style="text-align: center;">{{count($invoicesLines)}} </td>


                    </tr>

                    <tr>
                        <th style="text-align: center;">اجمالى الكمية</th>
                        <td style="text-align: center;">{{$orderHeader->total_order + $orderHeader->shipping_account}} </td>


                    </tr>


                    </tbody>
                </table>

            </div>

<div class="col-md-12" style="text-align: center;align-items: center">
    <br>
    <br>
            <p style="font-weight:bolder;text-align:center;    line-height: 0.5;">( تطبق الشروط والاحكام )</p>

            <p style="text-align:center;line-height: 0.5;">
                شكراً لثقتكم فى التعامل معنا
            </p>
            <p style="text-align:center;    line-height: 0.5;">

                مستحضرات التجميل لا ترد ولا تستبدل
            </p>

            <p style="text-align:center;    line-height: 0.5;">

                اتعهد انا المشترى بسداد ثمن البضاعة الموضحة والتى استلمتها بحالة سليمة وجيدة بعد معاينتها وقبولها

            </p>

</div>
        </div>
    </div>

@endforeach
@endsection
