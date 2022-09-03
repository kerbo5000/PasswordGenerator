<?php
echo 'hi';
if(isset($_POST['signup-submit'])){
  echo 'hii';
  include_once __DIR__.'/../extraComponents/config.php';
  include_once __DIR__.'/../extraComponents/functions.php';
  $usernameSignup = $_POST['signup-username'];
  $emailSignup = $_POST['signup-email'];
  $passwordSignup = $_POST['signup-password'];
  $repeatPwdSignup = $_POST['signup-repeat-password'];
  $valid_username = true;
  $valid_email = true;
  echo 'h16';

  if(!empty($usernameSignup)){
    echo 'h1';
    if(invalidUsername($usernameSignup)){
      echo 'h2';
      $valid_username = false;
      $usernameSignup = '';
      $errors[] ='username is invalid';
    }
  }else{
    echo 'h3';
    $valid_username = false;
    $errors[] ='missing inputs';
  }
  echo 'h15';

  if(!empty($emailSignup)){
    echo 'h4';
    if(invalidEmail($emailSignup)){
      echo 'h5';
      $valid_email = false;
      $emailSignup = '';
      $errors[] ='email is invalid';
    }
  }else if(!in_array('missing inputs',$errors)){
    echo 'h6';
    $valid_email = false;
    $errors[] ='missing inputs';
  }
  echo 'h14';

  if(!(empty($passwordSignup) || empty($repeatPwdSignup))){
    echo 'h7';
    if(pwdMatch($passwordSignup,$repeatPwdSignup)){
      echo 'h8';
      $passwordSignup ='';
      $repeatPwdSignup = '';
      $errors[] ='the passwords don\'t match';
    }
  }else if(!in_array('missing inputs',$errors)){
    echo 'h9';
    $errors[] ='missing inputs';
  }
  echo 'h13';

  if($valid_username && $valid_email){
    echo 'h10';
    if(userExists($pdo,$usernameSignup,$emailSignup,$private_key,$index_key)){
      echo 'h11';
      $emailSignup = '';
      $usernameSignup = '';
      $errors[] ='username or email already used';
    }
  }
  echo 'h12';
  if(empty($errors)){
    echo 'hiiii';
    createUser($pdo,$usernameSignup,$emailSignup,$passwordSignup,$private_key,$index_key);
    $user = userExists($pdo,$usernameSignup,$emailSignup,$private_key,$index_key);
    session_start();
    $_SESSION['id'] = $user[0]['id'];
    $_SESSION['username'] = $usernameSignup;
    $statement = $pdo->prepare('INSERT INTO accounts (username, email, password,accountName,userID,usernameHash,emailHash,passwordHash) VALUES (:user, :email, :password,:accountName,:userid,:usernameHash,:emailHash,:passwordHash)');
    $statement->bindValue(':user',enc($usernameSignup,$private_key));
    $statement->bindValue(':accountName','Password Storage');
    $statement->bindValue(':email',enc($emailSignup,$private_key));
    $statement->bindValue(':password',enc($passwordSignup,$private_key));
    $statement->bindValue(':usernameHash',getHash($usernameSignup,$index_key));
    $statement->bindValue(':emailHash',getHash($emailSignup,$index_key));
    $statement->bindValue(':passwordHash',getHash($passwordSignup,$index_key));
    $statement->bindValue(':userid',$_SESSION['id']);
    $statement->execute();
    header('Location: https://password-storage-kerby.herokuapp.com/account.php');
    exit();
  }else{
    $errors[] = 'signup';
  }
}
?>
