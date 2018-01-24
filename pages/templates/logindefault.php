<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name='copyright' content='codeglim'>
  <meta charset="UTF-8">
  <meta name="description" content="ALL IN ONE-BENIN is an international Test Center and a professional IT and English training center in Benin with a team of international experts">
  <meta name="keywords" content="Training & Test Center, Applications  Web & Mobile, Traductions, Anglais Pour Enfants, Fulbright Fellowship, LOTERIE VISA USA, Excursions Ghana, Listening Speaking, Learning English, TOEFL, IELTS, GRE, GMAT, Immigration Canada, Bourses Etudes, Movie, Cinema, Formations, Benin, Africa, Audit, Securite, Security, Kids Program, Article, Post, Blog, Portfolio, Projet, Android">
  <meta name="author" content="All In One-Benin">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= App::getInstance()->title?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/orange.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<!--content-->
	<?= $content; ?>
<!--content-->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
