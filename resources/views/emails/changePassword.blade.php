
<html>
<head>
    <style>
    .social-menu ul{
        /*position: absolute;*/
        /*top: 50%;*/
        /*left: 50%;*/
        /*padding: 0;*/
        /*margin: 0;*/
        /*transform: translate(-50%, -50%);*/
        display: flex;
    }

    .social-menu ul li{
        list-style: none;
        margin: auto;
    }

    .social-menu ul li .fab{
        font-size: 30px;
        line-height: 60px;
        transition: .3s;
        color: #000;
    }

    .social-menu ul li .fab:hover{
        color: #fff;
    }

    .social-menu ul li a{
        position: relative;
        display: block;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #fff;
        text-align: center;
        transition: .6s;
        box-shadow: 0 5px 4px rgba(0,0,0,.5);
    }

    .social-menu ul li a:hover{
        transform: translate(0, -10%);
    }

    .social-menu ul li:nth-child(1) a:hover{
        background-color: rgba(0, 0, 0, 0.829);
    }
    .social-menu ul li:nth-child(2) a:hover{
        background-color: #E4405F;
    }
    .social-menu ul li:nth-child(3) a:hover{
        background-color: #0077b5;
    }
    .social-menu ul li:nth-child(4) a:hover{
        background-color: #000;
    }
    </style>
</head>
<body>
<img  src='http://4unettinghub.com/assets/images/logo/1.png' alt='nettinghub' width="200" height="150" style="width: 200px;height: 150px">
<br>
<br>
<p style='text-align: center;color:rgb(0, 148, 167);'>Your New Password : <br>{{$data['password']}}</p>


<p style='text-align: center;font-size:10px;color:rgb(0, 148, 167);'>This message is from a notification-only address. Please do not reply to this email</p>

<p style='color:rgb(0, 148, 167);' >Can we help?</p>


<p style='color:rgb(0, 148, 167);' >If you encounter an issue, please contact</p>

    <p><a style='color:rgb(0, 148, 167);  text-decoration: none;' href = 'mailto: support@4unettinghub.com'> <span style="font-weight: bolder;"> Email:</span> support@4unettinghub.com</a></p>
    <a style='color:rgb(0, 148, 167);  text-decoration: none;' href = 'https://wa.me/12224368520'> <span style="font-weight: bolder;"> WhatsApp:</span> +2012224368520</a>
<div class="social-menu">

</div>
</body>
</html>
