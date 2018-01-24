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
  if($app->getTable('Messages')->findattr('etat', $id)->etat=='0')
  {
    $app->getTable('Messages')->update([
      'id'=>$id
      ], [
      'etat' => '1']);
  }
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Read Mail
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="admin.php?p=messages"><i class="fa fa-envelope-o"></i>Mailbox</a></li>
        <li class="active">Read mail</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="admin.php?p=compose&id=<?=$id?>" class="btn btn-primary btn-block margin-bottom">Reply</a>
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
              <h3 class="box-title">Read Mail</h3>

              <div class="box-tools pull-right">
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><?=$app->getTable('Messages')->findattr('nom', $id)->nom?></h3>
                <h5>From: <?=$app->getTable('Messages')->findattr('mail', $id)->mail?>
                  <span class="mailbox-read-time pull-right">
                    <?=$app->getTable('Messages')->findattr('datepub', $id)->datepub?>
                  </span>
                </h5>
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                    <i class="fa fa-trash-o"></i></button>
                  <a class="btn btn-default btn-sm" href="admin.php?p=compose&id=<?=$id?>" title="Reply">
                    <i class="fa fa-reply"></i></a>
                </div>
                <!-- /.btn-group -->
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <p style="text-align:justify"><?=$app->getTable('Messages')->findattr('contenu', $id)->contenu?></p>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

            </div>
            <!-- /.box-footer -->
            <div class="box-footer">
              <div class="pull-right">
                <a class="btn btn-default btn-sm" href="admin.php?p=compose&id=<?=$id?>" title="Reply">
                  <i class="fa fa-reply"></i> Reply</a>
              </div>
              <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
