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
    if($_POST['choice']=='Default')
    {
      $app->getTable('Article')->create([
        'nom' => $_POST['nom'],
        'author' => $_POST['author'],
        'description' => $_POST['description'],
        'categorie_id' => $_POST['categorie_id'],
        'user'=>$lid,
        'employe_id'=>$lid
        ]);
        $result="<div class='alert alert-success'>L'employé a bien été ajouté</div>";
    }
    else
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
          $app->getTable('Article')->create([
            'nom' => $_POST['nom'],
            'author' => $_POST['author'],
            'description' => $_POST['description'],
            'categorie_id' => $_POST['categorie_id'],
            'lien' => $cheminFile,
            'user'=>$lid,
            'employe_id'=>$lid
            ]);
          $result="<div class='alert alert-success'>L'article a bien été ajouté</div>";
        }
        else
        {
          $result="<div class='alert alert-danger'>Désolé, nous avons rencontre un problème lors du téléchargement de votre photo veuillez recommencer</div>";
        }
      }
  }
}
?>
<script type="text/javascript">
  show('choisi');
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Posts</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active"><i class="fa fa-file"></i>Posts</li>
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
              <input type="text" class="form-control" name="author" placeholder="Author:"
              value="<?=$app->getTable('Employe')->findattr('nom', $lid)->nom . ' ' . $app->getTable('Employe')->findattr('prenom', $lid)->prenom?>" required>
            </div>
            <div class="form-group">
              <label>Categories:</label>
              <select name="categorie_id" class="form-control select2" style="width: 100%;">
                <?php
                  $i=1;
                  foreach($app->getTable('Categorie')->all(1) as $category)
                  {
                    if($i==1) echo '<option value='.$category->id.' selected="selected">'.$category->nom.'</option>';
                    else echo '<option value='.$category->id.'>'.$category->nom.'</option>';
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
            <label>Images :</label>
            <div class="form-group">
              <div class="col-xs-6 col-sm-3 col-md-4">
                <label class="radio-inline">
                  <span><input id="choice" type="radio" name="choice" value="Default" onclick="hide('choisi')" checked></span> Default
                </label>

              </div>
              <div class="col-xs-6 col-sm-3 col-md-4">
                <label class="radio-inline">
                  <span><input id="choice" type="radio" name="choice" value="Choice" onclick="show('choisi')"></span> Choice
                </label>
              </div>
            </div>
            <div class="form-group">
              <div id="choisi" style="display: none">
                <br>
                <label>1200x800 preferably</label>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                    <div>
                        <span class="btn btn-file btn-primary">
                          <span class="fileupload-new">Select image</span>
                          <span class="fileupload-exists">Change</span>
                          <input name="file" id="file" type="file" accept=".jpg, .jpeg, .png"  required>
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
                    echo $result;
                  }
                }
              ?>
              <button type="submit" class="pull-right btn btn-default" name="enregistrer">Publish
                <i style="color: #f39c12" class="fa fa-arrow-circle-right"></i>
              </button>
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
          <h3 class="box-title">List of posts</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th style="width: 2px">#</th>
              <th style="width: 10px">Title</th>
              <th style="width: 5px">Post By</th>
              <th style="width: 20px">Description</th>
              <th style="width: 5px">Edit</th>
              <th style="width: 5px">Delete</th>
            </tr>
            <?php
              $messagesParPage=6;
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
              $i=1;
              foreach ($app->getTable('Article')->page($premiereEntree, $messagesParPage) as $article) {
                echo '
                <tr>
                  <td>
                    <a href="'.$article->getUrl(1).'">'.$i.'.</a>
                  </td>
                  <td>
                    '.$article->nom.'
                  </td>
                  <td>
                    '.$article->author.'
                  </td>
                  <td style="text-align: justify">
                    '.substr($article->description, 0, 50).'...
                  </td>
                  <td style="text-align: center;">
                    <a href="'.$article->getUrl(1).'">
                      <button><i style="margin-right:5px" class="fa fa-pencil"></i></button>
                    </a>
                  </td>
                  <td style="text-align: center;">
                  <form action="admin.php?p=postdelete" method="post" style="color:red ">
                    <input type="hidden" name="id" value='.$article->id.'>
                    <button type="submit" href="admin.php?p=postdelete&id="'.$article->id.' ><i class="fa fa-times"></i></button>
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
                          echo '<li class="prev"><a href="admin.php?p=posts&page='.($pageActuelle-1).'"><span class="fa fa-angle-left"></span>Prev</a></li>';
                      }

                  }
                  if($i==$pageActuelle) echo '<li class="active"><a href="#">'.$i.'</a></li>';
                  else echo '<li><a href="admin.php?p=posts&page='.$i.'">'.$i.'</a></li>';
                  if($i==$nombreDePages)
                  {
                      if ($nombreDePages==$pageActuelle)
                      {
                          echo '<li class="next"><a href="#">Next<span class="fa fa-angle-right"></span></a></li>';
                      }
                      else
                      {
                          echo '<li class="next"><a href="admin.php?p=posts&page='.($pageActuelle+1).'">Next<span class="fa fa-angle-right"></span></a></li>';
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
