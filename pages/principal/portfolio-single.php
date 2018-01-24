<?php
    $app=App::getInstance();
    $projet = $app->getTable('Projet')->find($_GET['id']);
    if ($projet===false)
    {
        $app->notFound();
    }
    $lapage="portfolio.php?p=".$projet->id;
    // $ip=App::get_ip();

    // $bool=false;
    // foreach ($app->getTable('Vue_projet')->findip($ip, $projet->id) as $result) {
    //     if($ip===$result->utilisateur_ip) $bool=true;
    // }

    // if($bool==false)
    // {
    //     $app->getTable('Vue_projet')->create([
    //       'projet_id' => $projet->id,
    //       'utilisateur_ip' => $ip
    //       ]);
    // }
    $vue=$app->getTable('Projet')->findattr('nombrevue', $projet->id)->nombrevue;
    $vue++;
        $app->getTable('Projet')->update([
          'id'=>$projet->id
          ], [
          'nombrevue' => $vue]);
?>
<!-- Start portfolio -->
<section id="portfolio" class="section single">
    <div class="container">
        <div class="row">
            <!-- Single portfolio -->
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="portfolio-single slider">
                    <?php
                        foreach ($app->getTable('Projet')->allImages($_GET['id']) as $image) {
                            echo'<div class="single-slide">
                                    <img src="'.$image->lien.'" alt=""/>
                                </div>';
                        }
                    ?>
                </div>
            </div>
            <!--/ End portfolio -->
        </div>
        <div class="row">
            <!-- Portfolio Content -->
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="content">
                    <h2><?=$projet->nom?></h2>
                    <p><?=$projet->description?></p>
                </div>
            </div>
            <!--/ End portfolio Content -->
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="portfolio-widget">
                    <!-- Single Widget -->
                    <div class="single-widget">
                        <i class="fa fa-user"></i>
                        <h4>Customer</h4>
                        <a href="#"><?=$projet->client?></a>
                    </div>
                    <!--/ End Single Widget -->
                    <!-- Single Widget -->
                    <div class="single-widget">
                        <i class="fa fa-tags "></i>
                        <h4>Name</h4>
                        <a href="#"><?=$projet->nom?></a>
                    </div>
                    <!--/ End Single Widget -->
                    <!-- Single Widget -->
                    <div class="single-widget">
                        <i class="fa fa-calendar"></i>
                        <h4>date</h4>
                        <a href="#"><?=$projet->datepub?></a>
                    </div>
                    <!--/ End Single Widget -->
                    <!-- Single Widget -->
                    <div class="single-widget">
                        <i class="fa fa-globe"></i>
                        <h4>Website</h4>
                        <a target="_blank" href="http://<?=$projet->lien?>"><?=$projet->lien?></a>
                   </div>
                    <!--/ End Single Widget -->
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Portfolio Content -->
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="content">
                    <h2>Related projects</h2>
                </div>
            </div>
            <!--/ End portfolio Content -->
            <div class="col-md-12 col-sm-8 col-xs-12">
                <div class="portfolio-related">
                    <?php
                        foreach ($app->getTable('Projet')->sameProject($app->getTable('Projet')->getTypeProjet($_GET['id'])->id) as $projet) {

                            echo'<div class="portfolio-single">
                                        <div class="portfolio-head">
                                            <img src="'.$app->getTable('Projet')->getPp($projet->id)->lien.'" alt=""/>
                                        </div>
                                        <div class="portfolio-hover">
                                            <h4><span>'.$app->getTable('Projet')->getTypeProjet($projet->id)->nom.'</span><a href="#">'.$projet->nom.'</a></h4>
                                            <p>'.substr($projet->description, 0, 100).'...</p>
                                            <div class="button">
                                                <a data-fancybox="gallery" href="'.$app->getTable('Projet')->getPp($projet->id)->lien.'"><i class="fa fa-search"></i></a>
                                                <a href="portfolio.php?p=portfolio&id='.$projet->id.'" class="primary"><i class="fa fa-link"></i></a>
                                            </div>
                                        </div>
                                </div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End portfolio -->
