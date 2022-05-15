<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['id'])){
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}
if(isset($_POST['id-delete'])){
  include_once __DIR__.'/../extraComponents/config.php';
  $statement = $pdo->prepare('DELETE FROM accounts WHERE accountID = :accountid');
  $statement->bindValue(':accountid',$_POST['actID']);
  $statement->execute();
  $success[] = 'Account has been deleted';
  $success[] = 'danger';
}
?>
