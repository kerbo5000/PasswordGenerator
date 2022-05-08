<?php
if(isset($_POST['signup-submit'])){
  $username = $_POST['signup-username'];
  $email = $_POST['signup-email'];
  $password = $_POST['signup-password'];
  $repeatPwd = $_POST['signup-repeat-password'];
  include 'dbconnection.php';
  include 'functions.php';
  if(missingSignupInput($username,$email,$password,$repeatPwd)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=missingInput&prev=signup');
    exit();
  }
  if(invalidUsername($username)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=invalidUsername&prev=signup');
    echo 'error=invalidUsername';
    exit();
  }
  if(invalidEmail($email)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=invalidEmail&prev=signup');
    exit();
  }
  if(pwdMatch($password,$repeatPwd)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=passwordsNoMatch&prev=signup');
    exit();
  }
  if(userExists($pdo,$username,$email)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=userExists&prev=signup');
    exit();
  }
  createUser($pdo,$username,$email,$password);
  $user = userExists($pdo,$username,$email);
  $id = $user[0]['id'];
  header('Location: http://localhost/PasswordGenerator/account.php?id='.$id);
  exit();
}else{
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}
?>
