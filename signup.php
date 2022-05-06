<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=password_storage','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

if(isset($_POST['signup-submit'])){
  $username = $_POST['signup-username'];
  $email = $_POST['signup-email'];
  $password = $_POST['signup-password'];
  $repeatPwd = $_POST['signup-repeat-password'];
  include 'functions.php';
  if(missingSignupInput($username,$email,$password,$repeatPwd)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=missingInput');
    exit();
  }
  if(invalidUsername($username)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=invalidUsername');
    echo 'error=invalidUsername';
    exit();
  }
  if(invalidEmail($email)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=invalidEmail');
    exit();
  }
  if(pwdMatch($password,$repeatPwd)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=passwordsNoMatch');
    exit();
  }
  if(userExists($pdo,$username,$email)){
    header('Location: http://localhost/PasswordGenerator/frontpage.php?error=userExists');
    exit();
  }
  createUser($pdo,$username,$email,$password);
  header('Location: http://localhost/PasswordGenerator/frontpage.php?error=none');
  exit();
}else{
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}
?>
