<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['id'])){
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}
if(isset($_POST['id-delete'])){
  $statement = $pdo->prepare('DELETE FROM accounts WHERE accountID = :accountid');
  echo $_POST['actID'];
  $statement->bindValue(':accountid',$_POST['actID']);
  $statement->execute();
  $success[] = 'Account has been deleted';
  $success[] = 'danger';
}
?>
