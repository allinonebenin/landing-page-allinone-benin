<?php use Core\Auth\DBAuth;
    //Auth
    $app=App::getInstance();
    $auth = new DBAuth($app->getDb());
    if($auth->logged())
    {
        $user_id = $auth->getUserId();
    }
    $ip=App::get_ip();
    //si un utilisateur veut se connecter
    if(isset($_POST['signin'])){
      $auth = new \Core\Auth\DBAuth(App::getInstance()->getDb());
      if ($auth->login($_POST['email'], $_POST['password'], "utilisateur"))
      {
        $user_id = $auth->getUserId();
        $app->getTable('Utilisateur')->update([
          'id' =>  $user_id
        ], [
          'nbrconn' => ($app->getTable('Utilisateur')->findattr('nbrconn', $_POST['email'], 'mail')->nbrconn +1)]);
          header('Location: index.php');
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
    //si un visiteur veut s'inscrire à la newsletter
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
        <!-- le titre de la page -->
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


        <!-- Jquery -->
        <script type="text/javascript" src="js/jquery.min.js"></script>

		<!--[if lt IE 9]>
           <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Begin MailChimp Signup Form -->
		<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		    #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
		    /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
		       We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
		</style>

		<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
		<script type='text/javascript'>
			(function($) {
				window.fnames = new Array();
				window.ftypes = new Array();
				fnames[0]='EMAIL';
				ftypes[0]='email';
				fnames[1]='FNAME';
				ftypes[1]='text';
				fnames[2]='LNAME';
				ftypes[2]='text';
				fnames[3]='MMERGE3';
				ftypes[3]='text';
				fnames[4]='MMERGE4';
				ftypes[4]='text';
			}(jQuery));var $mcj = jQuery.noConflict(true);
		</script>
		<!--End mc_embed_signup-->

    </head>
    <body style="overflow-x:hidden;">

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
										<li class="active"><a href="#personal-area"><i class="fa fa-home"></i>Homepage</a></li>
										<li><a href="#my-service"><i class="fa fa-rocket"></i>Our Service</a></li>
										<li><a href="#portfolio"><i class="fa fa-briefcase"></i>Portfolio</a></li>
										<li><a href="#my-timeline"><i class="fa fa-history"></i>Timeline</a></li>
										<li><a href="#pricing"><i class="fa fa-star"></i>Price</a></li>
										<li><a href="#blog"><i class="fa fa-pencil"></i>Blog</a></li>
										<li><a href="#contact"><i class="fa fa-address-book"></i>Contact</a></li>
                    <li><a href="article.php?p=agenda"><i class="fa fa-calendar"></i>Agenda</a></li>
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
                      echo '<li style="display:block"><a href="index.php?p=deconnexion"><i class="fa fa-sign-out"></i></a></li>';
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
                      <a href="article.php?p=register">Pas inscrit?</a>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal -->

		<!-- Start Personal Area -->
		<section id="personal-area">
			<div class="personal-main">
				<div class="personal-single">
					<div class="container">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<!-- Personal Text -->
								<div class="personal-text">
									<div class="my-info">
										<h1>ALL IN ONE &minus; BENIN</h1>
										<h2 class="cd-headline clip is-full-width">
										   <span class="cd-words-wrapper">
											   <b class="is-visible">Training & Test Center.</b>
											   <b style="text-align: center;">Web / Mobile Applications.</b>
											   <b style="text-align: center;">Translations.</b>
											   <b style="text-align: center;">Kids program.</b>
											   <b>Movie night.</b>
											   <b style="text-align: center;">Scholarships.</b>
											   <b>LOTERIE VISA USA.</b>
											   <b>Excursions Ghana.</b>
											</span>
										</h2>
										<div class="button">
											<a href="tel:22962-55-24-13" class="btn primary shine"><i class="fa fa-phone"></i>Call us</a>
											<a href="mailto:info@allinone-benin.com" class="btn shine"><i class="fa fa-envelope"></i>Contact us</a>
										</div>
									</div>
								</div>
								<!--/ End Personal Text -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/ End Personal Area -->
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
		<!-- Start About Me -->
		<section id="about-me" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 fix">
						<!-- About Tab -->
						<div class="tabs-main">
							<!-- Tab Menu -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><span class="tooltips">About Us</span><a href="#welcome" role="tab" data-toggle="tab"><i class="fa fa-user"></i></a></li>
								<li role="presentation"><span class="tooltips">Our Skill</span><a href="#skill" role="tab"  data-toggle="tab"><i class="fa fa-rocket"></i></a></li>
								<li role="presentation"><span class="tooltips">Why Us</span><a href="#why" role="tab"  data-toggle="tab"><i class="fa fa-question"></i></a></li>
								<li role="presentation"><span class="tooltips">Our Vision</span><a href="#vision" role="tab"  data-toggle="tab"><i class="fa fa-graduation-cap"></i></a></li>
							</ul>
							<!--/ End Tab Menu -->
							<div class="tab-content">
								<!-- Single Tab -->
								<div role="tabpanel" class="tab-pane fade in active" id="welcome">
									<div class="about-text">
										<h2 class="tab-title">About All In One - Benin</h2>
										<div class="row">
											<div class="col-md-4 col-sm-4 col-xs-12">
												<!-- About Image -->
												<div class="single-image">
													<img src="images/about1.png" alt="">
												</div>
											</div>
											<!-- End About Image -->
											<div class="col-md-8 col-sm-12 col-xs-12">
												<div class="content" style="text-align: justify;">
													<p>ALL IN ONE-BENIN is an international Test Center and a professional
                            							IT and English training center with a team of international experts.</p>
													<p>ALL IN ONE-BENIN works with its collaborators and partners (private or public,
							                            individuals or companies). In addition to the comfort and the technical expertise,
							                            ALL IN ONE-BENIN has a customer service available 24/7 for Web projects, Mobile
							                            Applications (Android and IOS), Backup, Audit and Cloud Infrastructure.<br>
							                        	If you want to meet the director, ask for an
							                        	<a target="_blank" href="http://allinonebenin.setmore.com">appointment</a>
							                        </p>
							                        <p>Tel +299. 62.55.24.13 | +229 95.88.89.64 | Email : info@allinone-benin.com<br>
							                        	Google Business: <a target="_blank" href="http://allinonebenin.business.site/">www.allinonebenin.business.site</a>
							                          	| <a href="article.php?p=regulation">REGULATIONS</a>
												</div>
												<div class="social">
													<ul>
														<li><a target="_blank" href="https://web.facebook.com/All-in-One-Benin-1802677699961644"><i class="fa fa-facebook"></i></a><li>
														<li><a target="_blank" href="https://twitter.com/allinonebenin"><i class="fa fa-twitter"></i></a><li>
														<li><a target="_blank" href="https://www.youtube.com/channel/UCiiCcEt9SBzthJ9gAdSUp4A"><i class="fa fa-youtube"></i></a><li>
													</ul>
													<br><br>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--/ End Single Tab -->
								<!-- Single Tab -->
								<div role="tabpanel" class="tab-pane fade" id="skill">
									<h2 class="tab-title">Our Skill</h2>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<!-- Single Skill -->
											<div class="single-skill">
												<div class="skill-info">
													<h4>TOEFL Training</h4>
												</div>
												<div class="progress">
												  <div class="progress-bar" role="progressbar" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100" style="width: 92%;"><span>92%</span></div>
												</div>
											</div>
											<!--/ End Single Skill -->
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<!-- Single Skill -->
											<div class="single-skill">
												<div class="skill-info">
													<h4>IELTS Training</h4>
												</div>
												<div class="progress">
												  <div class="progress-bar" role="progressbar" aria-valuenow="93" aria-valuemin="0" aria-valuemax="100" style="width: 93%;"><span>93%</span></div>
												</div>
											</div>
											<!--/ End Single Skill -->
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<!-- Single Skill -->
											<div class="single-skill">
												<div class="skill-info">
													<h4>GRE Training</h4>
												</div>
												<div class="progress">
												  <div class="progress-bar" role="progressbar" aria-valuenow="83" aria-valuemin="0" aria-valuemax="100" style="width: 83%;"><span>83%</span></div>
												</div>
											</div>
											<!--/ End Single Skill -->
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<!-- Single Skill -->
											<div class="single-skill">
												<div class="skill-info">
													<h4>GMAT Training</h4>
												</div>
												<div class="progress">
												  <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%;"><span>95%</span></div>
												</div>
											</div>
											<!--/ End Single Skill -->
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<!-- Single Skill -->
											<div class="single-skill">
												<div class="skill-info">
													<h4>English Courses</h4>
												</div>
												<div class="progress">
												  <div class="progress-bar" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"><span>98%</span></div>
												</div>
											</div>
											<!--/ End Single Skill -->
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<!-- Single Skill -->
											<div class="single-skill">
												<div class="skill-info">
													<h4>Domain Name and Hosting</h4>
												</div>
												<div class="progress">
												  <div class="progress-bar" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="width: 88%;"><span>88%</span></div>
												</div>
											</div>
											<!--/ End Single Skill -->
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<!-- Single Skill -->
											<div class="single-skill">
												<div class="skill-info">
													<h4>Website Development</h4>
												</div>
												<div class="progress">
												  <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"><span>85%</span></div>
												</div>
											</div>
											<!--/ End Single Skill -->
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<!-- Single Skill -->
											<div class="single-skill">
												<div class="skill-info">
													<h4>Mobile Applications</h4>
												</div>
												<div class="progress">
												  <div class="progress-bar" role="progressbar" aria-valuenow="79" aria-valuemin="0" aria-valuemax="100" style="width: 79%;"><span>79%</span></div>
												</div>
											</div>
											<!--/ End Single Skill -->
										</div>
									</div>
								</div>
								<!--/ End Single Tab -->
								<!-- Single Tab -->
								<div role="tabpanel" class="tab-pane fade" id="why">
									<div class="about-text">
										<h2 class="tab-title">Why All in one Benin?</h2>
										<div class="content">
											<p>We are the Number #1 in Professional Training in Benin and accross Africa. We offer several resources :</p>
											<ol style="color:whitesmoke; padding-left: 50px;">
												<li>High and well equipped training room that meet international standards </li>
												<li>Special discounted packages, including the preparation course</li>
												<li>Individual feedback and advice from your instructor</li>
												<li>Practice in all areas of the course</li>
												<li>Coaching and mentoring sessions</li>
												<li>Use of ALL IN ONE-BENIN training Center, with a wide range of English preparation materials including online resources</li>
												<li>Regular individual and group practice tests</li>
											</ol>
											<br><br>
										</div>
									</div>
								</div>
								<!--/ End Single Tab -->
								<!-- Single Tab -->
								<div role="tabpanel" class="tab-pane fade" id="vision">
									<div class="about-text">
										<h2 class="tab-title">Our Vision</h2>
										<div class="content">
											<p>
                          Become the best Training and Test Center in:
                      </p>
                      <table style="color:whitesmoke; text-align: center; background-color: transparent" border="1">
                          <thead>
                              <tr>
                                  <td><h4>ENGLISH</h4></td>
                                  <td><h4>INFORMATIQUE</h4></td>
                              </tr>
                          </thead>
                          <tr>
                              <td>TOEFL</td>
                              <td>Serveur Side - PHP </td>
                          </tr>
                          <tr>
                              <td>IELTS</td>
                              <td>FrontEnd - Javascript</td>
                          </tr>
                          <tr>
                              <td>GRE</td>
                              <td>Windows Server</td>
                          </tr>
                          <tr>
                              <td>GMAT</td>
                              <td>Linux</td>
                          </tr>
                          <tr>
                              <td>Reading Class</td>
                              <td>Enterprise Training</td>
                          </tr>
                          <tr>
                              <td>Speaking & Listening Class</td>
                              <td>MySQL</td>
                          </tr>
                      </table>
                      <br><br><br>
										</div>
									</div>
								</div>
								<!--/ End Single Tab -->
							</div>
						</div>
						<!--/ End About Tab -->
					</div>
				</div>
			</div>
		</section>
		<!--/ End About Me -->

		<!-- Start Service -->
		<section id="my-service" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-title">
							<h1><span>Our</span> Service<i class="fa fa-rocket"></i></h1>
							<p>What we do<p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-delay="0.4s">
						<!-- Single Service -->
						<div class="single-service active">
							<i class="fa fa-graduation-cap"></i>
              <a target="_blank" href="article.php?p=english"><h2>English Classes</h2></a>
              <ul>
                  <li>TOEFL</li>
                  <li>IELTS</li>
                  <li>GRE</li>
                  <li>GMAT</li>
                  <li>Reading class</li>
                  <li>Speaking & listening</li>
                  <li>Business english</li>
                  <li>Special formation</li>
              </ul>
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-delay="0.6s">
						<!-- Single Service -->

						<div class="single-service">
							<i class="fa fa-code"></i>
							<a target="_blank" href="article.php?p=it"><h2>IT Courses</h2> </a>
				            <ul>
				                <li>Serveur side</li>
				                <li>PHP - MySQL</li>
				                <li>FrontEnd</li>
				                <li>Javascript</li>
				                <li>Windows server</li>
				                <li>Linux</li>
				                <li>Staff training</li>
				                <li>Special formation</li>
				            </ul>
						</div>

						<!-- End Single Service -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-delay="0.8s">
						<!-- Single Service -->
						<div class="single-service">
						<i class="fa fa-paint-brush"></i>
			            <a target="_blank" href="article.php?p=web"><h2>Web</h2></a>
				            <ul>
				                <li>Showcase site</li>
				                <li>E-Commerce Website</li>
				                <li>Blog creation</li>
				                <li>Responsive design</li>
				                <li>Portfolio design</li>
				                <li>Company landing page</li>
				                <li>Application mobile</li>
				                <li>Web hosting</li>
				            </ul>
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-delay="0.8s">
						<!-- Single Service -->
						<div class="single-service">
							<i class="fa fa-ellipsis-h"></i>
              <a target="_blank" href="article.php?p=other"><h2>Other services</h2></a>
              <ul>
                  <li>Translation</li>
                  <li>Help me</li>
                  <li>Location</li>
                  <li>Conference room</li>
                  <li>PC Reservation</li>
                  <li>Audit</li>
                  <li>Consultation</li>
                  <li>Etc.</li>
              </ul>
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-delay="0.8s">
						<!-- Single Service -->
						<div class="single-service">
							<i class="fa fa-child"></i>
              <!-- article.php?p=kid -->
              <a target="_blank" href="Kids-programs-membership-manager-pro"><h2>Kids program</h2></a>
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-delay="0.8s">
						<!-- Single Service -->
						<div class="single-service">
							<i class="fa fa-desktop"></i>
              <a target="_blank" href="dstv-landing"><h2>IT services</h2></a>
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-delay="0.8s">
						<!-- Single Service -->
						<div class="single-service">
							<i class="fa fa-cloud"></i>
              <a target="_blank" href="http://allinonebenin.duoservers.com"><h2>Cloud services</h2></a>
						</div>
						<!-- End Single Service -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-delay="1s" data-filter=".development">
						<!-- Single Service -->
						<div class="single-service">
							<i class="fa fa-pencil-square-o"></i>
              <a href="mailto:info@allinone-benin.com?subject=Question S&eacute;curit&eacute;&amp;anp;body=">
                <h2>Consulting</h2></a>
						</div>
						<!-- End Single Service -->
					</div>
				</div>
			</div>
		</section>
		<!--/ End Service -->

		<!--content-->
			<?= $content; ?>
		<!--content-->


		<!-- Start Clients -->
		<div id="clients" class="section" data-stellar-background-ratio="0.3">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-5 col-md-12 col-sm-12 col-xs-12">
						<div class="clients-slider">
							<!-- Single Clients -->
							<div class="single-clients">
								<img src="images/aio.png" alt="#">
							</div>
							<!--/ End Single Clients -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/ End Clients -->

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
						<!-- <form class="news-form" method="post">
							<input type="email" name="email" placeholder="type your email">
							<button name="news" type="submit" class="button primary"><i class="fa fa-paper-plane"></i></button>
						</form> -->
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
							<p>&copy; Copyright 2016-2018 All in one Benin.</p>
						</div>
						<!--/ End Copyright -->
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<!-- Social -->
						<ul class="social">
							<li><a target="_blank" href="https://web.facebook.com/All-in-One-Benin-1802677699961644"><i class="fa fa-facebook"></i></a></li>
							<li><a target="_blank" href="https://twitter.com/allinonebenin"><i class="fa fa-twitter"></i></a></li>
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
