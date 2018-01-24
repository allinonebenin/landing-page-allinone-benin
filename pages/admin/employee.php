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
  $newid=(int)substr($app->getTable('Employe')->firstattr()->id, 1);
  $newid++;
  if(isset($_POST['save']))
  {
    if($_POST['motdepasse']==$_POST['cmotdepasse'])
    {
      if($_POST['choice']=='Default')
      {
        $app->getTable('Employe')->create([
          'id' => $newid,
          'nom' => $_POST['nom'],
          'prenom' => $_POST['prenom'],
          'mail' => $_POST['mail'],
          'password' => sha1($_POST['motdepasse']),
          'user'=>$lid
          ]);
          $result="<div class='alert alert-success'>L'employé a bien été ajouté</div>";
      }
      else
      {
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
          if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file1))
          {
            $result=$app->getTable('Employe')->create([
              'id' => $newid,
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
      $result="<div class='alert alert-warning'>Mots de passes non identiques</div>";
    }
  }
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Employees</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active"><i class="fa fa-user-secret"></i>Employees</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
     <!-- Left col -->
    <section class="col-lg-4 connectedSortable">
      <div class="box box-solid box-default">
        <div class="box-header">
          <i name="iconefor" class="glyphicon glyphicon-pencil"></i>

          <h3 class="box-title">Formulaire</h3>
        </div>
        <div class="box-body">
          <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <input type="text" class="form-control" name="nom" placeholder="Nom:" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="prenom" placeholder="Prenom:" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="mail" placeholder="E-mail:" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="motdepasse" placeholder="Mot de passe:" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="cmotdepasse" placeholder="Confirmer mot de passe:" required>
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
                <label>170x170 preferably</label>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                    <div>
                        <span class="btn btn-file btn-primary">
                          <span class="fileupload-new">Select image</span>
                          <span class="fileupload-exists">Change</span>
                          <input name="file" type="file" accept=".jpg, .jpeg, .png" >
                        </span>
                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
              </div>
            </div>
            <div class="box-footer clearfix">
              <?php
                if(isset($_POST['save']))
                {
                  if($result)
                  {
                    echo $result;
                  }
                }
              ?>
              <button type="submit" name="save" class="pull-right btn btn-default" id="enregistrer">Save
                <i style="color: #f39c12" class="glyphicon glyphicon-floppy-disk"></i></button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- /.Left col -->
    <!-- right col -->
    <section class="col-lg-8 connectedSortable">
      <!-- USERS LIST -->
      <div class="box box-solid box-default">
        <div class="box-header with-border">
          <i name="iconefor" class="fa fa-list"></i>
          <h3 class="box-title">List of Employees</h3>

          <div class="box-tools pull-right">
            <div class="has-feedback">
              <input type="text" class="form-control input-sm" placeholder="Search Employees">
              <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <ul class="users-list clearfix">
            <?php
              $messagesParPage=8;
              $total=$app->getTable('Employe')->compte()->tot;
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
              foreach ($app->getTable('Employe')->afficherPage($premiereEntree, $messagesParPage) as $employe) {
                echo'
                <li>
                  <img src="'.$employe->lien.'" alt="User Image">
                  <a class="users-list-name" href="'.$employe->getUrl().'">'.$employe->nom.' '.$employe->prenom.'</a>
                    <span class="users-list-date">';
                        echo App::ctrlDate($employe);
               echo'</span>
               <form action="admin.php?p=employeedelete" method="post" style="color:red ">
                 <input type="hidden" name="id" value='.$employe->id.'>
                 <button type="submit" href="admin.php?p=employeedelete&id="'.$employe->id.' ><i class="fa fa-times"></i></button>
               </form>
                </li>
                ';
              }
            ?>
          </ul>
          <!-- /.users-list -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <ul class="pagination">
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
                        echo '<li class="prev"><a href="admin.php?p=employees&page='.($pageActuelle-1).'"><span class="fa fa-angle-left"></span>Prev</a></li>';
                    }

                }
                if($i==$pageActuelle) echo '<li class="active"><a href="#">'.$i.'</a></li>';
                else echo '<li><a href="admin.php?p=employees&page='.$i.'">'.$i.'</a></li>';
                if($i==$nombreDePages)
                {
                    if ($nombreDePages==$pageActuelle)
                    {
                        echo '<li class="next"><a href="#">Next<span class="fa fa-angle-right"></span></a></li>';
                    }
                    else
                    {
                        echo '<li class="next"><a href="admin.php?p=employees&page='.($pageActuelle+1).'">Next<span class="fa fa-angle-right"></span></a></li>';
                    }

                }
            }
            ?>
          </ul>
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </section>
    <!-- right col -->
    </div>
  </div>
</section>
