<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['id'])){
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}

if(!isset($_POST['search-btn'])){
  $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid');
}else{
  if(isset($_POST['filter'])&& !empty($_POST['search'])){
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
// if(isset($_GET['search']) && isset($_GET['filter'])&& !empty($_GET['search'])){
//   switch($_GET['filter']){
//     case 'accountName':
//       $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND accountName = :search');
//       $statement->bindValue(':search',$_GET['search']);
//       break;
//     case 'email':
//       $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND emailHash = :search');
//       $statement->bindValue(':search',getHash($_GET['search'],$index_key));
//       break;
//     case 'username':
//       $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND usernameHash = :search');
//       $statement->bindValue(':search',getHash($_GET['search'],$index_key));
//       break;
//     case 'password':
//       $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND passwordHash = :search');
//       $statement->bindValue(':search',getHash($_GET['search'],$index_key));
//       break;
//   }
// }else{
//   $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid');
// }
// $statement->bindValue(':userid',$_SESSION['id']);
// $statement->execute();
// $result = $statement->fetchAll(PDO::FETCH_ASSOC);
 ?>
