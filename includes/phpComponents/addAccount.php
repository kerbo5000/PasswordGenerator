<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['id'])){
  header('Location: https://password-storage-kerby.herokuapp.com/frontpage.php');
  exit();
}
if(isset($_POST['submit'])){
  include_once __DIR__.'/../extraComponents/config.php';
  include_once __DIR__.'/../extraComponents/functions.php';
  $accountName = trim($_POST['account-name']);
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  if(!empty($email)){
    if(invalidEmail($email)){
      $email = '';
      $errors[] ='email is invalid';
    }
  }else if(!in_array('missing inputs',$errors)){
    $errors[] ='missing inputs';
  }
  if(empty($accountName) || empty($password)||empty($username)){
    if(!in_array('missing inputs',$errors)){
      $errors[] ='missing inputs';
    }
  }
  if(empty($errors)){
    $statement = $pdo->prepare('SELECT accountID,password FROM accounts WHERE userID = :userid AND accountName = :accountName AND usernameHash = :usernameHash AND emailHash = :emailHash LIMIT 1');
    $statement->bindValue(':usernameHash',getHash($username,$index_key));
    $statement->bindValue(':emailHash',getHash($email,$index_key));
    $statement->bindValue(':accountName',$accountName);
    $statement->bindValue(':userid',$_SESSION['id']);
    $statement->execute();
    $test = $statement->fetchAll(PDO::FETCH_ASSOC);
    if(empty($test)){
      $statement = $pdo->prepare('INSERT INTO accounts (username, email, password,accountName,userID,usernameHash,emailHash,passwordHash) VALUES (:user, :email, :password,:accountName,:userid,:usernameHash,:emailHash,:passwordHash)');
      // $hashedPwd = password_hash($password,PASSWORD_DEFAULT);
      $statement->bindValue(':user',enc($username,$private_key));
      $statement->bindValue(':accountName',$accountName);
      $statement->bindValue(':email',enc($email,$private_key));
      $statement->bindValue(':password',enc($password,$private_key));
      $statement->bindValue(':usernameHash',getHash($username,$index_key));
      $statement->bindValue(':emailHash',getHash($email,$index_key));
      $statement->bindValue(':passwordHash',getHash($password,$index_key));
      $statement->bindValue(':userid',$_SESSION['id']);
      $statement->execute();
      $success[] = 'Account has been added';
      $success[] = 'success';
    }else{
      $errors[] = 'Account already exists, you can update it here';
      $errors[] = 'edit';
      $urlErrors = '&errors='.urlencode(serialize($errors));
      $data = '&accountName='.$accountName.'&username='.$username.'&email='.$email.'&password='.dec($test[0]['password'],$private_key);
      header('Location: https://password-storage-kerby.herokuapp.com/account.php?id='.base64_encode($test[0]['accountID']).$urlErrors.$data);
    }
  }else{
    $errors[] = 'addAccount';
  }
}
?>
