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
  <h1>Passeord Storage</h1>
  <div class="container">
    <div class="navigation">
      <nav>
        <ul>
          <li><button type="button" id="login-btn" value="login">login</button></li>
          <li><button type="button" id="signup-btn" value="signup">sign up</button></li>
        </ul>
      </nav>
    </div>
    <div class="tab" id="login">
      <h2>login</h2>
      <form class="" action="login.php" method="POST">
        <label>Username</label><br>
        <input type="text"  name="login-username"><br>
        <label>Password</label><br>
        <input type="password" name="login-password"><br>
        <input type="submit" name="login-submit">
      </form>
    </div>
    <div class="tab" id="signup" style="display:none;" >
      <h2>sign up</h2>
      <form class="" action="signup.php" method="POST">
        <label>Username</label><br>
        <input type="text" name="signup-username"><br>
        <label>Email</label><br>
        <input type="text" name="signup-email"><br>
        <label>Password</label><br>
        <input type="password" name="signup-password"><br>
        <label>Repeat Password</label><br>
        <input type="password" name="signup-repeat-password"><br>
        <input type="submit" name="signup-submit">
      </form>
    </div>
    <?php
    if(isset($_GET['error'])){
      switch($_GET['error']){
        case 'missingInput':
          echo'<h2> missing inputs</h2>';
          break;
        case 'invalidUsername':
          echo'<h2> username is invalid</h2>';
          break;
        case 'invalidEmail':
          echo'<h2> email is invalid</h2>';
          break;
        case 'passwordsNoMatch':
          echo "<h2>the passwords don't match</h2>";
          break;
        case 'userExists':
          echo'<h2>username or email already used</h2>';
          break;
        default:
          echo'<h2> your account has been created</h2>';
          break;
      }
    }
    ?>
  </div>
</div>
</body>
<script src="index.js">
</script>
</html>
