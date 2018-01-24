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
  if(isset($_POST['modifier']))
  {
    //on initialise la variable update ok
    $uploadOk1 = 1;
    //répertoire de destination
    $target_dir1 = "uploads/posts/";
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
        $app->getTable('Article')->update([
          'id' =>  $id
          ], [
          'nom' => $_POST['nom'],
          'author' => $_POST['author'],
          'description' => $_POST['description'],
          'categorie_id' => $_POST['categorie_id'],
          'lien' => $cheminFile,
          'user'=>$lid,
          'employe_id'=>$lid
          ]);
        $result="<div class='alert alert-success'>L'article a bien été modifié</div>";
      }
      else
      {
        $result="<div class='alert alert-danger'>Désolé, nous avons rencontre un problème lors du téléchargement de votre photo veuillez recommencer</div>";
      }
    }
  }
?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="admin.php?p=posts"><i class="fa fa-file"></i>Posts</a></li>
        <li class="active">Post Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-6">
          <div class="box box-solid box-default">
            <div class="box-header">
              <i name="iconefor" class="glyphicon glyphicon-pencil"></i>

              <h3 class="box-title">Edit</h3>
            </div>
            <div class="box-body">
              <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="text" class="form-control" name="nom" placeholder="Title:"
                  value="<?=$app->getTable('Article')->findattr('nom', $id)->nom?>">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="author" placeholder="Author:"
                  value="<?=$app->getTable('Article')->findattr('author', $id)->author?>">
                </div>
                <div class="form-group">
                  <label>Categories:</label>
                  <select name="categorie_id" class="form-control select2" style="width: 100%;">
                    <?php
                      echo '<option value='.$app->getTable('Categorie')->findattr('id', $app->getTable('Article')->findattr('categorie_id', $id)->categorie_id)->id .'selected="selected">'.
                        $app->getTable('Categorie')->findattr('nom', $app->getTable('Article')->findattr('categorie_id', $id)->categorie_id)->nom
                      .'</option>';
                      foreach($app->getTable('Categorie')->all(1) as $category)
                      {
                        if ($category->nom!=$app->getTable('Categorie')->findattr('nom', $app->getTable('Article')->findattr('categorie_id', $id)->categorie_id)->nom)
                        echo '<option value='.$category->id.'>'.$category->nom.'</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <textarea class="textarea" name="description" placeholder="Description :" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                      <?=$app->getTable('Article')->findattr('description', $id)->description?>
                  </textarea>
                </div>
                <div class="form-group">
                  <div class="">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                    <div>
                        <span class="btn btn-file btn-primary">
                          <span class="fileupload-new">Select image</span>
                          <span class="fileupload-exists">Change</span>
                          <input name="file" type="file" accept=".jpg, .jpeg, .png" ></span>
                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
              </div>
                </div>
                <div class="box-footer clearfix">
                  <?php
                    if(isset($_POST['modifier']))
                    {
                      if($result)
                      {
                        echo "<div class='alert alert-success'>L'article a bien été modifié</div>";
                      }
                    }
                  ?>
                  <button type="submit" class="pull-right btn btn-default" name="modifier">Update
                    <i style="color: #f39c12" class="fa fa-pencil"></i></button>
                </div>
              </form>
            </div>

          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Stats</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post" style="height: 400px">
                  <div class="row container container-center" style="padding-top:20px">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-eye"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Views</span>
                          <span class="info-box-number"><?=$app->getTable('Article')->findattr('nombrevue', $id)->nombrevue?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                  </div>
                  <div class="row container container-center" style="padding-top:20px">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-comments-o"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Comments</span>
                          <span class="info-box-number"><?=$app->getTable('Commentaires')->compteattr('article_id', $id)->tot?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <div class="row container container-center" style="padding-top:20px">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-thumbs-o-up"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Likes</span>
                          <span class="info-box-number"><?=$app->getTable('Likes')->compteattr('article_id', $id)->tot?></span>
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
