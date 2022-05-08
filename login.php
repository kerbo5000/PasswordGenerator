<?php
if(isset($_POST['login-submit'])){
  $username = $_POST['login-username'];
  $password = $_POST['login-password'];
  include 'dbconnection.php';
  include 'functions.php';
  if(missingLoginInput($username,$password)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=missingInput&prev=login');
    exit();
  }
  if($info = userExists($pdo,$username,$username)){
    $userPassword = $info[0]["password"];
    if(password_verify($password,$userPassword)){
      header('Location: http://localhost/PasswordGenerator/account.php?id='.$info[0]["id"]);
      exit();
    }else{
      header('Location: http://localhost/PasswordGenerator/frontpage.php?error=wrongPassword&prev=login');
      exit();
    }
  }else{
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=noUser&prev=login');
    exit();
  }
}else{
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}
?>
