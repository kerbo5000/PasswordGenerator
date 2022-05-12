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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Password Generator</title>
</head>
<body>
  <!-- <div class="app">
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
</div> -->
<div class="container-sm">
  <div class="row">
    <p class="h1">Password Storage</p>
  </div>
  <div class="row">
    <div class="col align-self-center">
      <div class="row">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="login-btn" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"value="login">login</button>
            <button class="nav-link" id="signup-btn" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"value="signup">signup</button>
          </div>
        </nav>
      </div>
      <div class="row">
        <div class="tab-content mt-3" id="nav-tabContent">
          <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="nav-home-tab">
            <?php if(!empty($errors) && end($errors)=='login'&& array_pop($errors)):?>
              <div class="row">
                <div class="alert alert-danger" role="alert">
                  <?php foreach ($errors as $error):?>
                    <p class="mb-0"><?php echo $error ?></p>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif ?>
            <form action="frontpage.php" method="POST">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username/Email</label>
                <input type="text" class="form-control" name="login-username" aria-describedby="emailHelp" value=<?php echo $usernameLogin?>>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="login-password" value=<?php echo $passwordLogin?>>
              </div>
              <button type="submit" class="btn btn-primary" name="login-submit">Submit</button>
            </form>
          </div>
          <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="nav-profile-tab">
            <?php if(!empty($errors) && end($errors)=='signup'&& array_pop($errors)):?>
              <div class="row">
                <div class="alert alert-danger" role="alert">
                  <?php foreach ($errors as $error):?>
                    <p class="mb-0"><?php echo $error ?></p>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif ?>
            <form action="frontpage.php" method="POST">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" name="signup-email" value=<?php echo $emailSignup?>>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">usename</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" name="signup-username" value=<?php echo $usernameSignup?>>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="signup-password" value=<?php echo $passwordSignup?>>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Reapeat password</label>
                <input type="password" class="form-control" name="signup-repeat-password" value=<?php echo $repeatPwdSignup?>>
              </div>
              <button type="submit" class="btn btn-primary" name="signup-submit">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="index.js"></script>
<?php if(isset($_POST['signup-submit'])):?>
  <script>const event = new Event('click');
            signupBtn.dispatchEvent(event);</script>
<?php endif ?>
</body>
</html>
