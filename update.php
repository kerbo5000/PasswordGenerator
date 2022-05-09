<?php
  session_start();
  echo isset($_GET['id']).'<br>';
  echo $_GET['id'];
  if(!(isset($_SESSION['id']) && isset($_GET['id']))){
    header('Location: http://localhost/PasswordGenerator/frontpage.php');
    exit();
  }
  include 'dbconnection.php';
  $statement = $pdo->prepare('SELECT * FROM accounts WHERE accountID = :accountid');
  $statement->bindValue(':accountid',$_GET['id']);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $accountName = $result[0]['accountName'];
  $username = $result[0]['username'];
  $email = $result[0]['email'];
  $password = $result[0]['password'];
  $errors = [];
  if(isset($_POST['submit'])){
    $accountName = $_POST['account-name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    include 'functions.php';
    if(!empty($email)){
      if(invalidEmail($email)){
        $email = '';
        $errors[] ='email is invalid';
      }
    }else if(!in_array('missing inputs',$errors)){
      $errors[] ='missing inputs';
    }
    if(empty($accountName) || empty($password)||empty($username)){
      if(!in_array('missing inputs',$errors)){
        $errors[] ='missing inputs';
      }
    }
    if(empty($errors)){
      $statement = $pdo->prepare('UPDATE accounts SET username = :user, email = :email, password = :password,accountName =:accountName WHERE accountID = :accountid' );
      // $hashedPwd = password_hash($password,PASSWORD_DEFAULT);
      $statement->bindValue(':user',$username);
      $statement->bindValue(':accountName',$accountName);
      $statement->bindValue(':email',$email);
      $statement->bindValue(':password',$password);
      $statement->bindValue(':accountid',$_GET['id']);
      $statement->execute();
      header('Location: http://localhost/PasswordGenerator/account.php');
      exit();
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <title>Password Generator</title>
</head>
<body>
  <div class="app">
    <h1>Password Storage</h1>
    <div class="container">
      <div class="navigation">
        <nav>
          <ul>
            <li><a href="account.php">view accounts</a></li>
            <li><a href="addAccount.php">add account</a></li>
            <li><a href="logout.php">logout</a></li>
          </ul>
        </nav>
      </div>
      <?php if(!empty($errors)):?>
        <div>
          <?php foreach ($errors as $error):?>
            <p><?php echo $error ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif ?>
      <div>
        <h2>update account</h2>
        <form  action="update.php?id=<?php echo $_GET['id'] ?>" method="POST">
          <label>Account Name</label><br>
          <input type="text" name="account-name" value=<?php echo $accountName?>><br>
          <label>Username</label><br>
          <input type="text" name="username" value=<?php echo $username?>><br>
          <label>Email</label><br>
          <input type="text" name="email" value=<?php echo $email?>><br>
          <label>Password</label><br>
          <input type="text" name="password" value=<?php echo $password?>><br>
          <input type="submit" name="submit">
        </form>
      </div>
    </div>
  </div>
</body>
</html>