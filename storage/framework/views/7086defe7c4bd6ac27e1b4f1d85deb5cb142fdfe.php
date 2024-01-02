<style>
    * {
        font-size: 10px;
    }

</style>

<style media="print">

    @page  {
        size: auto;
        margin: 0;
        margin-top: 20px;
    }

    @media  print {
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

    <title><?php echo e(config('app.name')); ?></title>
</head>
<body>

<style>

    @media  all {
        .page-break {
            /*display: none;*/
        }
    }
</style>


<style>
    @media  print {
        .page-break {
            display: block;
            page-break-after: always;
        }
    }
    table .head span {
    font-weight:bolder ;
    }
      table .foot span {
    unicode-bidi: plaintext;
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
                    <span>شكاوى العملاء</span>
                    <br>


                </td>
                <td  class="col foot">

                    <span><?php echo e($orderHeader->id); ?></span>
                    <br>

                    <span><?php echo e($user->name); ?></span>
                    <br>
                    <span><?php echo e($user->mobile); ?></span>
                    <br>
			                 <?php
                        $creatat = $orderHeader->created_at;
                        $creatdate = substr($creatat, 0, 10);
                        $creattime = substr($creatat, 10)
                        ?>
                    <span>
                        <?php echo e($creatdate); ?>

                    </span>
                    <br>

                    <span><?php echo e($creattime); ?></span>
                    <br>
                    <span>01225865555</span>
                    <br>
                   


                </td>

            </tr>
            </tbody>
        </table>


        <table style="border-color:black;" class="table table-bordered">
            <thead>
            <tr>
                <th style="text-align: center;" scope="col">اسم الصنف</th>
                <th style="text-align: center;" scope="col">الكمية</th>
                <th style="text-align: center;" scope="col">السعر</th>

            </tr>
            </thead>
            <tbody>

            <?php
            $i = 1;
            ?>

            <?php $__currentLoopData = $invoicesLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderlines): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>
                <td style="text-align: center;"><?php echo e($orderlines->psku); ?></td>
                <td style="text-align: center;"><?php echo e($orderlines->olquantity); ?></td>
                <td style="text-align: center;"><?php echo e($orderlines->olprice); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    
        <table style="border-color:black;" class="table table-bordered">
            <tbody>
            <tr>
                <th style="text-align: center;">عدد الاصناف</th>
                <td style="text-align: center;"><?php echo e(count($invoicesLines)); ?> </td>
            </tr>
             <tr>
                <th style="text-align: center;">القيمة قبل الضريبة</th>
                <td style="text-align: center;"><?php echo e($orderHeader->total_order-$taxVal); ?></td>
            </tr>
            <tr>
                <th style="text-align: center;">قيمة الضريبة</th>
                <td style="text-align: center;"><?php echo e($taxVal); ?></td>
            </tr>
             <tr>
                <th style="text-align: center;">القيمة بعد الضريبة</th>
                <td style="text-align: center;"><?php echo e($orderHeader->total_order); ?></td>
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
<?php /**PATH C:\Users\bishoy.sobhy\Desktop\laravel\mall\mallofarabia\resources\views/AdminPanel/PagesContent/OrderHeaders/print80c.blade.php ENDPATH**/ ?>