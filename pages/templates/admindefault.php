<?php use Core\Auth\DBAuth;
    //Auth
    $app=App::getInstance();
    $auth = new DBAuth($app->getDb());
    if(!$auth->logged())
    {
        $app->forbidden();
    }
    else
    {
        $lid = $auth->getUserId();
        $nom=$app->getTable('Employe')->findattr("nom", $lid)->nom;
        $prenom= $app->getTable('Employe')->findattr("prenom", $lid)->prenom;
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= App::getInstance()->title?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="../../plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="../../plugins/fullcalendar/fullcalendar.print.css" media="print">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/skin-orange.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/orange.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/skin-orange.css">


  <link rel="stylesheet" href="bootstrap/css/bootstrap-fileupload.min.css" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script>
        (function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);
    </script>
</head>

<body class="hold-transition skin-yellow-light sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="admin.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>io</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>All in one - </b>Benin</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><?=$app->getTable('Messages')->compteattr('etat', '0')->tot;?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?=$app->getTable('Messages')->compteattr('etat', '0')->tot;?> message(s)</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu user">
                  <!-- start message -->
                  <?php
                    if($app->getTable('Messages')->compteattr('etat', '0')->tot==0)
                      echo '<li>Vous avez 0 nouveaux messages</li>';
                    else
                    {
                      foreach ($app->getTable('Messages')->allwhere('etat', '0') as $mes) {
                        echo '
                          <li>
                            <a href="#">
                              <div class="pull-left">
                                <img src="'.$mes->lien.'" class="user-image" alt="User Image" width="15px" height="15px">
                              </div>
                              <h4>
                                '.$mes->nom.'
                                <small><i class="fa fa-clock-o"></i> '.$mes->datepub.'</small>
                              </h4>
                              <p>'.$mes->contenu.'</p>
                            </a>
                          </li>
                        ';
                      }
                    }
                  ?>
                  <!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="admin.php?p=messages">See All Messages</a></li>
            </ul>
          </li>
<!--
          <!-- Notifications: style can be found in dropdown.less
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-info">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li> -->

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=$app->getTable('Employe')->findattr("lien", $lid)->lien?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$nom . ' ' . $prenom?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=$app->getTable('Employe')->findattr("lien", $lid)->lien?>" class="img-circle" alt="User Image">

                <p>
                  <?=$app->getTable('Employe')->findattr("nom", $lid)->nom . ' ' . $app->getTable('Employe')->findattr("prenom", $lid)->prenom?>
                  <small>Member since <?=App::mois($app->getTable('Employe')->extractAttr("m", $lid, "datecreat")->m) . '. ' . $app->getTable('Employe')->extractAttr("a", $lid, "datecreat")->a?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="admin.php?p=employee&id=<?=$lid;?>" class="btn btn-default btn-flat">Profile</a>
                  <a style="margin-left: 8px" target="_blank" href="index.php" class="btn btn-default btn-flat">Website Link</a>
                </div>
                <div class="pull-right">
                  <a href="?p=deconnexion" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=$app->getTable('Employe')->findattr("lien", $lid)->lien?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=$nom . ' ' . $prenom?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->


      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MENU</li>
        <li
          <?php
            if (App::getInstance()->classe=='home') echo 'class="active"';
          ?>
        >
          <a href="admin.php?p=home">
            <i class="fa fa-home"></i> <span>Home</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
        <li
          <?php
            if (App::getInstance()->classe=='posts' || App::getInstance()->classe=='post') echo 'class="active"';
          ?>
        >
          <a href="admin.php?p=posts">
            <i class="fa fa-file"></i> <span>Posts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
        <li
          <?php
            if (App::getInstance()->classe=='portfolios' || App::getInstance()->classe=='portfolio') echo 'class="active"';
          ?>
        >
          <a href="admin.php?p=portfolios">
            <i class="fa fa-briefcase"></i> <span>Portfolios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
        <li
          <?php
            if (App::getInstance()->classe=='events' || App::getInstance()->classe=='event') echo 'class="active"';
          ?>
        >
          <a href="admin.php?p=events">
            <i class="fa fa-calendar"></i> <span>Events</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
        <li
          <?php
            if (App::getInstance()->classe=='messages' || App::getInstance()->classe=='compose' || App::getInstance()->classe=='sent' || App::getInstance()->classe=='readmail') echo 'class="active"';
          ?>
        >
          <a href="admin.php?p=messages">
            <i class="fa fa-envelope-o"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
        <li
          <?php
            if (App::getInstance()->classe=='users') echo 'class="active"';
          ?>
        >
          <a href="admin.php?p=users">
            <i class="fa fa-user"></i> <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
        <li
          <?php
            if (App::getInstance()->classe=='employees') echo 'class="active"';
          ?>
        >
          <a href="admin.php?p=employees">
            <i class="fa  fa-user-secret"></i> <span>Employees</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!--content-->
			<?= $content; ?>
		<!--content-->
    </div>
     <!-- /.content-wrapper -->
 <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.1.1
    </div>
 <strong>© 2017 <a href="#">All in one - Benin</a>.</strong> Tout droit réservé
  </footer>

</div>
<!-- ./wrapper -->


<script type="text/javascript">
  function show(form)
  {
    var obj=document.getElementById(form);
    obj.style.display="block";
    var jfile=document.getElementById('jfile');
    jfile.setAttribute("data-validation","required");
  }
  function hide(form)
  {
    var obj=document.getElementById(form);
    obj.style.display="none";
    var jfile=document.getElementById('jfile');
    jfile.removeAttribute("data-validation","required");
  }
</script>

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script src="bootstrap/js/bootstrap-fileupload.js"></script>
</body>
</html>
