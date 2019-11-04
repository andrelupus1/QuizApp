<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>QuizApp - Ativação de Conta</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
       <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?= base_url('layout/css/bootstrap.min.css'); ?>">
        <!-- css-->
        <link rel="stylesheet" href="<?= base_url('layout/css/estilos.css'); ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('layout/font-awesome/css/font-awesome.min.css'); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?= base_url('layout/css/ionicons.min.css');?>">
       
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= base_url('layout/plugins/iCheck/square/blue.css'); ?>">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
        <a href="<?=base_url('/home'); ?>"><b>Oft</b>Quiz</a>
        </div>
            <!-- /.login-logo -->
        <div class="login-box-body">
                <h2 class="login-box-msg">ATIVAÇÃO!</h2>
                <hr>
                <p  class="login-box-msg"><?=$mensagem?></p>
                <hr>
                <strong>*Acesse nosso APP com seu <u>e-mail</u> e <u>senha</u> cadastrados!</strong>
        </div>
    </div>
</body>
</html>