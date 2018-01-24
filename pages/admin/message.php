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
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mailbox
        <small><?=$app->getTable('Messages')->compteattr('etat', '0')->tot?> unread messages</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-envelope"></i>Mailbox</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="admin.php?p=compose" class="btn btn-primary btn-block margin-bottom">Compose</a>

          <div class="box box-solid box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active">
                  <a href="admin.php?p=messages">
                    <i class="fa fa-inbox"></i> Inbox
                    <span class="label label-primary pull-right">
                      <?=$app->getTable('Messages')->compteattr('etat', '0')->tot?>
                    </span>
                  </a>
                </li>
                <li>
                  <a href="admin.php?p=sent">
                    <i class="fa fa-envelope-o"></i> Sent
                  <span class="label label-primary pull-right">
                    <?=$app->getTable('Messagessent')->compte()->tot?>
                  </span></a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-solid box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Inbox</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Mail">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <a href="admin.php?p=messages" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
                <div class="pull-right pagination">
                  <?php
                  $messagesParPage=10;
                  $total=$app->getTable('Messages')->compte()->tot;
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
                  for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
                  {
                      if($i==1)
                      {
                          if ($i==$pageActuelle)
                          {
                               echo '<li><a href="#" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a></li>';
                          }
                          else
                          {
                              echo '<li><a href="admin.php?p=messages&page='.($pageActuelle-1).'" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a></li>';
                          }
                      }
                      if($i==$pageActuelle) echo '<li class="active"><a href="#">'.$i.'</a></li>';
                      else echo '<li><a href="admin.php?p=messages&page='.$i.'">'.$i.'</a></li>';
                      if($i==$nombreDePages)
                      {
                          if ($nombreDePages==$pageActuelle)
                          {
                              echo '<li><a href="#" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a></li>';
                          }
                          else
                          {
                              echo '<li><a href="admin.php?p=messages&page='.($pageActuelle+1).'" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a></li>';
                          }

                      }
                  }
                  ?>
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="clearfix"></div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                    <?php
                      foreach($app->getTable('Messages')->afficherPage($premiereEntree, $messagesParPage) as $messages)
                      {
                        echo'
                        <tr>
                          <td><div class="btn-group">
                            <form action="admin.php?p=messagedelete" method="post">
                              <input type="hidden" name="id" value='.$messages->id.'>
                              <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                            </form>
                          </div></td>
                          <td class="mailbox-star">
                            <i class="fa fa-star text-yellow"></i></td>
                          <td class="mailbox-name">
                            <a href="'.$messages->getUrl().'">'.$messages->nom.'</a>
                          </td>
                          <td class="mailbox-subject">';
                            if($messages->etat=='0') echo '<b>'.$messages->mail.'</b>';
                            else echo $messages->mail;
                            echo' - '.substr($messages->contenu, 0, 60).'...
                          </td>
                          <td class="mailbox-attachment"></td>
                          <td class="mailbox-date">';
                            echo App::ctrlDate($messages);
                          echo'</td>
                        </tr>
                        ';
                      }
                    ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="clearfix"></div>
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
                <a href="admin.php?p=messages" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
                <div class="pull-right pagination">
                  <?php
                  for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
                  {
                      if($i==1)
                      {
                          if ($i==$pageActuelle)
                          {
                               echo '<li><a href="#" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a></li>';
                          }
                          else
                          {
                              echo '<li><a href="admin.php?p=messages&page='.($pageActuelle-1).'" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a></li>';
                          }
                      }
                      if($i==$pageActuelle) echo '<li class="active"><a href="#">'.$i.'</a></li>';
                      else echo '<li><a href="admin.php?p=messages&page='.$i.'">'.$i.'</a></li>';
                      if($i==$nombreDePages)
                      {
                          if ($nombreDePages==$pageActuelle)
                          {
                              echo '<li><a href="#" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a></li>';
                          }
                          else
                          {
                              echo '<li><a href="admin.php?p=messages&page='.($pageActuelle+1).'" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a></li>';
                          }

                      }
                  }
                  ?>
                  <!-- <div class="btn-group">
                    <a href="admin.php?p=messages&page='.($pageActuelle-1).'" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a>
                    <a href="admin.php?p=messages&page='.($pageActuelle+1).'" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a>
                  </div> -->
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
