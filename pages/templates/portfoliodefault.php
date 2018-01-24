<?php use Core\Auth\DBAuth;
  $lapage='';
    //Auth
    $app=App::getInstance();
    $auth = new DBAuth($app->getDb());
    if($auth->logged())
    {
        $user_id = $auth->getUserId();
    }
    if(isset($_POST['signin'])){
      $auth = new \Core\Auth\DBAuth(App::getInstance()->getDb());
      if ($auth->login($_POST['email'], $_POST['password'], "utilisateur"))
      {
        $user_id = $auth->getUserId();
        $app->getTable('Utilisateur')->update([
          'id' =>  $user_id
        ], [
          'nbrconn' => ($app->getTable('Utilisateur')->findattr('nbrconn', $_POST['email'], 'mail')->nbrconn +1)]);
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

    if(isset($_POST['news']))
    $result=$app->getTable('Newslatter')->create([
      'mail' => $_POST['email']
      ]);
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">
    <head>
        <!-- Meta tag -->
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name='copyright' content='codeglim'>
        <meta charset="UTF-8">
        <meta name="description" content="ALL IN ONE-BENIN is an international Test Center and a professional IT and English training center in Benin with a team of international experts">
        <meta name="keywords" content="Training & Test Center, Applications  Web & Mobile, Traductions, Anglais Pour Enfants, Fulbright Fellowship, LOTERIE VISA USA, Excursions Ghana, Listening Speaking, Learning English, TOEFL, IELTS, GRE, GMAT, Immigration Canada, Bourses Etudes, Movie, Cinema, Formations, Benin, Africa, Audit, Securite, Security, Kids Program, Article, Post, Blog, Portfolio, Projet, Android">
        <meta name="author" content="All In One-Benin">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?= App::getInstance()->title?></title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="images/favicon.ico">
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="css/animate.min.css">
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Fancy Box CSS -->
        <link rel="stylesheet" href="css/jquery.fancybox.min.css">
        <!-- Slick Nav CSS -->
        <link rel="stylesheet" href="css/slicknav.min.css">
        <!-- Animate Text -->
        <link rel="stylesheet" href="css/animate-text.css">
        <!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="css/owl.theme.default.css">
        <link rel="stylesheet" href="css/owl.carousel.min.css">
        <!-- Bootstrap Css -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Sufia StyleShet -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/responsive.css">
        <!-- Maheraj Template Color -->
        <link rel="stylesheet" href="css/color/color1.css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
    		<!--[if lt IE 9]>
               <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    		<![endif]-->
    		<style type="text/css">

    			.survol a {text-decoration : none;
    			 padding : 0 0 2px 0;}

    			.survol a:hover, .survol a:focus {
    			 text-decoration : none;
    			 padding : 0 0 7px 0;
    			 border-bottom : 4px solid white;}
    		</style>
    </head>
    <body>

		<!-- Preloader -->
		<div class="loader">
			<div class="loader-inner">
				<div class="k-line k-line11-1"></div>
				<div class="k-line k-line11-2"></div>
				<div class="k-line k-line11-3"></div>
				<div class="k-line k-line11-4"></div>
				<div class="k-line k-line11-5"></div>
			</div>
		</div>
		<!-- End Preloader -->

		<!-- Start Header -->
		<header id="header">
			<div class="container">
				<div class="row">
					<div class="col-md-2 col-sm-12 col-xs-12">
            <!-- Logo -->
						<div class="logo" style="margin-top:-10px">
							<img src="images/logo-white.png" alt="logo" id="im-log" height="40px" width="40px">
							<a style="top:-30px; left: 30px" href="index.php">All in one - Benin</a>
						</div>
						<!--/ End Logo -->
						<div class="mobile-nav"></div>
					</div>
					<div class="col-md-10 col-sm-12 col-xs-12">
						<div class="nav-area">
							<!-- Main Menu -->
							<nav class="mainmenu">
								<div class="collapse navbar-collapse">
									<ul class="nav navbar-nav menu">
										<li><a href="index.php#personal-area"><i class="fa fa-home"></i>Homepage</a></li>
										<li><a href="index.php#my-service"><i class="fa fa-rocket"></i>Our Service</a></li>
                    <li
                      <?php
                        if (App::getInstance()->classe=='portfolios' || App::getInstance()->classe=='portfolio') echo 'class="active"';
                      ?>
                    ><a href="portfolio.php"><i class="fa fa-briefcase"></i>Portfolio</a></li>
										<li><a href="index.php#my-timeline"><i class="fa fa-history"></i>Timeline</a></li>
										<li><a href="index.php#testimonials"><i class="fa fa-star"></i>Testimonials</a></li>
                    <li
                      <?php
                        if (App::getInstance()->classe=='articles' || App::getInstance()->classe=='article') echo 'class="active"';
                      ?>
                    ><a href="article.php"><i class="fa fa-pencil"></i>Blog</a></li>
										<li><a href="index.php#contact"><i class="fa fa-address-book"></i>Contact</a></li>
                    <li
                      <?php
                        if (App::getInstance()->classe=='agenda') echo 'class="active"';
                      ?>
                    ><a href="article.php?p=agenda"><i class="fa fa-calendar"></i>Agenda</a></li>
										<!-- <li><a href="index.php#contact"><i class="fa fa-check"></i>Online</a></li> -->
									</ul>
                  <ul
                  <?php
                    if($auth->logged())
                    {
                      echo 'style="top:10px" ';
                    }
                  ?>
                   class="social-icon">
                    <?php
                    if($auth->logged())
                    {
                      echo '<li style="display:block"><a href="article.php?p=pdeconnexion"><i class="fa fa-sign-out"></i></a></li>';
                    }
                     ?>
										<li><a href="#"><i class="fa fa-plus"></i></a></li>
									</ul>
									<ul class="social">
                    <?php
                    if(!$auth->logged())
                    {
                      echo'
                        <li><a href="" data-toggle="modal" data-target="#myModal"><i class="fa fa-unlock-alt"></i></a></li>
                        <li><a href="article.php?p=register"><i class="fa fa-user-plus"></i></a></li>
                      ';
                    }
                     ?>
                    <li><a target="_blank" href="https://web.facebook.com/All-in-One-Benin-1802677699961644"><i class="fa fa-facebook"></i></a></li>
										<li><a target="_blank" href="https://twitter.com/allinonebenin"><i class="fa fa-twitter"></i></a></li>
                    <li><a target="_blank" href="https://www.youtube.com/channel/UCiiCcEt9SBzthJ9gAdSUp4A"><i class="fa fa-youtube"></i></a><li>
									</ul>
								</div>
							</nav>
							<!--/ End Main Menu -->
						</div>
					</div>
				</div>
			</div>
		</header>
		<!--/ End Header -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:#F2784B;">Login</h4>
                </div>
                <div class="modal-body">
                  <form action="" method="post">
                    <div class="form-group has-feedback">
                      <input name="email" type="email" class="form-control" placeholder="Login" required>
                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                      <input name="password" type="password" class="form-control" placeholder="Password" required>
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                      <!-- /.col -->
                      <div class="col-xs-4">
                        <button type="submit" name="signin" class="btn btn-warning btn-block btn-flat">Sign In</button>
                      </div>
                      <!-- /.col -->
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal -->


		<!-- Start Breadcrumbs -->
		<section id="breadcrumbs">
			<div class="container survol">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2>
							<?php
                if (App::getInstance()->classe=='articles' || App::getInstance()->classe=='article') echo 'Welcome to our Blog';
            	elseif(App::getInstance()->classe=='portfolios' || App::getInstance()->classe=='portfolio') echo 'Welcome to our Achievement';
            	elseif(App::getInstance()->classe=='register') echo 'Account';
        	    elseif(App::getInstance()->classe=='agenda') echo 'Agenda';
                elseif(App::getInstance()->classe=='englishclass') echo'English classes';
                elseif(App::getInstance()->classe=='itcourses') echo'IT Courses';
                elseif(App::getInstance()->classe=='webservice') echo'Web services';
                elseif(App::getInstance()->classe=='otherservice') echo'Other services';
                elseif(App::getInstance()->classe=='signup') echo'Sign up';
                elseif(App::getInstance()->classe=='reservation') echo'Reservation';
                elseif(App::getInstance()->classe=='help') echo'Help';
                elseif(App::getInstance()->classe=='serviceweb') echo'Request for web sites';
                elseif(App::getInstance()->classe=='kid') echo'Kids program';
		          ?>
						</h2>
						<ul class="bread-list">
							<li><a href="index.php">Home</a></li>
              <?php
                if (App::getInstance()->classe=='articles') echo'<li class="active">Blog</li>';
                elseif (App::getInstance()->classe=='article') echo'
                  <li><a href="article.php">Blog</a></li>
                  <li class="active">Article</li>
                ';
                elseif(App::getInstance()->classe=='portfolios') echo'<li class="active">All portfolio</li>';
                elseif (App::getInstance()->classe=='portfolio') echo'
                  <li><a href="portfolio.php">All portfolio</a></li>
                  <li class="active">Porfolio</li>
                ';
                elseif(App::getInstance()->classe=='register') echo'<li class="active">Register</li>';
                elseif(App::getInstance()->classe=='agenda') echo'<li class="active">Agenda</li>';
                elseif(App::getInstance()->classe=='englishclass') echo'<li class="active">English classes</li>';
                elseif(App::getInstance()->classe=='itcourses') echo'<li class="active">IT courses</li>';
                elseif(App::getInstance()->classe=='webservice') echo'<li class="active">Web services</li>';
                elseif(App::getInstance()->classe=='otherservice') echo'<li class="active">Other services</li>';
                elseif(App::getInstance()->classe=='signup') echo'<li class="active">Sign up</li>';
                elseif(App::getInstance()->classe=='reservation') echo'<li class="active">Reservation</li>';
                elseif(App::getInstance()->classe=='help') echo'<li class="active">Help</li>';
                elseif(App::getInstance()->classe=='serviceweb') echo'<li class="active">Request</li>';
                elseif(App::getInstance()->classe=='kid') echo'<li class="active">Kids program</li>';
               ?>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!--/ End Breadcrumbs -->

    <!-- Book me -->
    <script type="text/javascript" src="//allinonebenin.simplybook.me/iframe/contact_widget.js"></script>
    <script type="text/javascript">
      Simplybook_ContactWidget.domain = "allinonebenin.simplybook.me";
      Simplybook_ContactWidget.title = "Contact us";
      Simplybook_ContactWidget.contactTitle = "Laissez nous un message";
      Simplybook_ContactWidget.scheduleTitle = "Faites une R&eacute;servation";
      Simplybook_ContactWidget.timeline = "flexible";
      Simplybook_ContactWidget.offset = "30%";
      Simplybook_ContactWidget.position = "right";
      Simplybook_ContactWidget.color = "#aaaaaa";
      Simplybook_ContactWidget.mobileRedirect = true;
      Simplybook_ContactWidget.addButton();
    </script>
    <!--/ End of book me -->
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
      var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
      (function(){
      var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
      s1.async=true;
      s1.src='https://embed.tawk.to/57aaf9731eed4ecf0623d2b9/default';
      s1.charset='UTF-8';
      s1.setAttribute('crossorigin','*');
      s0.parentNode.insertBefore(s1,s0);
      })();
    </script>
    <!--End of Tawk.to Script-->
		<!--content-->
			<?= $content; ?>
		<!--content-->

		<!-- Footer Top -->
		<section id="footer-top" class="section">
			<div class="container">
				<div class="row">
					<!-- Single Widget -->
					<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="newslatter">
							<h2><span>Signup</span>Newsletter</h2>
							<p>Subscribe to our newsletter to stay connected to our news</p>
						</div>
            <div id="mc_embed_signup">
							<form action="https://allinone-benin.us12.list-manage.com/subscribe/post?u=6e5b138c88028bf10282e8df7&id=8f27c3cee6"
							method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate news-form" target="_blank" novalidate>
							    <div id="mc_embed_signup_scroll">
									<div class="mc-field-group">
									    <label style="display:none;" for="mce-EMAIL">Email Address </label>
									    <input type="email" value="" placeholder="Type Your Email" name="EMAIL" class="required email" id="mce-EMAIL">
									</div>
								    <div id="mce-responses" class="clear">
								        <div class="response" id="mce-error-response" style="display:none"></div>
								        <div class="response" id="mce-success-response" style="display:none"></div>
								    </div>
							    	<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							   		<div style="position: absolute; left: -5000px;" aria-hidden="true">
							   			<input type="text" name="b_6e5b138c88028bf10282e8df7_8f27c3cee6" tabindex="-1" value="">
							   		</div>
							   		<div class="clear">
							   			<!-- <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"> -->
										<button style="margin-top: 10px; margin-right: -5px" id="mc-embedded-subscribe" name="subscribe" type="submit" class="button primary"><i class="fa fa-paper-plane"></i></button>

							   		</div>
							   </div>
							</form>
						</div>
		             <?php
		               if(isset($_POST['subscribe']))
		               {
		                 if($result)
		                 {
		                   echo '<br><p class="alert alert-success">Vous serez maintenant informé de nos dernières actualités</p>';
		                 }
		               }
		             ?>
					</div>
					<!--/ End Single Widget -->
				</div>
			</div>
		</section>
		<!--/ End footer Top -->

		<!-- Start Footer -->
		<footer id="footer">
			<!-- Arrow -->
			<div class="arrow">
				<a href="#personal-area" class="btn"><i class="fa fa-angle-up"></i></a>
			</div>
			<!--/ End Arrow -->
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<!-- Copyright -->
						<div class="copyright">
							<p>&copy; Copyright 2016 All in one Benin.</p>
						</div>
						<!--/ End Copyright -->
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<!-- Social -->
						<ul class="social">
							<li><a href="https://web.facebook.com/All-in-One-Benin-1802677699961644"><i class="fa fa-facebook"></i></a></li>
							<li><a href="https://twitter.com/allinonebenin"><i class="fa fa-twitter"></i></a></li>
              <li><a target="_blank" href="https://www.youtube.com/channel/UCiiCcEt9SBzthJ9gAdSUp4A"><i class="fa fa-youtube"></i></a><li>
						</ul>
						<!--/ End Social -->
					</div>
				</div>
			</div>
		</footer>
		<!--/ End Footer -->

		<!-- logo by scrool -->
    <script type="text/javascript">
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 1) {
                $('#im-log').attr('src', 'images/logo.png');
            } else {
                $('#im-log').attr('src', 'images/logo-white.png');
            }
        });
    </script>

		<!-- Jquery -->
		<script type="text/javascript" src="js/jquery.min.js"></script>

		<!-- Modernizr JS -->
		<script type="text/javascript" src="js/modernizr.min.js"></script>

		<!-- WOW JS -->
		<script type="text/javascript" src="js/wow.min.js"></script>

		<!-- Fancybox js -->
		<script type="text/javascript" src="js/jquery.fancybox.min.js"></script>

		<!-- Animate Text JS -->
		<script type="text/javascript" src="js/animate-text.js"></script>

		<!-- Mobile Menu JS -->
    	<script type="text/javascript" src="js/jquery.slicknav.min.js"></script>

		<!-- Jquery Parallax -->
    	<script type="text/javascript" src="js/jquery.stellar.min.js"></script>

		<!-- Jquery Easing -->
    	<script type="text/javascript" src="js/easing.js"></script>

		<!-- One Page Nav JS -->
    	<script type="text/javascript" src="js/jquery.nav.js"></script>

		<!-- Slider Carousel JS -->
		<script type="text/javascript" src="js/owl.carousel.min.js"></script>

		<!-- Youtube Player JS -->
		<script type="text/javascript" src="js/ytplayer.min.js"></script>

		<!-- Particle JS -->
		<script type="text/javascript" src="js/particles.min.js"></script>

		<!-- Counter JS -->
		<script type="text/javascript" src="js/waypoints.min.js"></script>
		<script type="text/javascript" src="js/jquery.counterup.min.js"></script>

		<!-- Mixitup JS -->
		<script type="text/javascript" src="js/isotope.pkgd.min.js"></script>

		<!-- Bootstrap JS -->
		<script type="text/javascript" src="js/bootstrap.min.js"></script>

		<!-- Main JS -->
		<script type="text/javascript" src="js/main.js"></script>
    </body>
</html>
