<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['id'])){
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}
if(isset($_POST['id-edit'])){
  include_once __DIR__.'/../extraComponents/config.php';
  include_once __DIR__.'/../extraComponents/functions.php';
  $usernameEdit = trim($_POST['usernameEdit']);
  $emailEdit = trim($_POST['emailEdit']);
  $passwordEdit = trim($_POST['passwordEdit']);
  $accountNameEdit = trim($_POST['accountNameEdit']);
  if(!empty($emailEdit)){
    if(invalidEmail($emailEdit)){
      $emailEdit = '';
      $errors[] ='email is invalid';
    }
  }else if(!in_array('missing inputs',$errors)){
    $errors[] ='missing inputs';
  }
  if(empty($passwordEdit)||empty($usernameEdit)){
    if(!in_array('missing inputs',$errors)){
      $errors[] ='missing inputs';
    }
  }
  if(empty($errors)){
    $statement = $pdo->prepare('UPDATE accounts SET username = :user, email = :email, password = :password,accountName =:accountName, usernameHash = :usernameHash, emailHash = :emailHash, passwordHash = :passwordHash
       WHERE accountID = :accountid' );
    $statement->bindValue(':user',enc($usernameEdit,$private_key));
    $statement->bindValue(':accountName',$accountNameEdit);
    $statement->bindValue(':email',enc($emailEdit,$private_key));
    $statement->bindValue(':password',enc($passwordEdit,$private_key));
    $statement->bindValue(':usernameHash',getHash($usernameEdit,$index_key));
    $statement->bindValue(':emailHash',getHash($emailEdit,$index_key));
    $statement->bindValue(':passwordHash',getHash($passwordEdit,$index_key));
    $statement->bindValue(':accountid',$_POST['actID']);
    $statement->execute();
    $success[] = 'Account has been updated';
    $success[] = 'warning';
  }else{
    $errors[] = 'edit';
    $urlErrors = '&errors='.urlencode(serialize($errors));
    $data = '&accountName='.$accountNameEdit.'&username='.$usernameEdit.'&email='.$emailEdit.'&password='.$passwordEdit;
    header('Location: http://localhost/PasswordGenerator/account.php?id='.base64_encode($_POST['actID']).$urlErrors.$data);
  }
}
?>
