<?php
  use Core\Auth\DBAuth;
  $message='';
    //Auth
    $app=App::getInstance();
    $auth = new DBAuth($app->getDb());
    $article = $app->getTable('Article')->find($_GET['id']);
    if ($article===false)
    {
        $app->notFound();
    }
    $article_id=$_GET['id'];
    $lapage="article.php?p=article&id=".$article_id;
    if($auth->logged())
    {
        $user_id = $auth->getUserId();
        if($app->getTable("Likes")->verify($article_id, $user_id)->liker==0) $couleur='#1C1C1C';
        elseif($app->getTable("Likes")->verifyetat($article_id, $user_id)->liker==0) $couleur='#1C1C1C';
        else $couleur='#F2784B';
        //var_dump($user_id);
    }
    else{
      $couleur='#1C1C1C';
    }
    if(isset($_POST['comment'])){
      $app->getTable('Commentaires')->create([
        'article_id' => $article_id,
        'utilisateur_id' => $user_id,
        'contenu'=>$_POST['contenu']
        ]);
    }
    if(isset($_POST['likes'])){
      if($auth->logged()){
        //si j'aime
        if($couleur=='#F2784B')
        {
          $app->getTable('Likes')->update([
            'utilisateur_id' =>  $user_id,
            'article_id' => $article_id
          ],[
            'etat'=>'0'
            ]);
            header('Location: '.$lapage);
        }
        else {
          if($app->getTable("Likes")->verifyetat($article_id, $user_id)->liker==0
          && $app->getTable("Likes")->verify($article_id, $user_id)->liker==0)
          {
            $app->getTable('Likes')->create([
              'article_id' => $article_id,
              'utilisateur_id' => $user_id,
              'etat'=>'1'
              ]);
              header('Location: '.$lapage);
          }
          else{
            $app->getTable('Likes')->update([
              'utilisateur_id' =>  $user_id,
              'article_id' => $article_id
            ],[
              'etat'=>'1'
              ]);
              header('Location: '.$lapage);
          }

        }
      }

      else $message='Vous devez être connecté pour aimer un article';
    }

    $vue=$app->getTable('Article')->findattr('nombrevue', $article->id)->nombrevue;
    $vue++;
        $app->getTable('Article')->update([
          'id'=>$article->id
          ], [
          'nombrevue' => $vue]);


?>
<!-- Start Blog -->
    <section id="blog" class="section archive single">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <!-- Single Blog -->
                            <div class="single-blog">
                                <div class="blog-head">
                                    <img src="<?=$article->lien;?>" alt="" class="img-responsive">
                                </div>
                                <div class="blog-info">

                                    <div class="date">
                                        <div class="day"><span><?=App::jour($app->getTable('Article')->extractAttr("j", $article->id, "datepub")->j)?></span>
                                            <?=App::mois($app->getTable('Article')->extractAttr("m", $article->id, "datepub")->m)?></div>
                                        <div class="year"><?=$app->getTable('Article')->extractAttr("a", $article->id, "datepub")->a?></div>
                                    </div>
                                    <h2><?=$article->nom;?></h2>
                                    <div class="meta">
                                    <span><i class="fa fa-user"></i>By <?=$article->author?></span>
                                        <span><i class="fa fa-comments"></i><?=$app->getTable('Article')->getNbrCom($article->id)->nbr?></span>
                                        <span><i class="fa fa-eye"></i><?=$article->nombrevue?></span>
                                    </div>
                                    <div style="text-align:justify;">
                                        <?=$article->description?>
                                    </div>

                                </div>
                                <div class="blog-bottom">
                                    <!-- Next Prev -->
                                    <div class="prev-next">
                                        <ul>
                                            <li class="prev">
                                                <a href="article.php?p=article&id=<?=$article->id-1;?>">
                                                    <i class="fa fa-angle-double-left"></i>
                                                </a>
                                            </li>
                                            <li class="next">
                                                <a href="article.php?p=article&id=<?=$article->id+1;?>">
                                                    <i class="fa fa-angle-double-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--/ End Next Prev -->
                                    <form action="" method="post">
                                      <div style="top:10px;" class="input-group">
                                          <button type="submit" name="likes" style="color:white;
                                           background-color:<?=$couleur?>" class="btn btn-primary btn-flat">
                                            <?=$app->getTable('Likes')->comptelike($article->id)->tot?>
                                            <i class="fa fa-thumbs-o-up"></i>
                                          </button>
                                          <?php
                                          if(isset($_POST['likes'])){
                                            if($message) echo'<div class="alert alert-danger" style="display: inline-block;">'.$message.'</div>';
                                          }
                                           ?>
                                      </div>
                                    </form>
                                    <!-- <div class="blog-share">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                            <!--/ End Single Blog -->
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="blog-comments">
                                <div class="comments-body">
                                    <div class="b-title">
                                        <h2>Latest Comments</h2>
                                    </div>
                                    <?php
                                        if ($app->getTable('Commentaires')->compteattr('article_id', $article->id)->tot == '0') echo '
                                        <p style="text-align: center">
                                            Soyez le premier à commenter!!
                                        </p>';
                                        foreach ($app->getTable('Commentaires')->allwhere('article_id', $article->id, 'datepub') as $comment) {
                                            echo'
                                                <div class="single-comments">
                                                    <div class="main">
                                                        <div class="head">
                                                            <img src="'.$app->getTable('Utilisateur')->findattr('lien', $comment->utilisateur_id)->lien.'" alt="#"/>
                                                        </div>
                                                        <div class="body">
                                                            <h4>'.$app->getTable('Utilisateur')->findattr('nom', $comment->utilisateur_id)->nom.'</h4>
                                                            <p class="meta">'.$comment->datepub.'</p>
                                                            <p>'.$comment->contenu.'</p>
                                                            <a href="#"><i class="fa fa-mail-forward"></i>replay</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                        }
                                        if($auth->logged())
                                        {
                                          echo'
                                          <form action="" method="post">
                                          <div class="input-group">
                                            <input type="text" name="contenu" placeholder="Type comment ..." class="form-control">
                                                <span style="background-color:#e0e0e0; padding:5px;" class="input-group-btn">
                                                  <button type="submit" name="comment" class="btn btn-primary btn-flat">Send</button>
                                                </span>
                                          </div>
                                          </form>
                                          ';
                                        }else {
                                          echo '
                                          <div class="button">
                                              <a href="" data-toggle="modal" data-target="#myModal" class="btn"><i class="fa fa-exclamation-triangle"></i>login to comment</a>
                                          </div>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                        $chaine = '';
                                        $chaine.=App::mois($app->getTable('Article')->extractAttr('m',$popu->id, "datepub")->m, 1) . ' ';
                                        $chaine.=App::jour($app->getTable('Article')->extractAttr('j',$popu->id, "datepub")->j) . ',';
                                        $chaine.=$app->getTable('Article')->extractAttr('a',$popu->id, "datepub")->a;
                                        echo'
                                        <div class="single-post">
                                            <div class="post-img">
                                                <img src="'.$popu->lien.'" alt=""/>
                                            </div>
                                            <div class="post-info">
                                                <h4><a href="'.$popu->getUrl().'">'.$popu->nom.'</a></h4>
                                                <p><i class="fa fa-clock-o"></i>'.
                                                    $chaine
                                                .'</p>
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
