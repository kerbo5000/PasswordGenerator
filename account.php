<?php
  if(!isset($_GET['id'])){
    header('Location: http://localhost/PasswordGenerator/frontpage.php');
    exit();
  }
  include 'dbconnection.php';
  $statement = $pdo->prepare('SELECT * FROM accounts WHERE userID = :userid');
  $statement->bindValue(':userid',$_GET['id']);
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
            <li><a href="account.php?id=<?php echo $_GET['id']?>">view accounts</a></li>
            <li><a href="addAccount.php?id=<?php echo $_GET['id']?>">add account</a></li>
            <li><a href="settings.php?id=<?php echo $_GET['id']?>">settings</a></li>
            <li><a href="logout.php?id=<?php echo $_GET['id']?>">logout</a></li>
          </ul>
        </nav>
      </div>
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
            </tr>
          <?php endforeach; ?>
        </tbody>
    </div>
  </div>
</body>
</html>
