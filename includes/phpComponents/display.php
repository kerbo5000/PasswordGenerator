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
  $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid');
}else{
  if(isset($_POST['filter'])&& !empty($_POST['search'])){
    include_once __DIR__.'/../extraComponents/functions.php';
    switch($_POST['filter']){
      case 'accountName':
        $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND accountName = :search');
        $statement->bindValue(':search',$_POST['search']);
        break;
      case 'email':
        $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND emailHash = :search');
        $statement->bindValue(':search',getHash($_POST['search'],$index_key));
        break;
      case 'username':
        $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND usernameHash = :search');
        $statement->bindValue(':search',getHash($_POST['search'],$index_key));
        break;
      case 'password':
        $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND passwordHash = :search');
        $statement->bindValue(':search',getHash($_POST['search'],$index_key));
        break;
    }
  }else{
    $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid');
    $errors[] = 'search field has to be filled and option has to be selected for filter';
    $errors[] = 'filter';
  }
}
$statement->bindValue(':userid',$_SESSION['id']);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
if(empty($result)){
  $errors[] = 'no results were found';
  $errors[] = 'filter';
}
 ?>
