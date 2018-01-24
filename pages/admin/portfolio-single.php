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
  // var_dump();
  if(isset($_POST['modifier']))
  {
      if($_POST['choice']=='Default')
      {
        $app->getTable('Projet')->update([
            'id' =>  $id
            ], [
          'nom' => $_POST['nom'],
          'lien' => $_POST['lien'],
          'client' => $_POST['client'],
          'description' => $_POST['description'],
          'user'=>$lid
        ]);

        //appartenir
        $app->getTable('Appartenir')->update([
          'projet_id' => $id,
          'typeprojet_id' => $app->getTable('Projet')->getTypeProjet($id)->id
          ],[
          'typeprojet_id' => $_POST['typeprojet_id']
        ]);
        $result="<div class='alert alert-success'>Le portfolio a bien été modifié</div>";
      }
      else
      {
        //on initialise la variable update ok
      $uploadOk1 = 1;
      //répertoire de destination
      $target_dir1 = "uploads/portfolio/";
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
          //projet
          $app->getTable('Projet')->update([
                'id' =>  $id
                ], [
              'nom' => $_POST['nom'],
              'lien' => $_POST['lien'],
              'client' => $_POST['client'],
              'description' => $_POST['description'],
              'user'=>$lid
            ]);

          //image
          $oldidpp=$app->getTable('Image')->getIdPp($id)->id;
            //modification pp
            $app->getTable('Image')->update([
              'id'=>$oldidpp
            ],[
              'typeimage_id' => '2'
            ]);
            //enregistrement nouvelle pp
            $app->getTable('Image')->create([
              'nom' => $_POST['nom'],
              'typeimage_id' => '1',
              'projet_id' => $id,
              'lien' => $cheminFile,
              'user'=>$lid
            ]);
          //appartenir
          $app->getTable('Appartenir')->update([
            'projet_id' => $id,
            'typeprojet_id'=> $app->getTable('Projet')->find($id)->typeprojet_id
            ],[
            'typeprojet_id' => $_POST['typeprojet_id']
          ]);
          $result="<div class='alert alert-success'>Le portfolio a bien été modifié</div>";
        }
        else
        {
          $result="<div class='alert alert-danger'>Désolé, nous avons rencontre un problème lors du téléchargement de votre photo veuillez recommencer</div>";
        }
      }
      }
  }

  if(isset($_POST['enregistrer']))
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
        $app->getTable('Image')->create([
          'nom' => $_POST['nomimg'],
          'typeimage_id' => $_POST['typeimage_id'],
          'projet_id' => $id,
          'lien' => $cheminFile,
          'user'=>$lid
          ]);
          $result="<div class='alert alert-success'>L'image a bien été ajouté</div>";
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
        Portfolio Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="admin.php?p=portfolios"><i class="fa fa-briefcase"></i>Portfolios</a></li>
        <li class="active">Portfolio Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-6">
          <div class="box box-solid box-default">
            <div class="box-header">
              <i name="iconefor" class="glyphicon glyphicon-pencil"></i>

              <h3 class="box-title">Formulaire</h3>
            </div>
            <div class="box-body">
              <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="text" class="form-control" name="nom" placeholder="Title:"
                  value="<?=$app->getTable('Projet')->findattr('nom', $id)->nom?>" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="lien" placeholder="Website Link:"
                  value="<?=$app->getTable('Projet')->findattr('lien', $id)->lien?>" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="client" placeholder="Client:"
                  value="<?=$app->getTable('Projet')->findattr('client', $id)->client?>" required>
                </div>
                <div class="form-group">
                  <label>Types:</label>
                  <select name="typeprojet_id" class="form-control select2" style="width: 100%;">
                    <?php
                      $i=1;
                      foreach($app->getTable('Typeprojet')->all() as $typeprojet)
                      {
                        if($typeprojet->id != '1')
                        {
                          if ($typeprojet->id==$app->getTable('Projet')->getTypeProjet($id)->id) echo '<option value='.$typeprojet->id.' selected="selected">'.$typeprojet->nom.'</option>';
                          else echo '<option value='.$typeprojet->id.'>'.$typeprojet->nom.'</option>';
                        }
                        $i++;
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <textarea class="textarea" name="description" placeholder="Description :"
                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required>
                    <?=$app->getTable('Projet')->findattr('description', $id)->description?>
                  </textarea>
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
                      <span><input id="choice" type="radio" name="choice" value="Choice" onclick="show('choisi')"></span> Change
                    </label>
                  </div>
                  <div id="choisi" style="display: none">
                    <label>1440 × 736 preferably</label>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                        <div>
                            <span class="btn btn-file btn-primary">
                              <span class="fileupload-new">Select image</span>
                              <span class="fileupload-exists">Change</span>
                              <input id="jfile" type="file" accept=".jpg, .jpeg, .png" name="file">
                            </span>
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
                        echo "<div class='alert alert-success'>Le projet a bien été modifié</div>";
                      }
                    }
                  ?>
                  <button type="submit" class="pull-right btn btn-default" name="modifier">Update
                    <i style="color: #f39c12" class="fa fa-pencil"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">List of images</a></li>
              <li><a href="#timeline" data-toggle="tab">Add Images</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity" style="height: 508px">
                <!-- Post -->
                <div class="post" >
                  <?php
                    $i=1;
                    $e=0;
                    echo '<div class="row">';
                    foreach ($app->getTable('Image')->allwhere('projet_id', $id, 1) as $image)
                    {
                      if($i%3==0)
                      {
                        echo '</div>';
                        echo '<div class="row">';
                      }
                      echo '
                      <div class="col-md-4">
                        <div class="thumbnail">
                            <img src="'.$image->lien.'" alt="Photo" class="img-thumbnail img-responsive" width="200px" height="100px"/>
                            <div class="caption">
                              <h5 style="text-align: center;"><strong>'.$image->nom.'</strong></h5>
                              <p style="text-align: center;">
                                <form action="admin.php?p=imagedelete" method="post" style="color:red ">
                                  <input type="hidden" name="id" value='.$image->id.'>
                                  <input type="hidden" class="form-control" name="hidee" value="'.$id.'">
                                  <button type="submit" href="admin.php?p=imagedelete&id="'.$image->id.' >Delete <i class="fa fa-times"></i></button>
                                </form>
                              </p>
                            </div>
                        </div>
                      </div>
                      ';
                    }
                    if($i%3!=0) echo '</div>';
                  ?>
                </div>
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <form method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <input type="text" class="form-control" name="nomimg" placeholder="Title:">
                  </div>
                  <div class="form-group">
                    <label>Type:</label>
                    <select class="form-control select2" style="width: 100%;" name="typeimage_id">
                      <?php
                        $i=1;
                        foreach($app->getTable('Typeimage')->all(1) as $type)
                        {
                          if ($i==1) echo '<option value='.$type->id.' selected="selected">'.$type->nom.'</option>';
                          else echo '<option value='.$type->id.'>'.$type->nom.'</option>';
                          $i++;
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <div class="">
                      <label>1440 × 736 preferably</label>
                      <div class="fileupload fileupload-new" data-provides="fileupload">
                          <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                          <div>
                              <span class="btn btn-file btn-primary">
                                <span class="fileupload-new">Select image</span>
                                <span class="fileupload-exists">Change</span>
                                <input type="file" accept=".jpg, .jpeg, .png" name="file">
                              </span>
                              <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <?php
                      if(isset($_POST['enregistrer']))
                      {
                        if($result)
                        {
                          echo $result;
                        }
                      }
                    ?>
                    <button type="submit" class="pull-right btn btn-default" name="enregistrer">Save
                      <i style="color: #f39c12"  class="glyphicon glyphicon-floppy-disk"></i>
                    </button>
                    <br>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->

    </section>
    <!-- /.content -->
