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

  if(isset($_POST['enregistrer']))
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
        $app->getTable('Projet')->create([
          'nom' => $_POST['nom'],
          'lien' => $_POST['lien'],
          'client' => $_POST['client'],
          'description' => $_POST['description'],
          'image'=>'1',
          'user'=>$lid
        ]);
        //image
        $port=App::getInstance()->getDb()->lastInsertId();
        $app->getTable('Image')->create([
          'nom' => $_POST['nom'],
          'typeimage_id' => '1',
          'projet_id' => $port,
          'lien' => $cheminFile,
          'user'=>$lid
        ]);
        //appartenir
        $app->getTable('Appartenir')->create([
          'typeprojet_id' => $_POST['typeprojet_id'],
          'projet_id' => $port,
          'type' => "off"
        ]);
        $app->getTable('Appartenir')->create([
          'typeprojet_id' => '1',
          'projet_id' => $port
        ]);
        $result="<div class='alert alert-success'>Le portfolio a bien été ajouté</div>";
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
    Dashboard
    <small>Portfolios</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active"><i class="fa fa-briefcase"></i>Portfolios</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
      <div class="box box-solid box-default">
        <div class="box-header">
          <i name="iconefor" class="glyphicon glyphicon-pencil"></i>

          <h3 class="box-title">Formulaire</h3>
        </div>
        <div class="box-body">
          <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <input type="text" class="form-control" name="nom" placeholder="Title:" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="lien" placeholder="Website Link:" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="client" placeholder="Client:" required>
            </div>
            <div class="form-group">
              <label>Types:</label>
              <select name="typeprojet_id" class="form-control select2" style="width: 100%;">
                <?php
                  $i=1;
                  foreach($app->getTable('Typeprojet')->all(1) as $typeprojet)
                  {
                    if($typeprojet->id != '1')
                    {
                      if ($i==1) echo '<option value='.$typeprojet->id.' selected="selected">'.$typeprojet->nom.'</option>';
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
              </textarea>
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
            <div class="box-footer clearfix">
              <?php
                if(isset($_POST['enregistrer']))
                {
                  if($result)
                  {
                    echo "<div class='alert alert-success'>Le projet a bien été ajouté</div>";
                  }
                }
              ?>
              <button type="submit" class="pull-right btn btn-default" name="enregistrer">Save
                <i style="color: #f39c12"  class="glyphicon glyphicon-floppy-disk"></i></button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- /.Left col -->
    <!-- right col -->
    <section class="col-lg-6 connectedSortable">
      <div class="box box-solid box-default">
        <div class="box-header with-border">
          <h3 class="box-title">List of projects</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Description</th>
              <th>Client</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            <?php
              $messagesParPage=7;
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
              $i=1;
              foreach ($app->getTable('Projet')->page($premiereEntree, $messagesParPage) as $projet) {
                echo '
                <tr>
                  <td>
                    <a href="'.$projet->getUrl(1).'">'.$i.'.</a>
                  </td>
                  <td>
                    '.$projet->nom.'
                  </td>
                  <td style="text-align: justify">
                    '.substr($projet->description, 0, 200).'...
                  </td>
                  <td>
                    '.$projet->client.'
                  </td>
                  <td style="text-align: center;">
                    <a href="'.$projet->getUrl(1).'">
                      <button><i style="margin-right:5px" class=" glyphicon glyphicon-pencil"></i></button>
                    </a>
                  </td>
                  <td style="text-align: center;">
                  <form action="admin.php?p=portfoliodelete" method="post" style="color:red ">
                    <input type="hidden" name="id" value='.$projet->id.'>
                    <button type="submit" href="admin.php?p=portfoliodelete&id="'.$projet->id.' ><i class="fa fa-times"></i></button>
                  </form>
                  </td>
                </tr>
                ';
                $i++;
              }
            ?>
              <div class="pagination">
                <?php
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
                            echo '<li class="prev"><a href="admin.php?p=portfolios&page='.($pageActuelle-1).'"><span class="fa fa-angle-left"></span>Prev</a></li>';
                        }

                    }
                    if($i==$pageActuelle) echo '<li class="active"><a href="#">'.$i.'</a></li>';
                    else echo '<li><a href="admin.php?p=portfolios&page='.$i.'">'.$i.'</a></li>';
                    if($i==$nombreDePages)
                    {
                        if ($nombreDePages==$pageActuelle)
                        {
                            echo '<li class="next"><a href="#">Next<span class="fa fa-angle-right"></span></a></li>';
                        }
                        else
                        {
                            echo '<li class="next"><a href="admin.php?p=portfolios&page='.($pageActuelle+1).'">Next<span class="fa fa-angle-right"></span></a></li>';
                        }

                    }
                }
                ?>
              </div>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- right col -->
  </div>
  <!-- /.row (main row) -->
</section>
<!-- /.content -->
