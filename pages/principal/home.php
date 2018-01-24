<?php
    use Core\Auth\DBAuth;
    //Auth
    $app=App::getInstance();
    $auth = new DBAuth($app->getDb());

    if($auth->logged())
    {
        $user_id = $auth->getUserId();
        //var_dump($user_id);
    }

    if(isset($_GET['id'])) $lien= $app->getTable('Utilisateur')->findattr('lien', $_GET['id'])->lien;
    else $lien='images/users.png';

    if (isset($_POST['contact']))
    {
        $app->getTable('Messages')->create([
            'nom' => $_POST['name'],
            'mail' => $_POST['email'],
            'contenu' =>  $_POST['message'],
            'lien' => $lien
          ]);

        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $email_message = "

        Name: ".$name."
        Email: ".$email."
        Message: ".$message."

        ";

        //echo $email_message;
        if (mail ("info@allinone-benin.com" , "New Message", $email_message))
        {
            $result="<div class='alert alert-success' >Mail successful</div>";
        }
        else
        {
            $result="<div class='alert alert-success' >Mail unsuccessful</div>";
        }

    }
?>
        <!-- Start portfolio -->
		<section id="portfolio" class="section">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-title">
							<h1><span>Our</span> Portfolio<i class="fa fa-briefcase"></i></h1>
							<p>The following are examples of achievements of ALL IN ONE - BENIN</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<!-- portfolio Nav -->
						<div class="portfolio-nav">
							<ul>
                  <?php
                      $compte=1;
                      foreach ($app->getTable('Typeprojet')->all('id', 1) as $typep) {
                          if ($compte==1)
                              echo '<li class="active" data-filter=".' . $typep->datafilter . '">
                                  <span>'.$app->getTable('Appartenir')->getNbr($typep->id)->nbr.'</span>
                                  <i class="' . $typep->lien . '"></i>'. $typep->nom . '
                                  </li>';
                          else
                              echo '<li data-filter=".' . $typep->datafilter . '">
                                  <span>'.$app->getTable('Appartenir')->getNbr($typep->id)->nbr.'</span>
                                  <i class="' . $typep->lien . '"></i>'. $typep->nom . '
                                  </li>';
                          $compte++;
                      }
                  ?>
							</ul>

						</div>
						<!--/ End portfolio Nav -->
					</div>
				</div>

				<div class="portfolio-inner">
					<div class="row stylex">
						<div class="isotop-active">
                <?php
                    foreach ($app->getTable('Projet')->thelast(9) as $projet) {
                        $chaine='';
                        if($app->getTable('Projet')->findattr('image', $projet->id)->image=='1'){
                        foreach ($app->getTable('Projet')->getNomParent($projet->id) as $lepro) {
                                 $chaine .= $lepro->datafilter;
                                $chaine .=' ';
                            }
                        $chaine .="col-md-4 col-sm-6 col-xs-12 col-fix ";
                        echo'<div class="'.$chaine.'">
                                <div class="portfolio-single">
                                    <div class="portfolio-head">
                                        <img src="'.$app->getTable('Projet')->getPp($projet->id)->lien.'" alt=""/>
                                    </div>
                                    <div class="portfolio-hover">
                                        <h4><span>'.$app->getTable('Projet')->getTypeProjet($projet->id)->nom.'</span><a href="#">'.$projet->nom.'</a></h4>
                                        <p>'.substr($projet->description, 0, 100).'...</p>
                                        <div class="button">
                                            <a data-fancybox="gallery" href="'.$app->getTable('Projet')->getPp($projet->id)->lien.'"><i class="fa fa-search"></i></a>
                                            <a href="'.$projet->getUrl().'" class="primary"><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>';}
                    }
                ?>
						</div>
					</div>
				</div>
				<div class="row">
					<!-- Button -->
					<div class="button">
						<a href="portfolio.php" class="btn">More Portfolio<i class="fa fa-angle-double-right"></i></a>
					</div>
					<!-- End Button -->
				</div>
			</div>
		</section>
		<!--/ End portfolio -->

		<!-- Start Count Down -->
		<section id="countdown" class="section" data-stellar-background-ratio="0.3">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.4s">
						<!-- Single Count -->
						<div class="single-count">
							<i class="fa fa-tasks"></i>
							<h2><span class="count"><?=$app->getTable('Projet')->compte()->tot;?></span></h2>
							<p>Projects Finished</p>
						</div>
						<!--/ End Single Count -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.6s">
						<!-- Single Count -->
						<div class="single-count">
							<i class="fa fa-users"></i>
							<h2><span class="count">183</span></h2>
							<p>Happy Clients</p>
						</div>
						<!--/ End Single Count -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.8s">
						<!-- Single Count -->
						<div class="single-count active">
							<i class="fa fa-clock-o"></i>
							<h2><span class="count">2,720</span></h2>
							<p>Hours Worked</p>
						</div>
						<!--/ End Single Count -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="1s">
						<!-- Single Count -->
						<div class="single-count">
							<i class="fa fa-coffee"></i>
							<h2><span class="count">122</span></h2>
							<p>Cups of Coffee</p>
						</div>
						<!--/ End Single Count -->
					</div>
				</div>
			</div>
		</section>
		<!--/ End Count Down -->

		<!-- Start Timeline-->
		<section id="my-timeline" class="section clearfix">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-title">
							<h1><span>Events </span><i class="fa fa-history"></i></h1>
							<p>Our event<p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="timeline">
							<div class="timeline-inner">
                <!-- Single Timeline -->
                <?php
                    foreach ($app->getTable('Evenement')->all('datepub')  as $event) {
                        echo'<div class="single-main wow fadeInLeft" data-wow-delay="0.4s">
                                <div class="single-timeline">
                                    <div class="single-content">
                                        <div class="date">
                                            <p>'. App::mois($app->getTable('Evenement')->extractAttr("m", $event->id, "datepub")->m) .
                                            '<span>'.
                                                $app->getTable('Evenement')->extractAttr("j", $event->id, "datepub")->j .
                                            '</span></p>
                                        </div>
                                        <h2>'.$event->nom.'</h2>
                                        <p>'.$event->description.'<p>
                                        <p>'.$app->getTable('Evenement')->extractAttr("a", $event->id, "datepub")->a.'<p>
                                    </div>
                                </div>
                            </div>';
                    }
                ?>
								<!--/ End Single Timeline -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/ End Timeline -->

		<!-- Start Pricing Table -->
		<section id="pricing" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-title">
							<h1><span>Service</span> Price<i class="fa fa-star"></i></h1>
							<p>The cost of our services<p>
						</div>
					</div>
				</div>
				<div class="row">
            <div class="col-md-12 col-sm-8 col-xs-12">
				        <div class="portfolio-related">
                  <!-- Single Table -->
                  <div class="col-sm-12 col-xs-12 wow fadeIn" data-wow-delay="0.4s">
                      <div class="single-table">
                          <!-- Table Head -->
                          <div class="table-head">
                              <h2 class="title">Reading class</h2>
                              <i class="fa fa-gift"></i>
                          </div>
                          <div class="clearfix"></div>
                          <!-- Table List -->
                          <ul class="table-list">
                              <table class="col-md-12" style=" text-align: center; background-color: transparent;" border="1">
                                  <thead>
                                      <tr>
                                          <td><h4>Level</h4></td>
                                          <td><h4>Hours</h4></td>
                                          <td><h4>Research</h4></td>
                                      </tr>
                                  </thead>
                                  <tr>
                                      <td>Beginner</td>
                                      <td rowspan="3">12H</td>
                                      <td rowspan="3">05 hours of researches, private interviews, assignments, Groups discussions every week, Powered by American System.</td>
                                  </tr>
                                  <tr>
                                      <td>Medium</td>
                                  </tr>
                                  <tr>
                                      <td>Expert</td>
                                  </tr>
                              </table>
                              <div class="clearfix"></div>
                          </ul>
                          <!-- Table Bottom -->
                          <div class="table-bottom">
                              <a class="btn shine" target="_blank"  href="https://goo.gl/forms/fFORuWWoG9JuB2In1">ENROLL NOW<i class="fa fa-angle-right"></i></a>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Table-->
                  <!-- Single Table -->
                  <div class="col-sm-12 col-xs-12 wow fadeIn" data-wow-delay="0.4s">
                      <div class="single-table active">
                          <!-- Table Head -->
                          <div class="table-head">
                              <h2 class="title">Listening & Speaking</h2>
                              <i class="fa fa-gift"></i>
                          </div>
                          <div class="clearfix"></div>
                          <!-- Table List -->
                          <ul class="table-list">
                              <table class="col-md-12" style=" text-align: center; background-color: transparent;" border="1">
                                  <thead>
                                      <tr>
                                          <td><h4>Level</h4></td>
                                          <td><h4>Hours</h4></td>
                                          <td><h4>Research</h4></td>
                                      </tr>
                                  </thead>
                                  <tr>
                                      <td>Beginner</td>
                                      <td rowspan="3">20H</td>
                                      <td rowspan="3">05 hours of researches, private interviews, assignments, Groups discussions every week, Powered by American System.</td>
                                  </tr>
                                  <tr>
                                      <td>Medium</td>
                                  </tr>
                                  <tr>
                                      <td>Expert</td>
                                  </tr>
                              </table>
                              <div class="clearfix"></div>
                          </ul>
                          <!-- Table Bottom -->
                          <div class="table-bottom">
                              <a class="btn shine"  target="_blank" href="https://goo.gl/forms/fFORuWWoG9JuB2In1">ENROLL Now<i class="fa fa-angle-right"></i></a>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Table-->
                  <!-- Single Table -->
                  <div class="col-sm-12 col-xs-12 wow fadeIn" data-wow-delay="0.4s">
                      <div class="single-table">
                          <!-- Table Head -->
                          <div class="table-head">
                              <h2 class="title">Writing class</h2>
                              <i class="fa fa-gift"></i>
                          </div>
                          <div class="clearfix"></div>
                          <!-- Table List -->
                          <ul class="table-list">
                              <table class="col-md-12" style=" text-align: center; background-color: transparent;" border="1">
                                  <thead>
                                      <tr>
                                          <td><h4>Level</h4></td>
                                          <td><h4>Hours</h4></td>
                                          <td><h4>Research</h4></td>
                                      </tr>
                                  </thead>
                                  <tr>
                                      <td>Beginner</td>
                                      <td rowspan="3">12H</td>
                                      <td rowspan="3">05 hours of researches, private interviews, assignments, Groups discussions every week, Powered by American System.</td>
                                  </tr>
                                  <tr>
                                      <td>Medium</td>
                                  </tr>
                                  <tr>
                                      <td>Expert</td>
                                  </tr>
                              </table>
                              <div class="clearfix"></div>
                          </ul>
                          <!-- Table Bottom -->
                          <div class="table-bottom">
                              <a class="btn shine" target="_blank"  href="https://goo.gl/forms/fFORuWWoG9JuB2In1">ENROLL NOW<i class="fa fa-angle-right"></i></a>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Table-->
                  <!-- Single Table -->
                  <div class="col-sm-12 col-xs-12 wow fadeIn" data-wow-delay="0.4s">
                      <div class="single-table active">
                          <!-- Table Head -->
                          <div class="table-head">
                              <h2 class="title">Business English</h2>
                              <i class="fa fa-gift"></i>
                          </div>
                          <br>
                          <!-- Table List -->
                          <ul class="table-list">
                              <table class="col-md-12" style=" text-align: center; background-color: transparent;" border="1">
                                  <thead>
                                      <tr>
                                          <td><h4>Mode</h4></td>
                                          <td><h4>Hours</h4></td>
                                          <td><h4>Cost</h4></td>
                                      </tr>
                                  </thead>
                                  <tr>
                                      <td>Express</td>
                                      <td>32H</td>
                                      <td>160.000fcfa</td>
                                  </tr>
                                  <tr>
                                      <td>Regular</td>
                                      <td>48H</td>
                                      <td>192.000fcfa</td>
                                  </tr>
                                  <tr>

                                  </tr>

                              </table>
                              <div class="clearfix"></div>
                              <p>Powered by American System.</p>
                              <div class="clearfix"></div>
                          </ul>
                          <!-- Table Bottom -->
                          <div class="table-bottom">
                              <a class="btn shine" target="_blank"  href="https://goo.gl/forms/fFORuWWoG9JuB2In1">ENROLL Now<i class="fa fa-angle-right"></i></a>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Table-->
                  <!-- Single Table -->
                  <div class="col-sm-12 col-xs-12 wow fadeIn" data-wow-delay="0.4s">
                      <div class="single-table">
                          <!-- Table Head -->
                          <div class="table-head">
                              <h2 class="title">TOEFL</h2>
                              <i class="fa fa-gift"></i>
                          </div>
                          <br>
                          <!-- Table List -->
                          <ul class="table-list">
                              <table class="col-md-12" style=" text-align: center; background-color: transparent;" border="1">
                                  <thead>
                                      <tr>
                                          <td><h4>Mode</h4></td>
                                          <td><h4>Hours</h4></td>
                                          <td><h4>Cost</h4></td>
                                      </tr>
                                  </thead>
                                  <tr>
                                      <td>Master Express</td>
                                      <td>24H</td>
                                      <td>144.000fcfa</td>
                                  </tr>
                                  <tr>
                                      <td>Express</td>
                                      <td>32H</td>
                                      <td>160.000fcfa</td>
                                  </tr>
                                  <tr>
                                      <td>Regular</td>
                                      <td>48H</td>
                                      <td>192.000fcfa</td>
                                  </tr>
                              </table>
                          </ul>
                              <div class="clearfix"></div>
                          <!-- Table Bottom -->
                          <div class="table-bottom">
                              <a class="btn shine" target="_blank"  href="https://goo.gl/forms/fFORuWWoG9JuB2In1">ENROLL Now<i class="fa fa-angle-right"></i></a>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Table-->
                  <!-- Single Table -->
                  <div class="col-sm-12 col-xs-12 wow fadeIn" data-wow-delay="0.4s">
                      <div class="single-table active">
                          <!-- Table Head -->
                          <div class="table-head">
                              <h2 class="title">IELTS</h2>
                              <i class="fa fa-gift"></i>
                          </div>
                          <br>
                          <!-- Table List -->
                          <ul class="table-list">
                              <table class="col-md-12" style=" text-align: center; background-color: transparent;" border="1">
                                  <thead>
                                      <tr>
                                          <td><h4>Mode</h4></td>
                                          <td><h4>Hours</h4></td>
                                          <td><h4>Cost</h4></td>
                                      </tr>
                                  </thead>
                                  <tr>
                                      <td>Express</td>
                                      <td>32H</td>
                                      <td>192.000fcfa</td>
                                  </tr>
                                  <tr>
                                      <td>Regular</td>
                                      <td>42H</td>
                                      <td>200.000fcfa</td>
                                  </tr>
                              </table>

                              <p>Powered by American System.</p>
                              <div class="clearfix"></div>
                          </ul>
                          <!-- Table Bottom -->
                          <div class="table-bottom">
                              <a class="btn shine"  target="_blank" href="https://goo.gl/forms/fFORuWWoG9JuB2In1">ENROLL Now<i class="fa fa-angle-right"></i></a>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Table-->
                  <!-- Single Table -->
                  <div class="col-sm-12 col-xs-12 wow fadeIn" data-wow-delay="0.4s">
                      <div class="single-table">
                          <!-- Table Head -->
                          <div class="table-head">
                              <h2 class="title">GRE</h2>
                              <i class="fa fa-gift"></i>
                          </div>
                          <br>
                          <!-- Table List -->
                          <ul class="table-list">
                              <table class="responsive col-md-12" style=" text-align: center; background-color: transparent;" border="1">
                                  <thead>
                                      <tr>
                                          <td><h4>Mode</h4></td>
                                          <td><h4>Hours</h4></td>
                                          <td><h4>Cost</h4></td>
                                      </tr>
                                  </thead>
                                  <tr>
                                      <td>Express</td>
                                      <td>40H</td>
                                      <td>160.000fcfa</td>
                                  </tr>
                                  <tr>
                                      <td>Regular</td>
                                      <td>60H</td>
                                      <td>192.000fcfa</td>
                                  </tr>
                              </table>
                              <p>Powered by American System.</p>
                              <div class="clearfix"></div>
                          </ul>
                          <!-- Table Bottom -->
                          <div class="table-bottom">
                              <a class="btn shine" target="_blank"  href="https://goo.gl/forms/fFORuWWoG9JuB2In1">ENROLL Now<i class="fa fa-angle-right"></i></a>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Table-->
                  <!-- Single Table -->
                  <div class="col-sm-12 col-xs-12 wow fadeIn" data-wow-delay="0.4s">
                      <div class="single-table active">
                          <!-- Table Head -->
                          <div class="table-head">
                              <h2 class="title">GMAT</h2>
                              <i class="fa fa-gift"></i>
                          </div>
                          <br>
                          <!-- Table List -->
                          <ul class="table-list">
                              <table class="responsive col-md-12" style=" text-align: center; background-color: transparent;" border="1">
                                  <thead>
                                      <tr>
                                          <td><h4>Mode</h4></td>
                                          <td><h4>Hours</h4></td>
                                          <td><h4>Cost</h4></td>
                                      </tr>
                                  </thead>
                                  <tr>
                                      <td>Express</td>
                                      <td>40H</td>
                                      <td>160.000fcfa</td>
                                  </tr>
                                  <tr>
                                      <td>Regular</td>
                                      <td>60H</td>
                                      <td>192.000fcfa</td>
                                  </tr>
                              </table>
                              <p>Powered by American System.</p>
                              <div class="clearfix"></div>
                          </ul>
                          <!-- Table Bottom -->
                          <div class="table-bottom">
                              <a class="btn shine"  target="_blank" href="https://goo.gl/forms/fFORuWWoG9JuB2In1">ENROLL Now<i class="fa fa-angle-right"></i></a>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Table-->
              </div>
          </div>
				</div>
			</div>
		</section>
		<!--/ End Pricing Table -->

		<!-- Start Testimonials -->
		<section id="testimonials" class="section" data-stellar-background-ratio="0.3">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-title">
							<h1><span>Clients</span> Testimonials<i class="fa fa-commenting"></i></h1>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="testimonial-carousel">
							<!-- Single Testimonial -->
							<div class="single-testimonial">
								<div class="testimonial-content">
									<i class="fa fa-quote-left"></i>
									<p>All in one Benin is a good training center. Thanks to them I have a good command of English</p>
								</div>
								<div class="testimonial-info">
									<img src="images/users.png" class="img-circle" alt="">
									<ul class="rating">
										<li><i class="fa fa-star"></i></li>
										<li><i class="fa fa-star"></i></li>
										<li><i class="fa fa-star"></i></li>
										<li><i class="fa fa-star"></i></li>
										<li><i class="fa fa-star"></i></li>
									</ul>
									<h6>Jules Boko<span>Learner</span></h6>
								</div>
							</div>
							<!--/ End Single Testimonial -->
							<!-- Single Testimonial -->
							<div class="single-testimonial">
								<div class="testimonial-content">
									<i class="fa fa-quote-left"></i>
									<p>All in one Benin did my website. No repproch to do. Amazing!!</p>
								</div>
								<div class="testimonial-info">
									<img src="images/users.png" class="img-circle" alt="">
									<ul class="rating">
										<li><i class="fa fa-star"></i></li>
										<li><i class="fa fa-star"></i></li>
										<li><i class="fa fa-star"></i></li>
										<li><i class="fa fa-star"></i></li>
										<li><i class="fa fa-star"></i></li>
									</ul>
									<h6>Paul GUY<span>Client</span></h6>
								</div>
							</div>
							<!--/ End Single Testimonial -->
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/ End Testimonials -->

		<!-- Start Blog -->
		<section id="blog" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-title">
							<h1><span>Latest</span> Blog<i class="fa fa-pencil"></i></h1>
							<p>Our latest blog<p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="blog-carousel">
							<!-- Single Blog -->
              <?php
                  foreach ($app->getTable('Article')->last(6) as $article) {
                      echo'<div class="single-blog">
                                  <div class="blog-head">
                                      <img src="'.$article->lien.'" alt=""  class="img-responsive">
                                      <div class="blog-link">
                                          <a href="'.$article->getUrl().'"><i class="fa fa-link"></i></a>
                                      </div>
                                  </div>
                                  <div class="blog-info">
                                      <div class="date">
                                          <div class="day"><span>'.App::jour($app->getTable('Article')->extractAttr("j", $article->id, "datepub")->j).'</span>'.App::mois($app->getTable('Article')->extractAttr("m", $article->id, "datepub")->m).'</div>
                                          <div class="year">'.$app->getTable('Article')->extractAttr("a", $article->id, "datepub")->a.'</div>
                                      </div>
                                      <h2><a href="'.$article->getUrl().'">'.$article->nom.'</a></h2>
                                      <div class="meta">
                                          <span><i class="fa fa-user"></i>By '.$article->author.'</span>
                                          <span><i class="fa fa-comments"></i>'.$app->getTable('Article')->getNbrCom($article->id)->nbr.'</span>
                                          <span><i class="fa fa-eye"></i>'.$article->nombrevue.'</span>
                                      </div>
                                      <p>'.substr($article->description, 0, 110).'...</p>
                                      <a href="'.$article->getUrl().'" class="btn">Read more<i class="fa fa-angle-double-right"></i></a>
                                  </div>
                          </div>';
                  }
              ?>
							<!--/ End Single Blog -->
						</div>
					</div>
				</div>
				<div class="row">
					<!-- Button -->
					<div class="button">
						<a href="article.php" class="btn" >More Blog<i class="fa fa-angle-double-right"></i></a>
					</div>
					<!-- End Button -->
				</div>
			</div>
		</section>
		<!--/ End Blog -->

		<!-- Start Contact -->
		<section id="contact" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-title">
							<h1><span>Contact</span> Us<i class="fa fa-address-book"></i></h1>
							<p>Please fill in the form below to contact us<p>
						</div>
					</div>
				</div>
				<div class="row">
					<!-- Contact Form -->
					<div class="col-md-6 col-sm-6 col-xs-12 wow fadeInLeft" data-wow-delay="0.4s">
						<form class="form" method="post" action="">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" id="nomm" name="name"
                    <?php
                    if($auth->logged())
                        echo 'value="' . $app->getTable('Utilisateur')->findattr('nom', $user_id)->nom . ' ' . $app->getTable('Utilisateur')->findattr('prenom', $user_id)->prenom .'"';
                    else
                        echo '" placeholder="Full Name"';
                     ?>
                    required="required">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="email" name="email"
                      <?php
                      if($auth->logged())
                          echo 'value="' . $app->getTable('Utilisateur')->findattr('mail', $user_id)->mail .'"';
                      else
                          echo '" placeholder="Your Email"';
                       ?> required="required">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<textarea name="message" rows="6" placeholder="Type Your Message Here" required></textarea>
									</div>
								</div>
								<div class="col-md-12">
                    <div class="col-md-6">
    									<div class="form-group button">
    										<button type="submit" name="contact" class="button primary"><i class="fa fa-send"></i>Submit</button>
    									</div>
                    </div>
                    <div class="col-md-6">
                        <?php
                        if (isset($_POST['contact']))
                        {
                            if($result)
                            {
                                echo $result;
                            }
                        }
                    ?>
                    </div>
                </div>
							</div>
						</form>
					</div>
					<!--/ End Contact Form -->
					<!-- Contact Address -->
					<div class="col-md-6 col-sm-6 col-xs-12 wow fadeInRight" data-wow-delay="0.8s">
						<div class="contact">
							<!-- Single Address -->
							<div class="single-address">
								<i class="fa fa-phone"></i>
								<div class="title">
									<h4>Our Phone</h4>
									<p>+229 62-55-24-13,<br>+229 95-88-89-64</p>
								</div>
							</div>
							<!--/ End Single Address -->
							<!-- Single Address -->
							<div class="single-address">
								<i class="fa fa-envelope"></i>
								<div class="title">
									<h4>Email Address</h4>
									<p>info@allinone-benin.com</p>
								</div>
							</div>
							<!--/ End Single Address -->
							<!-- Single Address -->
							<div class="single-address">
								<i class="fa fa-map"></i>
								<div class="title">
									<h4>Our Location</h4>
									<p>1st street right after Pharmacy Houeyiho,
                                       Lot 1093- Villa Awussi,
                                    <br>Cotonou, Littoral, Benin</p>
								</div>
							</div>
							<!--/ End Single Address -->
						</div>
					</div>
					<!--/ End Contact Address -->
				</div>
			</div>
		</section>
		<!--/ End Contact -->
