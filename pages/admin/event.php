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
      $result=$app->getTable('Evenement')->create([
        'nom' => $_POST['nom'],
        'description' => $_POST['description'],
        'datepub' => $_POST['datepub'],
        'user'=>$lid
        ]);
  }
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Events</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active"><i class="fa fa-calendar"></i>Events</li>
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
          <form action="#" method="post">
            <div class="form-group">
              <input type="text" class="form-control" name="nom" placeholder="Title:" required>
            </div>
            <div class="form-group">
              <textarea class="textarea" name="description" placeholder="Description :" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
            </div>
            <div class="form-group">
              <label>Date:</label>
              <input type="date" class="form-control" name="datepub" placeholder="aaaa-mm-jj" required>
            </div>
            <div class="box-footer clearfix">
              <?php
                if(!empty($_POST))
                {
                  if($result)
                  {
                    echo "<div class='alert alert-success'>L'évènement a bien été ajouté</div>";
                  }
                }
              ?>
              <button type="submit" class="pull-right btn btn-default" id="enregistrer">Save
                <i style="color: #f39c12" class="glyphicon glyphicon-floppy-disk"></i></button>
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
          <i name="iconefor" class="fa fa-list"></i>
          <h3 class="box-title">List of events</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th style="width: 10px">#</th>
              <th>Title</th>
              <th>Date</th>
              <th>Description</th>
              <th style="width: 30px">Edit</th>
              <th style="width: 30px">Delete</th>
            </tr>
            <?php
              $messagesParPage=5;
              $total=$app->getTable('Evenement')->compte()->tot;
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
              foreach ($app->getTable('Evenement')->page($premiereEntree, $messagesParPage, "datepub") as $event) {
                echo '
                <tr>
                  <td><a href="'.$event->getUrl().'">'.$i.'.</a></td>
                  <td>'.$event->nom.'</td>
                  <td>
                    '.$event->datepub.'
                  </td>
                  <td>'.$event->description.'</td>
                  <td style="text-align: center;">
                    <a href="'.$event->getUrl().'">
                      <button><i style="margin-right:5px" class=" glyphicon glyphicon-pencil"></i>
                      </button>
                    </a>
                  </td>
                  <td style="text-align: center;">
                  <form action="admin.php?p=eventdelete" method="post" style="color:red ">
                    <input type="hidden" name="id" value='.$event->id.'>
                    <button type="submit" href="admin.php?p=eventdelete&id="'.$event->id.' ><i class="fa fa-times"></i></button>
                  </form>
                  </td>
                </tr>';
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
                          echo '<li class="prev"><a href="admin.php?p=events&page='.($pageActuelle-1).'"><span class="fa fa-angle-left"></span>Prev</a></li>';
                      }

                  }
                  if($i==$pageActuelle) echo '<li class="active"><a href="#">'.$i.'</a></li>';
                  else echo '<li><a href="admin.php?p=events&page='.$i.'">'.$i.'</a></li>';
                  if($i==$nombreDePages)
                  {
                      if ($nombreDePages==$pageActuelle)
                      {
                          echo '<li class="next"><a href="#">Next<span class="fa fa-angle-right"></span></a></li>';
                      }
                      else
                      {
                          echo '<li class="next"><a href="admin.php?p=events&page='.($pageActuelle+1).'">Next<span class="fa fa-angle-right"></span></a></li>';
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
