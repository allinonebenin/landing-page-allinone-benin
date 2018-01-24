<?php
  use Core\Auth\DBAuth;
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
    $match = false;
    //vérifier que id match
    $allemp=$app->getTable('Employe')->all();
    foreach ($allemp as $emp) {
      if($emp->id==$lid) $match=true;
    }
    if($match==false)
    {
      session_destroy();
      $app->forbidden();
    } 
  }
  $id=$_GET['id'];
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="admin.php?p=users"><i class="fa fa-user"></i>Users</a></li>
        <li class="active">User profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-solid box-default">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle"
              src="<?=$app->getTable('Utilisateur')->findattr('lien', $id)->lien?>" alt="User profile picture">

              <h3 class="profile-username text-center">
                <?=$app->getTable('Utilisateur')->findattr('nom', $id)->nom. ' '.
                $app->getTable('Utilisateur')->findattr('prenom', $id)->prenom?></h3>

              <p class="text-muted text-center"><a href="admin.php?p=compose&id=<?=$id?>">
                <?=$app->getTable('Utilisateur')->findattr('mail', $id)->mail?></a></p>
              <p class="text-muted text-center"><?=$app->getTable('Utilisateur')->findattr('datenais', $id)->datenais?></p>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Stats</a></li>
              <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post" style="height: 155px">
                  <div class="row" style="padding-top:20px">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-envelope-o"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Messages</span>
                          <span class="info-box-number"><?=$app->getTable('Messages')->compteattr('utilisateur_id', $id)->tot?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-thumbs-o-up"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Likes</span>
                          <span class="info-box-number"><?=$app->getTable('Likes')->compteattr('utilisateur_id', $id)->tot?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-comments-o"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Comments</span>
                          <span class="info-box-number"><?=$app->getTable('Commentaires')->compteattr('utilisateur_id', $id)->tot?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-pie-chart"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Connexion</span>
                          <span class="info-box-number"><?=$app->getTable('Utilisateur')->findattr('nbrconn', $id)->nbrconn?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                  </div>
                </div>
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <?php
                    foreach($app->getTable('Dateactivite')->afficher() as $date)
                    {
                      if($app->getTable('Activite')->comptewhere('dateactivite_id', $date->id, $id)->tot!=0)
                      {
                        echo'
                        <!-- timeline time label -->
                        <li class="time-label">
                              <span class="bg-red">
                                '.$date->j.' '.App::mois($date->m).'. '.$date->a. '
                              </span>
                        </li>
                        <!-- /.timeline-label -->
                        ';
                        foreach ($app->getTable('Activite')->afficherwhere('dateactivite_id', $date->id, $id) as $activity) {
                          echo'
                          <!-- timeline item -->
                          <li>';
                                if ($activity->likes_id)
                                {
                                  echo '<i class="fa fa-thumbs-o-up bg-aqua"></i>
                                  <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> '.App::ctrlDate($date).'</span>
                                    <h3 class="timeline-header">
                                    <strong style=" color: #f39c12">He/She</strong>
                                    liked the post "'.$app->getTable('Article')->findattr('nom', $activity->likes_id)->nom.'" </h3>
                                  </div>';
                                }
                                else
                                {
                                  echo '<i class="fa fa-comments-o bg-orange"></i>
                                  <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> '.App::ctrlDate($date).'</span>

                                    <h3 class="timeline-header"><strong style=" color: #f39c12">He/She</strong>
                                    comment the post "'.$app->getTable('Article')->findattr('nom', $activity->commentaires_id)->nom.'"</h3>

                                    <div class="timeline-body">
                                      '.$app->getTable('Commentaires')->getContenu($activity->utilisateur_id, $activity->commentaires_id)->contenu.'
                                    </div>
                                  </div>';
                                }
                          echo'</li>
                          <!-- END timeline item -->';
                        }
                      }
                    }
                  ?>

                  <!-- joined timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          <?=App::jour($app->getTable('Utilisateur')->extractAttr('j', $id, 'datecreat')->j)
                          .' '.
                          App::mois($app->getTable('Utilisateur')->extractAttr('m', $id, 'datecreat')->m)
                          .'. '.
                          $app->getTable('Utilisateur')->extractAttr('a', $id, 'datecreat')->a?>
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-blue"></i>

                    <div class="timeline-item">
                      <h3 class="timeline-header"><strong style=" color: #f39c12">He/She</strong> joined us</h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
