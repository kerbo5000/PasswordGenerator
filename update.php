<?php
if(!isset($_SESSION)){
  session_start();
}
  if(!isset($_SESSION['id'])){
    header('Location: http://localhost/PasswordGenerator/frontpage.php');
    exit();
  }
  //include 'dbconnection.php';
  // include 'config.php';
  // include 'functions.php';
echo 'byeeeeee';
  //echo base64_decode($_GET['id']).'<br>';
  if(isset($_POST['id-pre-edit'])){
    echo 'bye';
    echo '<br>';
    echo $_POST['actID'];
    echo '<br>';
    $statement = $pdo->prepare('SELECT * FROM accounts WHERE accountID = :accountid');
    $statement->bindValue(':accountid',$_POST['actID']);
    $statement->execute();
    $resultUpdate = $statement->fetchAll(PDO::FETCH_ASSOC);
    var_dump($resultUpdate);
    $accountNameEdit = $resultUpdate[0]['accountName'];
    $usernameEdit = dec($resultUpdate[0]['username'],$private_key);
    $emailEdit = dec($resultUpdate[0]['email'],$private_key);
    $passwordEdit = dec($resultUpdate[0]['password'],$private_key);
    // $errors = [];
    if(isset($_POST['id-edit'])){
      echo 'hiii';
      $usernameEdit = $_POST['username'];
      $emailEdit = $_POST['email'];
      $passwordEdit = $_POST['password'];
      if(!empty($emailEdit)){
        if(invalidEmail($emailEdit)){
          $emailEdit = '';
          $errors[] ='email is invalid';
        }
      }else if(!in_array('missing inputs',$errors)){
        $errors[] ='missing inputs';
      }
      if(empty($accountNameEdit) || empty($passwordEdit)||empty($usernameEdit)){
        if(!in_array('missing inputs',$errors)){
          $errors[] ='missing inputs';
        }
      }
      if(empty($errors)){
        $statement = $pdo->prepare('UPDATE accounts SET username = :user, email = :email, password = :password,accountName =:accountName WHERE accountID = :accountid' );
        // $hashedPwd = password_hash($password,PASSWORD_DEFAULT);
        $statement->bindValue(':user',enc($usernameEdit,$private_key));
        $statement->bindValue(':accountName',$accountNameEdit);
        $statement->bindValue(':email',enc($emailEdit,$private_key));
        $statement->bindValue(':password',enc($passwordEdit,$private_key));
        $statement->bindValue(':accountid',$_POSt['actID']);
        $statement->execute();
        $success[] = 'Account has been updated';
        $success[] = 'warning';
        // header('Location: http://localhost/PasswordGenerator/account.php');
        // exit();
      }else{
        echo 'hi';
        $errors[] = 'edit';
        $urlErrors = '&errors='.urlencode(serialize($errors));
        $data = '&accountName='.$accountNameEdit.'&username='.$usernameEdit.'&email='.$emailEdit.'&password='.$passwordEdit;
        header('Location: http://localhost/PasswordGenerator/account.php?id='.$_POST['actID'].$urlErrors.$data);
      }
    }
  }

?>
<!-- <!DOCTYPE html>
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
        <form  action="update.php?id=<?php echo $_GET['id']?>" method="POST">
          <label>Account Name</label><br>
          <input type="text" name="account-name" disabled value=<?php echo $accountName?>><br>
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
</html> -->
