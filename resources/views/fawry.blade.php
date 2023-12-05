<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="https://www.atfawry.com/atfawry/plugin/assets/payments/css/fawrypay-payments.css">
  {{--  <link rel="stylesheet" href="https://atfawry.fawrystaging.com/atfawry/plugin/assets/payments/css/fawrypay-payments.css"> --}}


     <script type="text/javascript" src="https://unpkg.com/@zxing/library@0.8.0"></script>
    <title>
        Fawry Payment
    </title>
</head>
<body onload="checkout()">
{{--<script src="https://atfawry.fawrystaging.com/atfawry/plugin/assets/payments/js/fawrypay-payments.js"></script>--}}
<script src="https://www.atfawry.com/atfawry/plugin/assets/payments/js/fawrypay-payments.js"></script>
<div id="fawry-UAT"></div>
<script>
    function checkout() {
        const configuration = {
            locale: "en", //default en, allowed [ar, en]
            divSelector: 'fawry-UAT', //required and you can change it as desired
            mode: DISPLAY_MODE.SEPARATED, //required, allowd values [POPUP, INSIDE_PAGE, SIDE_PAGE, SEPARATED]
            onSuccess: successCallBack, //optional and not supported with separated display mode
            onFailure: failureCallBack, //optional and not supported with separated display mode
        };
        FawryPay.checkout(buildChargeRequest(), configuration);
    }
    function buildChargeRequest() {
        const chargeRequest = {
            merchantCode: '<?php echo $merchantCode; ?>', // the merchant account number in Fawry
            <?php
                date_default_timezone_set("Africa/Cairo");
                $m = strtotime('+24 Hours');
                $s = '000';
                $mm = $m . $s
                ?>
            merchantRefNum: '<?php echo $merchantRefNum; ?>', // order refrence number from merchant side
            customerMobile: '<?php  echo $user->phone; ?>',
            customerEmail: '<?php  echo $user->email; ?>',
            customerName: '<?php  echo $user->full_name;?>',
            paymentExpiry: '<?php echo $mm;?>',
            customerProfileId: '<?php echo $user->account_id;?>', // in case merchant has customer profiling then can send profile id to attach it with order as reference

            chargeItems: [
                    <?php
                    foreach($order as $orders){
                    ?>
                {
                    itemId: '<?php echo $orders->olitemcode;?>',
                    description: '<?php echo $orders->psku;?>',
                    price: <?php echo $orders->olprice;?>,
                    quantity:<?php echo $orders->olquantity;?> ,
                    imageUrl: '<?php echo $orders->pimage;?>'
                },
                <?php
                }
                ?>
            ],
            selectedShippingAddress: {
                governorate: '', //Governorate code at Fawry
                city: '<?php echo $address->city_name;?>', //City code at Fawry
                area: '<?php echo $address->area_name;?>', //Area code at Fawry
                address: '<?php  echo $address->address;?>',
                receiverName: '<?php echo $user->full_name;?>'
            },
            paymentMethod: 'CARD',
            returnUrl: '<?php echo $returnUrl;?>',
            amount: '<?php echo $amount; ?>',
            signature: '<?php echo $signature; ?>'
        };

        return chargeRequest;
    }
    function successCallBack(data) {
        console.log('handle success call back as desired, data', data);
        document.getElementById('fawryPayPaymentFrame')?.remove();
    }

    function failureCallBack(data) {
        console.log('handle failure call back as desired, data', data);
        document.getElementById('fawryPayPaymentFrame')?.remove();
    }
</script>
</body>
</html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
