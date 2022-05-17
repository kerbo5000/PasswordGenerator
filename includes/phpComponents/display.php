<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['id'])){
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}

include_once __DIR__.'/../extraComponents/config.php';
if(!isset($_POST['search-btn'])){
  $statement = $pdo->prepare('SELECT accountID,email,username,password,accountName FROM accounts WHERE userID = :userid');
}else{
  if(isset($_POST['filter'])&& !empty($_POST['search'])){
    include_once __DIR__.'/../extraComponents/functions.php';
    $value = trim($_POST['search']);
    switch($_POST['filter']){
      case 'accountName':
        $statement = $pdo->prepare('SELECT accountID,email,username,password,accountName FROM accounts WHERE userID = :userid AND accountName = :search');
        $statement->bindValue(':search',$value);
        break;
      case 'email':
        $statement = $pdo->prepare('SELECT accountID,email,username,password,accountName FROM accounts WHERE userID = :userid AND emailHash = :search');
        $statement->bindValue(':search',getHash($value,$index_key));
        break;
      case 'username':
        $statement = $pdo->prepare('SELECT accountID,email,username,password,accountName FROM accounts WHERE userID = :userid AND usernameHash = :search');
        $statement->bindValue(':search',getHash($value,$index_key));
        break;
      case 'password':
        $statement = $pdo->prepare('SELECT accountID,email,username,password,accountName FROM accounts WHERE userID = :userid AND passwordHash = :search');
        $statement->bindValue(':search',getHash($value,$index_key));
        break;
    }
  }else{
    $statement = $pdo->prepare('SELECT accountID,email,username,password,accountName FROM accounts WHERE userID = :userid');
    $errors[] = 'Search field has to be filled and option has to be selected for filter to work';
    $errors[] = 'filter';
  }
}
$statement->bindValue(':userid',$_SESSION['id']);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
if(empty($result)){
  $errors[] = 'No results were found';
  $errors[] = 'filter';
}
 ?>
