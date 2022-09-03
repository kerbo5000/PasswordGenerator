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
  if(!empty($usernameSignup)){
    if(invalidUsername($usernameSignup)){
      $valid_username = false;
      $usernameSignup = '';
      $errors[] ='username is invalid';
    }
  }else{
    $valid_username = false;
    $errors[] ='missing inputs';
  }

  if(!empty($emailSignup)){
    if(invalidEmail($emailSignup)){
      $valid_email = false;
      $emailSignup = '';
      $errors[] ='email is invalid';
    }
  }else if(!in_array('missing inputs',$errors)){
    $valid_email = false;
    $errors[] ='missing inputs';
  }

  if(!(empty($passwordSignup) || empty($repeatPwdSignup))){
    if(pwdMatch($passwordSignup,$repeatPwdSignup)){
      $passwordSignup ='';
      $repeatPwdSignup = '';
      $errors[] ='the passwords don\'t match';
    }
  }else if(!in_array('missing inputs',$errors)){
    $errors[] ='missing inputs';
  }
  if($valid_username && $valid_email){
    if(userExists($pdo,$usernameSignup,$emailSignup,$private_key,$index_key)){
      $emailSignup = '';
      $usernameSignup = '';
      $errors[] ='username or email already used';
    }
  }
  if(empty($errors)){
    echo 'hiiii'
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
