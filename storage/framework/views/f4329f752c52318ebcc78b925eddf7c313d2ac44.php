<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Quick App| Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(url('dashboard')); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(url('dashboard')); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo e(url('dashboard')); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(url('dashboard')); ?>/dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo e(url('dashboard')); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo e(url('dashboard')); ?>/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
    .ps-1{
        padding-left: 15px;
    }

    .custom-pagination{
        width: 40%;
        display: flex;
    }
    .custom-pagination ul li{
        box-sizing: border-box;
        display: inline-block;
        min-width: 1.5em;
        padding: 0.5em 1em;
        margin-left: 2px;
        text-align: center;
        text-decoration: none !important;
        color: #333 !important;
        border: 1px solid #e7e7e7;
        border-radius: 2px;
    }
    .custom-pagination ul li.active ,.custom-pagination ul li.active a{
        background-color: #0c84ff;
        color: #fff;
    }
    .cartimage{
        max-height: 120px;
    }
    .product-title{
        min-height: 70px;
        max-height: 70px;
        overflow-y: scroll;
    }

   .free_sample input[type=checkbox] + label {
        display: block;
        margin: 0.2em;
        cursor: pointer;
        padding: 0.2em;
        font-family: 'Arial'
    }

  .free_sample  input[type=checkbox] {
        display: none;
    }

  .free_sample  input[type=checkbox] + label:before {
        content: "\2714";
        border: 0.1em solid #000;
        border-radius: 0.2em;
        display: inline-block;
        width: 1em;
        height: 1.3em;
        padding-left: 0.2em;
        padding-bottom: 0.3em;
        margin-right: 0.5em;
        vertical-align: bottom;
        color: transparent;
        transition: .2s;
    }

   .free_sample input[type=checkbox] + label:active:before {
        transform: scale(0);
    }

   .free_sample input[type=checkbox]:checked + label:before {
        background-color: #ED820A;
        border-color: #ED820A;
        color: #fff;
    }

   .free_sample input[type=checkbox]:disabled + label:before {
        transform: scale(1);
        border-color: #aaa;
    }

   .free_sample input[type=checkbox]:checked:disabled + label:before {
        transform: scale(1);
        background-color: #F7C28F;
        border-color: #F7C28F;
    }

    .loader img{
        border-radius: 15px;
    }
    .loader{
        position: fixed;
        left: 50%;
        top: 40%;
        width: 20%;
        height: 20%;
        z-index: 9999;
        display: none;
        border: 1px solid #bbb;
        border-radius: 15px;
        box-shadow: 2px 2px 10px 2px #888888;
        background-color: white;
    }

    .increase-decrease{
        border: none;
        border-radius: 3px;
        font-size: 20px;
        font-weight: bolder;
    }


</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">
<?php /**PATH C:\Users\bishoy.sobhy\Desktop\laravel\mall\mallofarabia\resources\views/AdminPanel/layouts/header.blade.php ENDPATH**/ ?>