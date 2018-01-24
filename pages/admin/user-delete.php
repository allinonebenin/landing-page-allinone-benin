<?php
  use Core\Auth\DBAuth;
  //Auth
  $app=App::getInstance();
  if(!empty($_POST)){
  	//supprimer commentaires
  	$result=$app->getTable('Commentaires')->delete($_POST['id'], 'utilisateur_id');
  	//supprimer likes
  	$result=$app->getTable('Likes')->delete($_POST['id'], 'utilisateur_id');
  	//supprimer utilisateur
    $result=$app->getTable('Utilisateur')->delete($_POST['id']);
    header('Location: admin.php?p=users');
  }
?>
