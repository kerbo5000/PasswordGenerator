<?php
session_start();
if(!(isset($_SESSION['id']) && isset($_POST['id-delete']))){
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}
include 'dbconnection.php';
$statement = $pdo->prepare('DELETE FROM accounts WHERE accountID = :accountid');
$statement->bindValue(':accountid',$_POST['actID']);
$statement->execute();
header('Location: http://localhost/PasswordGenerator/account.php');
exit();
 ?>
