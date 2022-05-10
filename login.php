<?php
if(isset($_POST['login-submit'])){
  $usernameLogin = $_POST['login-username'];
  $passwordLogin = $_POST['login-password'];
  include_once 'config.php';
  include_once 'functions.php';
  if(empty($usernameLogin) || empty($passwordLogin)){
    $errors[] ='missing inputs';
  }else{
    if($info = userExists($pdo,$usernameLogin,$usernameLogin,$private_key,$index_key)){
      $userPassword = $info[0]["password"];
      if(password_verify($passwordLogin,$userPassword)){
        session_start();
        $_SESSION['id'] = $info[0]["id"];
        header('Location: http://localhost/PasswordGenerator/account.php');
        exit();
      }else{
        $errors[] = 'password doesn\'t match with account';
      }
    }else{
      $errors[] ='account doesn\'t exist';
    }
  }
}
?>
