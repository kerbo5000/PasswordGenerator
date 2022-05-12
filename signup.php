<?php
if(isset($_POST['signup-submit'])){
  $usernameSignup = $_POST['signup-username'];
  $emailSignup = $_POST['signup-email'];
  $passwordSignup = $_POST['signup-password'];
  $repeatPwdSignup = $_POST['signup-repeat-password'];
  include_once 'config.php';
  include_once 'functions.php';
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
    createUser($pdo,$usernameSignup,$emailSignup,$passwordSignup,$private_key,$index_key);
    $user = userExists($pdo,$usernameSignup,$emailSignup,$private_key,$index_key);
    session_start();
    $_SESSION['id'] = $user[0]['id'];
    header('Location: http://localhost/PasswordGenerator/account.php');
    exit();
  }else{
    $errors[] = 'signup';
  }
}
?>
