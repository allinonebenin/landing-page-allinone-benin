<?php
    $app=App::getInstance();
    $lapage="article.php";
?>
        <!-- Start Blog -->
		<section id="blog" class="section archive grid-sidebar">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-sm-12 col-xs-12">
						<div class="row">
                            <?php
	                        $messagesParPage=4;
	                        $total=$app->getTable('Article')->compte()->tot;
	                        $nombreDePages=ceil($total/$messagesParPage);
	                        if(isset($_GET['page']))
	                        {
	                             $pageActuelle=intval($_GET['page']);

	                             if($pageActuelle>$nombreDePages)
	                             {
	                                  $pageActuelle=$nombreDePages;
	                             }
	                        }
	                        else
	                        {
	                             $pageActuelle=1;
	                        }
	                        $premiereEntree=($pageActuelle-1)*$messagesParPage;
                                foreach ($app->getTable('Article')->page($premiereEntree, $messagesParPage) as $article) {
                                    echo'<div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="single-blog">
                                                <div class="blog-head">
                                                    <img src="'.$article->lien.'" alt="" class="img-responsive">
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
                                                </div>
                                        </div>';
                                }
                            ?>
                        </div>
		                <?php
		                    //pagination
		                    echo '
		                    <div class="row">
		                        <div class="container container-center col-md-12">
		                        <!-- Start Pagination -->
		                            <ul class="pagination">';
		                                for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
		                                {
		                                    if($i==1)
		                                    {
		                                        if ($i==$pageActuelle)
		                                        {
		                                             echo '<li class="prev"><a href="#"><span class="fa fa-angle-left"></span>Prev</a></li>';
		                                        }
		                                        else
		                                        {
		                                            echo '<li class="prev"><a href="article.php?page='.($pageActuelle-1).'"><span class="fa fa-angle-left"></span>Prev</a></li>';
		                                        }

		                                    }
		                                    if($i==$pageActuelle) echo '<li class="active"><a href="#">'.$i.'</a></li>';
		                                    else echo '<li><a href="article.php?page='.$i.'">'.$i.'</a></li>';
		                                    if($i==$nombreDePages)
		                                    {
		                                        if ($nombreDePages==$pageActuelle)
		                                        {
		                                            echo '<li class="next"><a href="#">Next<span class="fa fa-angle-right"></span></a></li>';
		                                        }
		                                        else
		                                        {
		                                            echo '<li class="next"><a href="article.php?page='.($pageActuelle+1).'">Next<span class="fa fa-angle-right"></span></a></li>';
		                                        }

		                                    }
		                                }
		                            echo '
		                            </ul>
		                        <!--/ End Pagination -->
		                        </div>
		                    </div>';
		                ?>
					</div>

					<div class="col-md-4 col-sm-12 col-xs-12">
						<!-- News Sidebar -->
						<div class="blog-sidebar">
							<!-- Start Search Form -->
							<div class="single-sidebar form">
								<form class="search" action="#">
									<input type="text" placeholder="Type To Search">
									<div class="s-button">
										<button type="submit" class="btn">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</form>
							</div>
							<!--/ End Search Form -->
							<!-- Latest News -->
							<div class="single-sidebar latest">
								<h2>Popular Posts</h2>
                                <?php
                                    foreach ($app->getTable('Article')->popular() as $popu) {
                                        echo'
                                        <div class="single-post">
                                            <div class="post-img">
                                                <img src="'.$popu->lien.'" alt=""/>
                                            </div>
                                            <div class="post-info">
                                                <h4><a href="'.$popu->getUrl().'">'.$popu->nom.'</a></h4>
                                                <p><i class="fa fa-clock-o"></i>'.$popu->datepub.'</p>
                                            </div>
                                        </div>
                                        ';
                                    }
                                ?>
							</div>
							<!--/ End Latest News -->
							<!-- News Category -->
							<div class="single-sidebar category">
								<h2><span>Categorys</span></h2>
                                <ul>
                                <?php
                                    foreach($app->getTable('Categorie')->all() as $category)
                                    {
                                        if($app->getTable('Article')->compteattr("categorie_id",$category->id)->tot>0)
                                        {
                                            echo '
                                            <li>'.$category->nom.'
                                                <span>'.$app->getTable('Article')->compteattr("categorie_id",$category->id)->tot.'</span>
                                            </li>
                                            ';
                                        }
                                    }
                                ?>
								</ul>
							</div>
							<!--/ End News Category -->

							<!-- Blog Tags -->
							<!-- <div class="single-sidebar tags">
								<h2><span>Popular Tags</span></h2>
								<ul>
									<li><a href="#">HTML5</a></li>
									<li><a href="#">CSS3</a></li>
									<li><a href="#">Creative</a></li>
									<li><a href="#">Corporate</a></li>
									<li class="active"><a href="#">Responsive</a></li>
									<li><a href="#">Server Solutions</a></li>
								</ul>
							</div> -->
							<!--/ End News Category -->
						</div>
						<!--/ End News Sidebar -->
					</div>
				</div>
			</div>
		</section>
		<!--/ End Blog -->
