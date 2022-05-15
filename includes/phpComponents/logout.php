<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['id'])){
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}

if(isset($_POST['logout'])){
  session_unset();
  session_destroy();
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}?>
