<html>
<head>
</head>
<body>
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
<img  src='http://4unettinghub.com/assets/images/logo/1.png' alt='nettinghub' width="200" height="150" style="width: 200px;height: 150px">

<br>
<br>
<h2 style='color:rgb(0, 148, 167)'>Hello  {{$data['full_name']}}</h2>
{{--<h3 style='color:rgb(0, 148, 167)'>Hello Netting Hub khaled mohamed abodaif</h3>--}}

<p style='color:rgb(0, 148, 167)'>Thanks for choosing to be part of 4U Netting Hub team! We are all working towards a common goal and your contribution is integral. Congratulations and welcome aboard! you will take the first step on an incredible journey. Access youth-enhancing products and opportunities and change your life in only a few minutes..</p>

<a style='color:rgb(0, 148, 167);text-decoration: underline;text-align: center;position: relative;left: 0;right: 0;margin: auto;display: block;' href='https://play.google.com/store/apps/details?id=com.akhnaton.networkselling.androidApp'><span style="font-weight: bolder;">CLICK HERE </span>to download the application</a>

{{--<p style='color:rgb(0, 148, 167); '><span style="font-weight: bolder;">Your user Name: </span> khaled.abodaif@yahoo.com</p>--}}
<p style='color:rgb(0, 148, 167); ' ><span style="font-weight: bolder;">Your user Name: </span> {{$data['full_name']}}</p>
{{--<p style='color:rgb(0, 148, 167); ' ></p>--}}

<br>
<p style='color:rgb(0, 148, 167); ' ><span style="font-weight: bolder;">Your user Email: </span> {{$data['email']}}</p>
{{--<p style='color:rgb(0, 148, 167); ' ></p>--}}

<br>
<p style='color:rgb(0, 148, 167); '><span style="font-weight: bolder;">Your Password : </span>{{$data['password']}}</p>

{{--<p style='color:rgb(0, 148, 167);' ></p>--}}

<p style='color:rgb(0, 148, 167);' >Change your password at any time in <span style="font-weight: bolder;"> My Account Setting.</span></p>

<p style='color:rgb(0, 148, 167);' >Can we help?</p>


<p style='color:rgb(0, 148, 167);' >If you encounter an issue, please contact</p>

    <p><a style='color:rgb(0, 148, 167);  text-decoration: none;' href = 'mailto: support@4unettinghub.com'> <span style="font-weight: bolder;"> Email:</span> support@4unettinghub.com</a></p>
    <a style='color:rgb(0, 148, 167);  text-decoration: none;' href = 'https://wa.me/12224368520'> <span style="font-weight: bolder;"> WhatsApp:</span> +2012224368520</a>
<div class="social-menu">
    <ul>
        <li><a href="https://www.facebook.com/NettingHub/" target="blank"><img style="
    width: 50%;
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    margin: auto;
    right: 0;
" src="{{asset('images/facebook.png')}}"></a></li>
    </ul>
</div>
</body>
</html>
