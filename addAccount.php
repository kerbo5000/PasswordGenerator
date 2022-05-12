<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['id'])){
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}
// $accountName = '';
// $username = '';
// $email = '';
// $password = '';
// $errors = [];
if(isset($_POST['submit'])){
  $accountName = $_POST['account-name'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  if(isset($_POST['password'])){
    $password = $_POST['password'];
  }else{
    $password = "";
  }

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
    $statement = $pdo->prepare('INSERT INTO accounts (username, email, password,accountName,userID,usernameHash,emailHash,passwordHash) VALUES (:user, :email, :password,:accountName,:userid,:usernameHash,:emailHash,:passwordHash)');
    // $hashedPwd = password_hash($password,PASSWORD_DEFAULT);
    $statement->bindValue(':user',enc($username,$private_key));
    $statement->bindValue(':accountName',$accountName);
    $statement->bindValue(':email',enc($email,$private_key));
    $statement->bindValue(':password',enc($password,$private_key));
    $statement->bindValue(':usernameHash',getHash($username,$index_key));
    $statement->bindValue(':emailHash',getHash($email,$index_key));
    $statement->bindValue(':passwordHash',getHash($password,$index_key));
    $statement->bindValue(':userid',$_SESSION['id']);
    $statement->execute();
    // header('Location: http://localhost/PasswordGenerator/account.php');
    // exit();
    $success[] = 'Account has been added';
    $success[] = 'success';
  }else{
    $errors[] = 'addAccount';
    // header('Location: http://localhost/PasswordGenerator/account.php');
    // exit();
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
  <link  rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
        <h2>add account</h2>
        <!-- <form  action="addAccount.php" method="POST">
        <label>Account Name</label><br>
        <input type="text" name="account-name" value=<?php echo $accountName?>><br>
        <label>Username</label><br>
        <input type="text" name="username" value=<?php echo $username?>><br>
        <label>Email</label><br>
        <input type="text" name="email" value=<?php echo $email?>><br>
        <label>Password</label><br>
        <div>
        <button type="button" id='manual'>manual</button>
        <button type="button" id='generate'>generate</button>
      </div>
      <input type="text" id="password" disabled name="password" value=<?php echo $password?>><br>
      <input type="submit" name="submit">
    </form>
    <form id="pwd-generator" style="display:none;" >
      <label>passwod length</label>
      <input type="number" id="length"><br>
      <label>numbers</label>
      <input type="checkbox" value="0" ><br>
      <label>lower case</label>
      <input type="checkbox" value="1" ><br>
      <label>upper case</label>
      <input type="checkbox" value="2" ><br>
      <label>special characters(!@#$%^*?|~&)</label>
      <input type="checkbox" value="3" ><br>
      <input type="submit" value="generate">
    </form>
  </div>
</div>
</div>
<div class="container">
  <div class="jumbotron">
    <div class="card">
      <div class="card-header">
        <p class="h1">Password Storage</p>
      </div>
      <div class="card-body">
        <h5 class="card-title">Display Accounts</h5>
        <div class="row">
          <nav class="nav">
            <a class="nav-link" href="account.php">view accounts</a>
            <a class="nav-link" href="addAccount.php">add account</a>
            <a class="nav-link" href="logout.php">logout</a>
          </nav>
        </div>
        <?php if(!empty($errors)):?>
          <div class="row">
            <div class="alert alert-danger" role="alert">
              <?php foreach ($errors as $error):?>
                <p class="mb-0"><?php echo $error ?></p>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif ?>
        <div class="row">
          <p class="h1">Add account</p>
        </div>
        <div class="row">
          <form action="frontpage.php" method="POST">
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Account Name</label>
              <input type="text" class="form-control" name="account-name" value=<?php echo $accountName?>>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input type="email" class="form-control" aria-describedby="emailHelp" name="email" value=<?php echo $email?>>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Usename</label>
              <input type="email" class="form-control" aria-describedby="emailHelp" name="username" value=<?php echo $username?>>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <div class="d-grid gap-2 d-md-block mb-3">
                <button type="button" class="btn btn-primary" id='manual'>Manual</button>
                <button type="button" class="btn btn-primary" id='generate'>Generate</button>
              </div>
              <input class="form-control" id="password" type="text" aria-label="Disabled input example" disabled name="password" value=<?php echo $password?>>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
          </form>
        </div>

  </div>
  </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="generate.js"></script>
</body>
</html> -->
