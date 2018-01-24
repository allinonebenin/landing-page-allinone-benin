<?php use Core\Auth\DBAuth;
    //Auth
    $app=App::getInstance();
    $auth = new DBAuth($app->getDb());
    if($auth->logged())
    {
          header('Location: admin.php?p=home');
    }
?>
<body class="hold-transition login-page">
<?php
  if(isset($_POST['back'])){
    header('Location: index.php');
  }
  if(isset($_POST['signin'])){
    $auth = new \Core\Auth\DBAuth(App::getInstance()->getDb());
    if ($auth->login($_POST['mail'], $_POST['password'], "employe"))
    {
      $user_id = $auth->getUserId();
        $app->getTable('Employe')->update([
          'id' =>  $user_id
        ], [
          'nbrconn' => ($app->getTable('Employe')->findattr('nbrconn', $_POST['mail'], 'mail')->nbrconn +1)]);
      header('Location: admin.php?p=home');
    }
    else
    {
      ?>
      <div class="alert alert-danger">
      Identifiants incorrect
      </div>
    <?php
    }
  }
?>
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><img src="images/logo.png" width="40px" height="40px" /><b>ll in one</b> - Benin</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input id="mail" name="mail" type="text" class="form-control" placeholder="Login" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="pass" name="password" type="password" type="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <button type="submit" name="signin" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="button" name="back" class="btn btn-default btn-block btn-flat">Home</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
