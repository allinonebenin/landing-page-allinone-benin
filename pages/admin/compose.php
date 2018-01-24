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
  if (isset($_GET['id'])) $id=$_GET['id'];

  if(isset($_POST['send']))
  {
    if($_POST['message'])
    {
        $app->getTable('Messagessent')->create([
          'mail' => $_POST['mail'],
          'sujet' => $_POST['sujet'],
          'contenu' => $_POST['message']
          ]);
        mail($_POST['mail'], $_POST['sujet'], $_POST['message']);
        $result="<div class='alert alert-success'>Message envoyé</div>";
    }
    else {
      $result="<div class='alert alert-danger'>Contenu vide</div>";
    }
  }

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mailbox
        <small>13 new messages</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="admin.php?p=messages"><i class="fa fa-envelope-o"></i>Mailbox</a></li>
        <li class="active">Compose</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="admin.php?p=messages" class="btn btn-primary btn-block margin-bottom">Back to Inbox</a>

          <div class="box box-solid">
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
              <h3 class="box-title">Compose New Message</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <form action="#" method="post">
                <div class="form-group">
                  <input name="mail" class="form-control" 
                  <?php
                    if (isset($_GET['id']))
                        echo 'value="' . $app->getTable('Messages')->findattr('mail', $id)->mail .'"';
                    else 
                        echo '" placeholder="To: "';
                     ?>
                  required>
                </div>
                <div class="form-group">
                  <input name="sujet" class="form-control" 
                  <?php
                    if (isset($_GET['id']))
                        echo 'value="Re :"';
                    else 
                        echo '" placeholder="Subject: "';
                     ?>
                  required>
                </div>
                <div>
                  <textarea class="textarea" placeholder="Content" name="message" 
                  style="width: 100%; height: 350px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required>

                      <p><strong>Sévérine F.</strong> | Office Of The Customer Services<p>
                      <p style="color:#F2784B">ALL IN ONE-BENIN</p>
                      <p>Business Hours : Mon.-Fri. 8:30-5:30pm & Saturday 9-1pm<br>
                      Direction : 1st street on right after Pharmacie Houeyiho, “Houeyiho”, Lot 1093 Villa Awussi
                      04BP538 Cotonou-Rep.Benin<br>
                      Office : (+229) 62-55-24-13<br>
                      Cel : (+229) 95-88-89-64<br>
                      Email : ddossou@allinone-benin.com<br>
                      Web : <a href="http://www.allinone-benin.com">http://www.allinone-benin.com</a><br>
                      Creating positive change by recruiting the doers, thinkers, and makers<br><br>

                      ALL IN ONE-BENIN is an Equal Opportunity Employer. All qualified applicants will receive consideration for employment without regard to race, color, religion, sex, national origin, disability, protected veteran status, or any other characteristic protected by law.<br><br>

                      ***<br></p>

                      <p style="color: #c9c9c9;">ALL IN ONE-BENIN est un employeur d'égalité des chances. Tous les candidats qualifiés recevront la considération pour l'emploi sans égard à la race, la couleur, la religion, le sexe, l'origine nationale, le handicap, le statut d'ancien combattant protégé, ou toute autre caractéristique protégée par la loi.</p>
                  </textarea>
                </div>

                <div class="box-footer">
                  <div class="pull-right">
                    <button type="submit" name="send" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                  </div>
                  <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                </div>
                <!-- /.box-footer -->
              </form>
            </div>
            <!-- /.box-body -->
    </section>
    <!-- /.content -->
<!-- Page Script -->
<script>
  $(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();
  });
</script>
