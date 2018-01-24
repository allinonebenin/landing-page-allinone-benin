<?php
  use Core\Auth\DBAuth;
  //Auth
  $app=App::getInstance();
  if(!empty($_POST)){
  	//supprimer appartenir
	$result=$app->getTable('Appartenir')->delete($_POST['id'], 'projet_id');
	//supprimer images
	$result=$app->getTable('Image')->delete($_POST['id'], 'projet_id');
  	//supprimer portfolio
    $result=$app->getTable('Projet')->delete($_POST['id']);
    header('Location: admin.php?p=portfolios');
  }
?>
