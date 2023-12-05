<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Netting Hub</title>
	<!-- Bootstrap -->
	<link crossorigin="anonymous" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" /><!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --><!-- WARNING: Respond.js doesn't work if you view the page via file:// --><!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body style="  overflow-x: hidden;
">
<?php include"header.php"?>

<img src="homePhoto.png"; style="width:100% ;margin-top: -7px;">
<img src="hp.png"; style="width:100% ;margin-top: -2px;">


<?php
if($_POST['submit'])
{
    
    include "connection.php";

      

	 $mobile=$_POST['mobile'];
	   $id = trim(preg_replace('/[^\p{L}\p{N}\s]/u', '', $mobile));
	
	$email=$_POST['email'];
	
$user="select * from users where email='$email' and mob1='$id'";
$useresult=mysqli_query($conn,$user);
if(mysqli_num_rows($useresult)>=1){
$userrow=mysqli_fetch_array($useresult);

 $id=$userrow['id'];
$status=$userrow['status'];
if($status==1){
 
echo '<script>
window.location.href = "https://nettinghub.com/muser/public/shop/'.$id.'";
</script>';
}elseif($status==2){
    echo '<script>
window.location.href = "https://nettinghub.com/muser/public/cart/'.$id.'";
</script>';
}elseif($status==3){
    echo '<div class="alert alert-danger" role="alert">
This Email is completely register
</div>';
}
}else{
      echo '<div class="alert alert-danger" role="alert">
Invaled mail or phone sorry check agin or to register as new member go to <a href="../../join.php"> join our family</a> 
</div>';
}


}


?>

    @if (Session::has('message'))
   <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
        
         @if(session()->has('error_msg'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('error_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        
<form method="post" action="">

<table  background="bbg.png" style=" background-size: cover;width:100%;border-collapse: separate;border-spacing: 0 15px; ">
<tr style="
    height: 70px;"> <td ></td></tr>

<tr style="text-align: center;"><td><span style="color: #17919f;font-size: 22px;">Mobile:</span><input id="phone" type="text" name="mobile" style="margin-left: 17px; border: 3px solid #17919f;width: 20%;" required ></td></tr>
<script type="text/javascript">
        document.getElementById('phone').addEventListener('input', function (e) {
  var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,4})(\d{0,4})/);
  e.target.value = !x[2] ? x[1] : '(' + x[1] + ')-' + x[2] + (x[3] ? '-' + x[3] : '');
});
    </script>
<tr style="text-align: center;"><td><span style="color: #17919f;font-size: 22px;">e-mail:</span><input type="email" name="email" style="margin-left: 23px;border: 3px solid #17919f;width: 20%;" required></td></tr>
<tr style="text-align: center;" dir="rtl"><td><input type="submit" name="submit" value="COMPLETE NOW" style="color: white;margin-left: 212px;border: 3px solid #17919f;background-color: #17919f; width: 11%;"></td></tr>

</form>
</table>

<?php include"footer.php";?>
</body>
</html>