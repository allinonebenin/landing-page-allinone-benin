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
  if(isset($_POST['update']))
  {
    $ancienmp = $app->getTable('Employe')->findattr('password', $id)->password;
    if($ancienmp==sha1($_POST['amotdepasse']))
    {
      if($_POST['motdepasse']==$_POST['cmotdepasse'])
      {
        if($_POST['choice']=='Default')
        {
          $app->getTable('Employe')->update([
            'id' =>  $id
            ], [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'mail' => $_POST['mail'],
            'password' => sha1($_POST['motdepasse']),
            'user'=>$lid
            ]);
          $result="<div class='alert alert-success'>L'employé a bien été modifié</div>";
        }
        else {
          //on initialise la variable update ok
          $uploadOk1 = 1;
          //répertoire de destination
          $target_dir1 = "uploads/employees/";
          $target_file1 = $target_dir1 . basename($_FILES["file"]["name"]);
          $cheminFile=$target_file1;
          //on recup l'extention du fichier
          $imageFileType1 = pathinfo($target_file1,PATHINFO_EXTENSION);
          // Check file size
          if ($_FILES["file"]["size"] > 50331648)
          {
            $result="<div class='alert alert-danger'>Désolé, votre photo est trop grande</div>";
            $uploadOk1 = 0;
          }
          // Check if $uploadOk is set to 0 by an error
          if ($uploadOk1 == 0)
          {
            $result="<div class='alert alert-danger'>Désolé, nous avons rencontre un problème lors du téléchargement de votre photo veuillez recommencer</div>";
          // if everything is ok, try to upload file
          }
          else
          {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file1))
            {
              $app->getTable('Employe')->update([
                'id' =>  $id
                ], [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'mail' => $_POST['mail'],
                'password' => sha1($_POST['motdepasse']),
                'user'=>$lid,
                'lien'=>$cheminFile
                ]);
              $result="<div class='alert alert-success'>L'employé a bien été ajouté</div>";
            }
            else
            {
              $result="<div class='alert alert-danger'>Désolé, nous avons rencontre un problème lors du téléchargement de votre photo veuillez recommencer</div>";
            }
          }
        }
      }
      else
      {
        $result="<div class='alert alert-danger'>Nouveaux mots de passes différents</div>";
      }
    }
    else
    {
      $result="<div class='alert alert-danger'>Ancien mot de passe incorrect</div>";
    }
  }
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="admin.php?p=employees"><i class="fa fa-user-secret"></i>Employees</a></li>
        <li class="active">Employee profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <div class="box box-solid box-default">
            <div class="box-body box-profile">
	          <form method="post" enctype="multipart/form-data">
	            <div class="form-group">
	              <input type="text" class="form-control" name="nom" placeholder="Nom:" value="<?=$app->getTable('Employe')->findattr('nom', $id)->nom?>" required>
	            </div>
	            <div class="form-group">
	              <input type="text" class="form-control" name="prenom" placeholder="Prenom:" value="<?=$app->getTable('Employe')->findattr('prenom', $id)->prenom?>" required>
	            </div>
	            <div class="form-group">
	              <input type="text" class="form-control" name="mail" placeholder="E-mail:" value="<?=$app->getTable('Employe')->findattr('mail', $id)->mail?>" required>
	            </div>
	            <div class="form-group">
	              <input type="password" class="form-control" name="amotdepasse" placeholder="Ancien mot de passe:" required>
	            </div>
	            <div class="form-group">
	              <input type="password" class="form-control" name="motdepasse" placeholder="Nouveau mot de passe:" required>
	            </div>
	            <div class="form-group">
	              <input type="password" class="form-control" name="cmotdepasse" placeholder="Confirmer mot de passe:" required>
	            </div>
              <label>Images :</label>
              <div class="form-group">
                <div class="col-xs-6 col-sm-3 col-md-4">
                  <label class="radio-inline">
                    <span><input id="choice" type="radio" name="choice" value="Default" onclick="hide('choisi')" checked></span> Don't change
                  </label>

                </div>
                <div class="col-xs-6 col-sm-3 col-md-4">
                  <label class="radio-inline">
                    <span><input id="choice" type="radio" name="choice" value="Choice" onclick="show('choisi')" required></span> Change
                  </label>
                </div>
              </div>
                <br>
	            <div class="form-group">
                <div id="choisi" style="display: none">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                    <div>
                        <span class="btn btn-file btn-primary"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" accept=".jpg, .jpeg, .png" ></span>
                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
              </div>
	            </div>
              <div class="box-footer clearfix">
                <?php
                  if(isset($_POST['update']))
                  {
                    if($result)
                    {
                      echo $result;
                    }
                  }
                ?>
	            <button type="submit" name="update" class="pull-right btn btn-default" id="enregistrer">Udpate
            	<i style="color: #f39c12" class="fa fa-pencil"></i></button>
              </div>
	          </form>


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
                        <span class="info-box-icon bg-blue"><i class="fa fa-file"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Posts</span>
                          <span class="info-box-number">
                            <?=$app->getTable('Article')->compteattr('employe_id', $id)->tot?>
                          </span>
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
                          <span class="info-box-number">
                            <?=$app->getTable('Employe')->nombreLike($id)->nbr?>
                          </span>
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
                          <span class="info-box-number">
                            <?=$app->getTable('Employe')->nombreComment($id)->nbr?>
                          </span>
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
                          <span class="info-box-number">
                            <?=$app->getTable('Employe')->findattr('nbrconn', $id)->nbrconn?>
                          </span>
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
                    foreach ($app->getTable('Article')->afficherwhere('employe_id', $id) as $article) {
                      echo'
                      <!-- timeline time label -->
                      <li class="time-label">
                            <span class="bg-red">
                              '.$article->j.' '.App::mois($article->m).'. '.$article->a. '
                            </span>
                      </li>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <li>
                        <i class="fa fa-file bg-aqua"></i>

                        <div class="timeline-item">

                          <h3 class="timeline-header"><strong style=" color: #f39c12">He/She</strong> post "
                          '.$article->nom.'" </h3>
                        </div>
                      </li>';
                    }
                  ?>

                  <!-- joined timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          <?=App::jour($app->getTable('Employe')->extractAttr('j', $id, 'datecreat')->j)
                          .' '.
                          App::mois($app->getTable('Employe')->extractAttr('m', $id, 'datecreat')->m)
                          .'. '.
                          $app->getTable('Employe')->extractAttr('a', $id, 'datecreat')->a?>
                        </span>
                  </li>
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
