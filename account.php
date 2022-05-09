<?php
  session_start();
  if(!isset($_SESSION['id'])){
    header('Location: http://localhost/PasswordGenerator/frontpage.php');
    exit();
  }
  include 'dbconnection.php';
  if(isset($_GET['search']) && isset($_GET['filter'])&& !empty($_GET['search'])){
    switch($_GET['filter']){
      case 'accountName':
        $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND accountName = :search');
        break;
      case 'email':
        $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND email = :search');
        break;
      case 'username':
        $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND username = :search');
        break;
      case 'password':
        $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid AND password = :search');
        break;
    }
    $statement->bindValue(':search',$_GET['search']);
  }else{
    $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid');
  }
  $statement->bindValue(':userid',$_SESSION['id']);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <link  rel="preconnect" href="https://fonts.gstatic.com">
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
      <form action="account.php" method="get">
        <div>
          <input type="radio" name="filter" value="accountName">
          <label>account name</label><br>
          <input type="radio" name="filter" value="email">
          <label>email</label><br>
          <input type="radio" name="filter" value="username">
          <label>username</label><br>
          <input type="radio" name="filter" value="password">
          <label>password</label><br>
        </div>
          <input type="text" name="search" placeholder="search">
          <input type="submit">
      </form>
      <table>
        <thead>
          <tr>
            <td>Account name</td>
            <td>email</td>
            <td>username</td>
            <td>password</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $account):?>
            <tr>
              <td><?php echo $account['accountName'] ?></td>
              <td><?php echo $account['email'] ?></td>
              <td><?php echo $account['username'] ?></td>
              <td><?php echo $account['password'] ?></td>
              <td>
                <a href="http://localhost/PasswordGenerator/update.php?id=<?php echo $account['accountID'] ?>">edit</a>
                <form action="delete.php" method="post">
                  <input type="hidden" name="actID" value=<?php echo $account['accountID'] ?>>
                  <input type="submit" name="id-delete" value="delete">
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
    </div>
  </div>
</body>
</html>
