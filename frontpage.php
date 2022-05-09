<?php
  $usernameSignup = '';
  $emailSignup ='';
  $passwordSignup = '';
  $repeatPwdSignup ='';
  $usernameLogin = '';
  $passwordLogin = '';
  $errors = [];
  include 'signup.php';
  include 'login.php';
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
            <li><button type="button" id="login-btn" value="login">login</button></li>
            <li><button type="button" id="signup-btn" value="signup">sign up</button></li>
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
      <div class="tab" id="login">
        <h2>login</h2>
        <form action="frontpage.php" method="POST">
          <label>Username</label><br>
          <input type="text"  name="login-username" value=<?php echo $usernameLogin?>><br>
          <label>Password</label><br>
          <input type="password" name="login-password" value=<?php echo $passwordLogin?>><br>
          <input type="submit" name="login-submit">
        </form>
      </div>
      <div class="tab" id="signup" style="display:none;" >
        <h2>sign up</h2>
        <form action="frontpage.php" method="POST">
          <label>Username</label><br>
          <input type="text" name="signup-username" value=<?php echo $usernameSignup?>><br>
          <label>Email</label><br>
          <input type="text" name="signup-email" value=<?php echo $emailSignup?>><br>
          <label>Password</label><br>
          <input type="password" name="signup-password" value=<?php echo $passwordSignup?>><br>
          <label>Repeat Password</label><br>
          <input type="password" name="signup-repeat-password" value=<?php echo $repeatPwdSignup?>><br>
          <input type="submit" name="signup-submit">
        </form>
      </div>
      <?php if(isset($_POST['signup-submit'])):?>
          <script>document.getElementById('login').style.display='none';
          document.getElementById('signup').style.display='';</script>
      <?php endif ?>
    </div>
  </div>
  <script src="index.js"></script>
</body>
</html>
