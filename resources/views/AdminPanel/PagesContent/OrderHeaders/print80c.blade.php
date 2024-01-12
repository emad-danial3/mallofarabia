<style>
    * {
        font-size: 10px;
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

<script>
    document.title = "";
    document.link = "";
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
    *{
           font-size: 12px;
        font-family: 'Times New Roman';
    }
    body {
    margin: 0; /* Reset default body margin */
    padding: 0; /* Reset default body padding */
}

    td,
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}
td.name,
th.name {
    width: 85px;
    max-width: 85px;
}
td.quantity,
th.quantity {
    width: 20px;
    max-width: 20px;
    word-break: break-all;
}
td.price,
th.price {
    width: 20px;
    max-width: 20px;
    word-break: break-all;
}
td.total,
th.total {
    width: 20px;
    max-width: 20px;
    word-break: break-all;
}
@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
    body {
        size: auto; 
        margin: 0; /* Reset margin for printing */
    }

    @page {
        size: 80mm auto; /* Set page size to 80mm width, auto height */
        margin: 0; /* Reset margin for printing */
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


        <table  >
            <thead>
            <tr>
                <th class="name" >Name</th>
                <th class="quantity" >Qty</th>
                <th class="price" > Price</th>
                <th  class="total" >Total</th>

            </tr>
            </thead>
            <tbody>

            <?php
            $i = 1;
            ?>

            @foreach($invoicesLines as $orderlines)
                <tr>
                <td class="name">{{$orderlines->psku}}</td>
                <td class="quantity">{{$orderlines->olquantity}}</td>
                <td class="price" >{{$orderlines->newprice}}</td>
                <td class="total">{{$orderlines->olprice}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>


        <table style="border-color:black;" >
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

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
