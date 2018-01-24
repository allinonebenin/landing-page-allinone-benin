<?php
  use Core\Auth\DBAuth;
  //Auth
  $app=App::getInstance();
  if(!empty($_POST)){
    $result=$app->getTable('Messagessent')->delete($_POST['id']);
    header('Location: admin.php?p=sent');
  }
?>
