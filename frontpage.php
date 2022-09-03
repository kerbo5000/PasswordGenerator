<?php
$usernameSignup = '';
$emailSignup ='';
$passwordSignup = '';
$repeatPwdSignup ='';
$usernameLogin = '';
$passwordLogin = '';
$errors = [];
include 'includes/phpComponents/signup.php';
include 'includes/phpComponents/login.php';
echo 'hiii';

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
  <div class="container">
    <div class="jumbotron">
      <div class="card">
        <div class="card-header">
          <p class="h1">Password Storage</p>
        </div>
        <div class="card-body">
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
                        <label class="form-label">Username/Email</label>
                        <input type="text" class="form-control" autocomplete="off" name="login-username" aria-describedby="emailHelp" value=<?php echo $usernameLogin?>>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Password</label>
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
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" autocomplete="off" aria-describedby="emailHelp" name="signup-email" value=<?php echo $emailSignup?>>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" autocomplete="off" aria-describedby="emailHelp" name="signup-username" value=<?php echo $usernameSignup?>>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="signup-password" value=<?php echo $passwordSignup?>>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Reapeat password</label>
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
      </div>
    </div>
  </div>
<script src="javascript/index.js"></script>
<?php if(isset($_POST['signup-submit'])):?>
  <script>const event = new Event('click');
            signupBtn.dispatchEvent(event);</script>
<?php endif ?>
</body>
</html>
