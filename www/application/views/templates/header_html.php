<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>OftQuiz - Sistema de Gestão de Conteúdo</title>
        <meta http-equiv="author" content="Diego Sampaio - diego.estaleiro@gmail.com" />

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?= base_url('layout/css/bootstrap.min.css'); ?>">
        <!-- css-->
        <link rel="stylesheet" href="<?= base_url('layout/css/estilos.css'); ?>">
        <!-- openwysiwyg-->

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('layout/dist/css/rdpannel.min.css'); ?>">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?= base_url('layout/dist/css/skins/_all-skins.min.css'); ?>">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= base_url('layout/plugins/iCheck/flat/blue.css'); ?>">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?= base_url('layout/plugins/morris/morris.css'); ?>">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?= base_url('layout/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?= base_url('layout/plugins/datepicker/datepicker3.css'); ?>">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?= base_url('layout/plugins/daterangepicker/daterangepicker.css'); ?>">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?= base_url('layout/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">
        <!-- dataTable-->
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
        
        <!-- CKEditor -->
        <script src="<?=base_url('/layout/js/jquery-1.11.0.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('layout/js/ckeditor/ckeditor.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('layout/js/ckeditor/samples/sample.js'); ?>"></script>

        

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">