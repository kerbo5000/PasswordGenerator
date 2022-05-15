<?php
if(isset($_POST['login-submit'])){
  include_once __DIR__.'/../extraComponents/config.php';
  include_once __DIR__.'/../extraComponents/functions.php';
  $usernameLogin = $_POST['login-username'];
  $passwordLogin = $_POST['login-password'];
  if(empty($usernameLogin) || empty($passwordLogin)){
    $errors[] ='missing inputs';
  }else{
    if($info = userExists($pdo,$usernameLogin,$usernameLogin,$private_key,$index_key)){
      $userPassword = $info[0]["password"];
      if(password_verify($passwordLogin,$userPassword)){
        session_start();
        $_SESSION['id'] = $info[0]["id"];
        $_SESSION['username'] = dec($info[0]["username"],$private_key);
        header('Location: http://localhost/PasswordGenerator/account.php');
        exit();
      }else{
        $passwordLogin ="";
        $errors[] = 'password doesn\'t match with account';
      }
    }else{
      $usernameLogin = "";
      $passwordLogin ="";
      $errors[] ='account doesn\'t exist';
    }
  }
  $errors[] = 'login';
}
?>
