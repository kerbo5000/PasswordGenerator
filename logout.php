<?php
session_start();
if(!isset($_SESSION['id'])){
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}else{
  session_unset();
  session_destroy();
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}?>
