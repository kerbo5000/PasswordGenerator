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
    $statement = $pdo->prepare('UPDATE accounts SET username = :user, email = :email, password = :password,accountName =:accountName WHERE accountID = :accountid' );
    $statement->bindValue(':user',enc($usernameEdit,$private_key));
    $statement->bindValue(':accountName',$accountNameEdit);
    $statement->bindValue(':email',enc($emailEdit,$private_key));
    $statement->bindValue(':password',enc($passwordEdit,$private_key));
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
