
<html>
<head>
</head>
<body style="padding: 20px">
<img style='width:20%;' src='http://nettinghub.com/logo.png' alt='Italian Trulli'>

<h1 style='color:rgb(0, 148, 167);  text-align: center;'>{!! $data['subject'] !!} </h1>
<h1>User Name : {!! $data['first_name'] !!} {!! $data['last_name'] !!}</h1>
<h1>Phone : {!! $data['phone'] !!}</h1>
<h1>Subject : {!! $data['subject'] !!}</h1>
<h1>Message</h1>
<p>{!! $data['message'] !!}</p>

</body>
</html>
