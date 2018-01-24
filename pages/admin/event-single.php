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
  if(!empty($_POST))
  {
      $result=$app->getTable('Evenement')->update([
        'id'=>$id
        ], [
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
        Event Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="admin.php?p=events"><i class="fa fa-calendar"></i>Events</a></li>
        <li class="active">Event Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<div class="box box-solid box-default">
					<div class="box-header">
						<i name="iconefor" class="glyphicon glyphicon-pencil"></i>
						<h3 class="box-title">Edit</h3>
					</div>
					<div class="box-body">
						<form action="#" method="post">
							<div class="form-group">
								<input type="text" class="form-control" name="nom" placeholder="Title:"
                value="<?=$app->getTable('Evenement')->findattr('nom', $id)->nom?>" required>
							</div>
							<div class="form-group">
								<textarea class="textarea" name="description" placeholder="Description :"
                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required>
                  <?=$app->getTable('Evenement')->findattr('description', $id)->description?>
                </textarea>
							</div>
              <div class="form-group">
                <label>Date:</label>
                <?php
                $date= $app->getTable('Evenement')->getDate($id)->a.'-'.
                          App::jour($app->getTable('Evenement')->getDate($id)->m).'-'.
                          App::jour($app->getTable('Evenement')->getDate($id)->j);
                        ?>
                <input type="date" class="form-control" name="datepub" placeholder="jj/mm/aaaa"
                  value="<?=$date?>" required>
              </div>
    					<div class="box-footer clearfix">
                <?php
                  if(!empty($_POST))
                  {
                    if($result)
                    {
                      echo "<div class='alert alert-success'>L'évènement a bien été modifié</div>";
                    }
                  }
                ?>
    						<button type="submit" class="pull-right btn btn-default" id="enregistrer">Update
    						<i  style="color: #f39c12" class="fa fa-pencil"></i></button>
    					</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /.col -->
		</div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
