<?php
  $app=App::getInstance();
  if(isset($_POST['register']))
  {
    if($_POST['motdepasse']==$_POST['cmotdepasse'])
    {
      if(!$app->getTable('Utilisateur')->verifmail($_POST['mail']))
      {
      // if($_POST['file']=='') $cheminFile="images/avatar.png";
      // else {
      //   $cheminDir="uploads/users/";
      //   $cheminFile=$cheminDir . $_POST['file'];
      // }
      $cheminFile="images/avatar.png";
      $app->getTable('Utilisateur')->create([
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'mail' => $_POST['mail'],
        'password' => sha1($_POST['motdepasse']),
        'datenais' => $_POST['datenais'],
        'user'=>'1',
        'lien'=>$cheminFile
        ]);
      $message='
        <h2>Successful registration</h2>
          <p>We welcome you to All in one Benin. Your identifiers are:</p>
          <ul>
            <li>mail: '.$_POST['mail'].'</li>
            <li>password:'.$_POST['motdepasse'].'
          </ul>
      ';
      mail($_POST['mail'] , "Successful registration", $message);
      $result="<div class='alert alert-success'>Vous êtes bien enregistré!! Vous pouvez maintenant vous connecter</div>";
      // move_uploaded_file($_FILES["file"]["tmp_name"],$cheminFile);
      }
      else
      {
        $result="<div class='alert alert-warning'>Ce mail est déjà utilisé</div>";
      }
    }
    else
    {
      $result="<div class='alert alert-danger'>Mots de passes non identiques</div>";
    }
  }
?>
<!-- Start portfolio -->
<section id="portfolio" class="section single">
    <div class="container container-center col-md-offset-3 col-md-6">
      <form action="" method="post" style="background-color:white; padding: 30px;">
        <h3>Register</h3><br>
        <p>Please register here for like, comment our posts.</p>
        <br>
        <div class="form-group has-feedback">
          <input id="pass" name="nom" type="text" class="form-control" placeholder="Nom">
        </div>
        <div class="form-group has-feedback">
          <input id="pass" name="prenom" type="text" class="form-control" placeholder="Prenom">
        </div>
        <div class="form-group has-feedback">
          <input id="pass" name="mail" type="email" class="form-control" placeholder="Mail">
        </div>
        <div class="form-group has-feedback">
          <input id="pass" name="motdepasse" type="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group has-feedback">
          <input id="pass" name="cmotdepasse" type="password" class="form-control" placeholder="Confirm Password">
        </div>
       <!--  <div class="form-group has-feedback">
          <input id="pass" name="password" type="password" class="form-control" placeholder="Lien">
        </div> -->
        <div class="form-group has-feedback">
          <input id="pass" name="datenais" type="date" class="form-control" placeholder="jj/mm/aaaa">
        </div>
        <div class="row">
          <div class="col-xs-6">
            <button type="reset" class="btn btn-danger btn-block btn-flat">Cancel</button>
          </div>
          <!-- /.col -->
          <div class="col-xs-6">
            <button type="submit" name="register" class="btn btn-warning btn-block btn-flat">Register</button>
          </div>
          <!-- /.col -->
        </div>
        <br>
        <?php
            if(isset($_POST['register']))
            {
              if($result)
              {
                echo $result;
              }
            }
          ?>
      </form>
    </div>
</section>
