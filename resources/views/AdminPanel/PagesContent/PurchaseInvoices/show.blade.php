<style>
    *{
        font-size:10px;
    }

</style>

<style media="print">

    @page
    {
        size:  auto;
        margin: 0;
        margin-top:20px;
    }

    @media print {
        a[href]:after {
            content: none !important;
        }
    }
</style>

<script>
    document.title = ""; window.print();

    document.link = ""; window.print();

</script>

<!doctype html>
<html lang="en" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Netting Hub</title>
</head>
<body>

<style>

    @media all {
        .page-break { display: none; }
    }


</style>

@foreach($invoicesNumber as $invoiceNumber)


    <style>



        @media print {
            .page-break { display: block;
                page-break-after: always;
            }
        }

    </style>
    <div class="container page-break">
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




            <table style="border-color:black;" class="table table-bordered">
                <thead>
                <tr>
                    <th style="text-align: center;" scope="col">اسم الصنف</th>
                    <th style="text-align: center;" scope="col">الكمية</th>
{{--                    <th style="text-align: center;" scope="col">السعر</th>--}}
                    <th style="text-align: center;"  scope="col">م</th>

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
{{--                            <td style="text-align: center;">{{$orderlines->olprice}}</td>--}}


                            <td style="text-align: center;">{{$i++}}</td>

                        </tr>
                    @endif
                @endforeach


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

@endforeach



<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
-->
</body>
</html>
