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

  if(!empty($_POST))
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
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Home</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active"><i class="fa fa-home"></i>Home</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?=$app->getTable('Article')->compte()->tot;?></h3>
          <p>All posts</p>
        </div>
        <div class="icon">
          <i class="fa fa-file"></i>
        </div>
        <a href="admin.php?p=posts" class="small-box-footer">View<i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?=$app->getTable('Projet')->compte()->tot;?></h3>
          <p>All portfolio</p>
        </div>
        <div class="icon">
          <i class="fa fa-briefcase"></i>
        </div>
        <a href="admin.php?p=portfolios" class="small-box-footer">View<i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?=$app->getTable('Utilisateur')->compte()->tot;?></h3>
          <p>Users</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="admin.php?p=users" class="small-box-footer">View<i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?=$app->getTable('Messages')->compte()->tot;?></h3>
          <p>All messages</p>

        </div>
        <div class="icon">
          <i class="fa fa-envelope"></i>
        </div>
        <a href="admin.php?p=messages" class="small-box-footer">View<i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <div class="col-md-4">
      <!-- MESSAGES -->
      <div class="box box-solid box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Messages</h3>

          <div class="box-tools pull-right">
            <span class="label label-danger"><?=$app->getTable('Messages')->compteattr('etat', '0')->tot?> Unread</span>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
              <div class="box box-widget widget-user-2">
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <?php
                      foreach ($app->getTable('Messages')->lastUnread() as $last) {
                        echo'
                          <li>
                            <a href="'.$last->getUrl().'">';
                            if ($app->getTable('Messages')->findattr('etat', $last->id)->etat == '0')
                                echo'<strong>' . $last->nom . '</strong>';
                            else echo $last->nom;
                            echo '
                            : '. substr($last->contenu, 0, 20).'...
                              <span class="pull-right badge bg-blue">';
                                echo App::ctrlDate($last);
                            echo '</span>
                            </a>
                          </li>
                        ';
                      }
                    ?>
                  </ul>
                </div>
            </div>
              <!-- /.col -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <a href="admin.php?p=messages" class="uppercase">View All Messages</a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!--/.box -->
    </div>
    <!-- /.col -->

    <div class="col-md-4">
      <!-- MEMBERS LIST -->
      <div class="box box-solid box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Latest Members</h3>
          <div class="box-tools pull-right">
            <span class="label label-danger"><?=$app->getTable('Utilisateur')->newMember()->tot;?> New Members</span>
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove">
              <i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <ul class="users-list clearfix">
            <?php
              foreach ($app->getTable('Utilisateur')->lastNew() as $last) {
                echo'
                  <li>
                    <img src="'.$last->lien.'" alt="User Image">
                    <a class="users-list-name" href="'.$last->getUrl().'">'.$last->nom.' '.$last->prenom.'</a>
                    <span class="users-list-date">';
                      echo App::ctrlDate($last);
                    '</span>
                  </li>
                ';
              }
            ?>
          </ul>
          <!-- /.users-list -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <a href="admin.php?p=users" class="uppercase">View All Users</a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!--/.box -->
    </div>
    <!-- /.col -->

    <div class="col-md-4">
      <!-- TOP BLOG -->
      <div class="box box-solid box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Top 5 Blog</h3>

          <div class="box-tools pull-right">
            <span class="label label-danger">Most viewed</span>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
              <br>
              <div class="box box-widget widget-user-2">
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <?php
                        $i=1;
                        foreach ($app->getTable('Article')->popular() as $popu) {
                            echo'
                            <li>
                                <a href="'.$popu->getUrl(1).'">'.$popu->nom;
                                if ($i==1) echo '<span class="pull-right badge bg-blue">';
                                elseif($i==2) echo '<span class="pull-right badge bg-aqua">';
                                elseif($i==3) echo '<span class="pull-right badge bg-green">';
                                elseif($i==4) echo '<span class="pull-right badge bg-orange">';
                                elseif($i==5) echo '<span class="pull-right badge bg-red">';
                            echo $popu->nombrevue .'
                                <i class="fa fa-eye"></i>
                                </span>
                              </a>
                            </li>
                            ';
                            $i++;
                        }
                    ?>
                  </ul>
                  <br>
                </div>
            </div>
              <!-- /.col -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <a href="admin.php?p=posts" class="uppercase">View All Posts</a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!--/.box -->
    </div>
    <!-- /.col -->

  </div>
  <!-- /.row -->

  <div class="box box-solid box-default">
    <div class="box-header with-border">
  <i class="fa fa-envelope"></i>

  <h3 class="box-title">Quick Post</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <form action="#" method="post">
        <div class="form-group">
          <input type="text" class="form-control" name="nom" placeholder="Titre:" required>
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
                if ($i==1) echo '<option value="'.$category->id.'" selected="selected">'.$category->nom.'</option>';
                else echo '<option value="'.$category->id.'" >'.$category->nom.'</option>';
                $i++;
              }
            ?>
          </select>
        </div>
        <div>
          <div class="col-md-12">
            <textarea name="description" class="textarea" placeholder="Contenu"
            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
            required>

            </textarea>
          </div>
        </div>
    </div>
        <div class="form-group">
        <div class="box-footer clearfix">
        <?php
        if(!empty($_POST))
        {
          if($result)
          {

            echo $result;

          }
        }
        ?>
         <button type="submit" name="submit" class="pull-right btn btn-default">Publish
           <i  style="color: #f39c12" class="fa fa-arrow-circle-right"></i></button>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
