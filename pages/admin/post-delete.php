<?php
  use Core\Auth\DBAuth;
  //Auth
  $app=App::getInstance();
  if(!empty($_POST)){
    //supprimer commentaires
  	$app->getTable('Commentaires')->delete($_POST['id'], 'article_id');
    //suprimer likes
  	$app->getTable('Likes')->delete($_POST['id'], 'article_id');
    //supprimer article
    $app->getTable('Article')->delete($_POST['id']);
    header('Location: admin.php?p=posts');
  }
?>
