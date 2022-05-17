<?php
session_start();
if(!isset($_SESSION['id'])){
  header('Location: http://localhost/PasswordGenerator/frontpage.php');
  exit();
}
$username = '';
$email ='';
$password = '';
$accountName ='';
$usernameEdit = '';
$emailEdit = '';
$passwordEdit = '';
$accountNameEdit = '';
$result;
$errors = [];
$success = [];
include 'includes/phpComponents/logout.php';
include 'includes/phpComponents/addAccount.php';
include 'includes/phpComponents/update.php';
include 'includes/phpComponents/delete.php';
include 'includes/phpComponents/display.php';
if(isset($_GET['id'])){
  $errors = unserialize($_GET['errors']);
  $usernameEdit = $_GET['username'];
  $emailEdit =$_GET['email'];
  $passwordEdit = $_GET['password'];
  $accountNameEdit =$_GET['accountName'];
}
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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <title>Password Generator</title>
</head>
<body>
  <?php if(!empty($success) && $success[1] == 'success'){
    $username = '';
    $email ='';
    $password = '';
    $accountName ='';
  } ?>
  <?php include 'includes/htmlComponents/addAccountModal.php';?>
  <?php include 'includes/htmlComponents/editModal.php';?>
  <div class="container">
    <div class="jumbotron">
      <div class="card">
        <div class="card-header">
          <div class="row justify-content-between align-items-center">
            <div class="col">
              <p class="h1">Password Storage</p>
            </div>
            <div class="col-4 text-end">
              <form method="post">
                <button type='submit' class="btn btn-danger" name='logout'>Logout</button>
              </form>
            </div>
          </div>
          <p class="h5" id='user'> Hi, <?php echo $_SESSION['username'];?></p>
        </div>
        <div class="card-body">
          <h5 class="card-title">Display Accounts</h5>
          <?php include 'includes/htmlComponents/filter.php';?>
        <div class="row">
          <div class="col-md-12">
            <button  class="btn btn-primary" id="add-btn"data-bs-toggle="modal" data-bs-target="#add">Add Account</button>
          </div>
        </div>
        <?php if(!empty($errors) && end($errors)=='addAccount'):?>
          <script>const event = new Event('click');
          document.getElementById('add-btn').dispatchEvent(event);</script>
        <?php endif ?>
        <?php if((!empty($errors) && end($errors)=='edit')):?>
          <script>const event = new Event('click');
          document.getElementById('dummy').dispatchEvent(event);
          const hiddenEditError = document.getElementById('hidden-edit');
          <?php if(isset($_GET['id']))
          echo 'hiddenEditError.value ='.base64_decode($_GET['id']);
          ?>
          </script>
        <?php endif ?>
        <?php if(!empty($success) ):?>
          <div class="row mt-3">
            <div class="alert alert-<?php echo $success[1]?>" role="alert">
              <p class="mb-0"><?php echo $success[0] ?></p>
            </div>
          </div>
        <?php endif ?>
        <?php if(!empty($errors) && end($errors)=='filter'&& array_pop($errors)):?>
          <div class="row mt-3">
            <div class="alert alert-danger" role="alert">
              <?php foreach ($errors as $error):?>
                <p class="mb-0"><?php echo $error ?></p>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif ?>
        <div class="overflow-auto">
          <?php include 'includes/htmlComponents/displayTable.php';?>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="javascript/generate.js"></script>
<?php if(!empty($success) && $success[1] == 'success'):?>
  <script>
    const event = new Event('click');
    close[0].dispatchEvent(event);
  </script>
<?php endif?>
</body>
</html>
