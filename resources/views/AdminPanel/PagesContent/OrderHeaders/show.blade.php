<style>
    * {
        font-size: 12px;
        font-weight: bold;
    }

</style>

<style media="print">

    @page {
        size: auto;
        margin: 0;
        margin-top: 20px;
    }

    @media print {
        a[href]:after {
            content: none !important;
        }
    }
</style>
<style>
    .new-table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        margin: auto;
        width: 50%;
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
    .solid {
        border: 2px solid #000 ;
    }
</style>


<script>
    document.title = "";
    window.print();

    document.link = "";
    window.print();

</script>

<!doctype html>
<html lang="en" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>{{ config('app.name') }}</title>
</head>
<body>

<style>

    @media all {
        .page-break {
            display: none;
        }
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
            <table class="table table-borderless">
                <tbody>
                <tr>
                    <td  class="col head">
                        <span>مسلـسـل بـيــع </span>
                        <br>

                        <span>اســــم العمـيــل </span>
                        <br>
                        <span>تليــفــون رقم</span>
                        <br>
                        <span>تاريخ الايصال</span>

                        <br>
                        <span>توقيت الايصال</span>
                        <br>
                      


                    </td>
                    <td  class="col foot">

                        <span>{{$orderHeader->id}}</span>
                        <br>

                        <span>{{$user->name}}</span>
                        <br>
                        <span>{{$user->mobile}}</span>
                        <br>
                        <?php
                        $creatat = $orderHeader->created_at;
                        $creatdate = substr($creatat, 0, 10);
                        $creattime = substr($creatat, 10)
                        ?>
                        <span>
                        {{$creatdate}}
                    </span>
                        <br>

                        <span>{{$creattime}}</span>
                        <br>
                       



                    </td>

                </tr>

                </tbody>
            </table>


            <table style="border-color:black;" class="table table-bordered new-table solid">
                <thead>
                <tr>
                    <th style="text-align: center;" scope="col">اسم الصنف</th>
                    <th style="text-align: center;" scope="col">الكمية</th>
                    <th style="text-align: center;" scope="col">سعر الصنف</th>
                    <th style="text-align: center;" scope="col">الاجمالي</th>

                </tr>
                </thead>
                <tbody>

                <?php
                $i = 1;
                ?>

                @foreach($invoicesLines as $orderlines)
                    @if($invoiceNumber->oracle_num == $orderlines->oracle_num)

                        <tr class="solid">
                            <td style="text-align: center; border: 2px solid #000" class="solid">{{$orderlines->psku}}</td>
                            <td style="text-align: center; border: 2px solid #000" class="solid">{{$orderlines->olquantity}}</td>
                            <td style="text-align: center; border: 2px solid #000" class="solid">{{$orderlines->newprice}}</td>
                            <td style="text-align: center; border: 2px solid #000" class="solid">{{$orderlines->olprice}}</td>
                        </tr>


                    @endif
                @endforeach


                </tbody>
            </table>


            <div class="col-md-3">
                <table style="border-color:black;" class="table table-bordered new-table solid">

                    <?php
                    $or14 = $orderHeader->total_order * 14 % 100;
                    ?>
                    <tbody>
                    <tr>
                        <th style="text-align: center;">طريقة الدفع</th>
                        <td style="text-align: center;">{{$orderHeader->wallet_status }}</td>
                    </tr>

                    <tr>
                        <th style="text-align: center;">عدد الاصناف</th>
                        <td style="text-align: center;">{{count($invoicesLines)}} </td>
                    </tr>
                    <tr>
                        <th style="text-align: center;">عدد القطع</th>
                        <td style="text-align: center;">{{$generalQuantity}} </td>
                    </tr>
                    <tr>
                        <th style="text-align: center;">القيمة قبل الضريبة</th>
                        <td style="text-align: center;">{{$orderHeader->total_order-$taxVal}}</td>
                    </tr>
                    <tr>
                        <th style="text-align: center;">قيمة الضريبة</th>
                        <td style="text-align: center;">{{$taxVal}}</td>
                    </tr>

                    <tr>
                        <th style="text-align: center;">القيمة بعد الضريبة</th>
                        <td style="text-align: center;">{{$orderHeader->total_order }}</td>
                    </tr>



                    </tbody>
                </table>


                <p style="font-weight:bolder;text-align:center;    line-height: 0.5;">( تطبق الشروط والاحكام )</p>

                <p style=" font-weight:bolder; text-align:center;line-height: 0.5;">
                    شكراً لثقتكم فى التعامل معنا
                </p>
                <p style="text-align:center;    line-height: 0.5;">

                    مستحضرات التجميل لا ترد ولا تستبدل
                </p>

                <p style="text-align:center;    line-height: 0.5;">

                    اتعهد انا المشترى بسداد ثمن البضاعة

                </p>
                <p style="text-align:center;    line-height: 0.5;">

                    الموضحة والتى استلمتها بحالة سليمة

                </p>
                <p style="text-align:center;    line-height: 0.5;">

                    وجيدة بعد معاينتها وقبولها

                </p>
            </div>
        </div>
    </div>

@endforeach

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>
</html>
