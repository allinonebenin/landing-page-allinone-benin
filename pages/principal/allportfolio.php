<?php
    $app=App::getInstance();
    $lapage="portfolio.php";
?>
<!-- Start portfolio -->
<section id="portfolio" class="section archive full">
    <div class="nav-bg">
        <div class="container">
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
        </div>
    </div>
    <div class="container-fluid">
        <div class="portfolio-inner">
            <div class="row stylex">
                <div class="isotop-active">
                    <?php
                        $messagesParPage=9;
                        $total=$app->getTable('Projet')->compte()->tot;
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
                        foreach ($app->getTable('Projet')->bypage($premiereEntree, $messagesParPage) as $projet) {
                            $chaine='';
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
                                  </div>';
                        }
                    ?>
                </div>
            </div>
            <div>
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
                                            echo '<li class="prev"><a href="portfolio.php?page='.($pageActuelle-1).'"><span class="fa fa-angle-left"></span>Prev</a></li>';
                                        }

                                    }
                                    if($i==$pageActuelle) echo '<li class="active"><a href="#">'.$i.'</a></li>';
                                    else echo '<li><a href="portfolio.php?page='.$i.'">'.$i.'</a></li>';
                                    if($i==$nombreDePages)
                                    {
                                        if ($nombreDePages==$pageActuelle)
                                        {
                                            echo '<li class="next"><a href="#"><span class="fa fa-angle-right"></span>Next</a></li>';
                                        }
                                        else
                                        {
                                            echo '<li class="next"><a href="portfolio.php?page='.($pageActuelle+1).'">Next<span class="fa fa-angle-right"></span></a></li>';
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
        </div>
    </div>
</section>
<!--/ End portfolio -->
