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
$result;
$errors = [];
$success = [];
include 'config.php';
include 'functions.php';
include 'addAccount.php';
include 'delete.php';
include 'display.php';
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
<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <?php if(!empty($errors) && end($errors)=='addAccount'&& array_pop($errors)):?>
              <div class="row">
                <div class="alert alert-danger" role="alert">
                  <?php foreach ($errors as $error):?>
                    <p class="mb-0"><?php echo $error ?></p>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php $errors[] = 'addAccount';?>
            <?php endif ?>
            <form action="account.php" method="POST">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Account Name</label>
                <input type="text" class="form-control" name="account-name" value=<?php echo $accountName?>>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" name="email" value=<?php echo $email?>>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" name="username" value=<?php echo $username?>>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <div class="d-grid gap-2 d-md-block mb-3">
                  <button type="button" class="btn btn-primary" id='manual'>Manual</button>
                  <button type="button" class="btn btn-primary" id='generate'>Generate</button>
                </div>
                <input class="form-control" id="password" type="text" aria-label="Disabled input example" disabled name="password" value=<?php echo $password?>>
              </div>
              <input type="submit" class="btn btn-primary" name="submit">
            </form>
          </div>
          <div class="col" id="form-div" style="display:none;">
            <form id="pwd-generator" >
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password length</label>
                <input type="number" class="form-control" id="length">
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="0" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                  Numbers
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked1" >
                <label class="form-check-label" for="flexCheckChecked1">
                  Lower case letters
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="2" id="flexCheckChecked2" >
                <label class="form-check-label" for="flexCheckChecked2">
                  Upper case letters
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="3" id="flexCheckChecked3">
                <label class="form-check-label" for="flexCheckChecked3">
                  Special characters (!@#$%^*?|~&)
                </label>
              </div>
              <button type="submit" class="btn btn-primary">Generate</button>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <?php if(!empty($errors) && end($errors)=='edit'&& array_pop($errors)):?>
              <div class="row">
                <div class="alert alert-danger" role="alert">
                  <?php foreach ($errors as $error):?>
                    <p class="mb-0"><?php echo $error ?></p>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php $errors[] = 'edit';?>
            <?php endif ?>
            <form action="account.php" method="POST">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Account Name</label>
                <input type="text" class="form-control" name="account-name" value=<?php echo $accountNameEdit?>>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" name="email" value=<?php echo $emailEdit?>>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" name="username" value=<?php echo $usernameEdit?>>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <div class="d-grid gap-2 d-md-block mb-3">
                  <button type="button" class="btn btn-primary" id='manual'>Manual</button>
                  <button type="button" class="btn btn-primary" id='generate'>Generate</button>
                </div>
                <input class="form-control" id="password" type="text" aria-label="Disabled input example" disabled name="password" value=<?php echo $passwordEdit?>>
              </div>
              <input type="submit" class="btn btn-primary" name="submit">
              <input type="hidden" name="actID" id='hidden-edit'>
                  <input class="btn btn-outline-warning" name="id-edit" type="submit" value="Edit"data-bs-toggle="modal" data-bs-target="#edit">
            </form>
          </div>
          <div class="col" id="form-div" style="display:none;">
            <form id="pwd-generator" >
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password length</label>
                <input type="number" class="form-control" id="length">
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="0" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                  Numbers
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked1" >
                <label class="form-check-label" for="flexCheckChecked1">
                  Lower case letters
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="2" id="flexCheckChecked2" >
                <label class="form-check-label" for="flexCheckChecked2">
                  Upper case letters
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="3" id="flexCheckChecked3">
                <label class="form-check-label" for="flexCheckChecked3">
                  Special characters (!@#$%^*?|~&)
                </label>
              </div>
              <button type="submit" class="btn btn-primary">Generate</button>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
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
      <form action="account.php" method="post">
        <div class="row mb-3">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Search</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="search">
          </div>
        </div>
        <fieldset class="row mb-3">
          <legend class="col-form-label col-sm-2 pt-0">Options</legend>
          <div class="col-sm-10">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="filter" value="accountName" id="gridRadios1">
              <label class="form-check-label" for="gridRadios1">
                Account Name
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="filter" value="email" id="gridRadios2" >
              <label class="form-check-label" for="gridRadios2">
                Email
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="filter" value="username" id="gridRadios3">
              <label class="form-check-label" for="gridRadios3">
                Username
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="filter" value="password" id="gridRadios4">
              <label class="form-check-label" for="gridRadios4">
                Password
              </label>
            </div>
          </div>
        </fieldset>
        <div class="row">
          <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary" name="search-btn">Search</button>
          </div>
        </div>
        <?php if(!empty($errors) && end($errors)=='filter'&& array_pop($errors)):?>
          <div class="row">
            <div class="alert alert-danger" role="alert">
              <?php foreach ($errors as $error):?>
                <p class="mb-0"><?php echo $error ?></p>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif ?>
      </form>
      <div class="row">
        <div class="col-md-12">
          <button  class="btn btn-primary" id="add-btn"data-bs-toggle="modal" data-bs-target="#add">Add Account</button>
        </div>
      </div>
      <?php if(!empty($errors) && end($errors)=='addAccount'&& array_pop($errors)):?>
        <script>const event = new Event('click');
                  document.getElementById('add-btn').dispatchEvent(event);</script>
      <?php endif ?>
      <?php if(!empty($errors) && end($errors)=='edit'&& array_pop($errors)):?>
        <script>const event = new Event('click');
                  document.getElementById('add-btn').dispatchEvent(event);</script>
      <?php endif ?>
      <?php if(!empty($success) && $color = array_pop($success)):?>
        <div class="row mt-3">
          <div class="alert alert-<?php echo $color?>" role="alert">
              <p class="mb-0"><?php echo $success[0] ?></p>
          </div>
        </div>
      <?php endif ?>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Account Name</th>
            <th scope="col">Email</th>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $i=> $account):?>
            <tr>
              <th scope="row"><?php echo $i+1 ?></th>
              <td><?php echo $account['accountName'] ?></td>
              <td><?php echo dec($account['email'],$private_key) ?></td>
              <td><?php echo dec($account['username'],$private_key) ?></td>
              <td><?php echo dec($account['password'],$private_key) ?></td>
              <td>
                <!-- <form action="account.php" method="post" style="display:inline-block;">
                  <input type="hidden" name="actID" value=<?php echo base64_encode($account['accountID']);
                  ?>>
                  <input class="btn btn-outline-warning" name="id-edit" type="submit" value="Edit"data-bs-toggle="modal" data-bs-target="#edit">
                </form> -->
                <button  class="btn btn-outline-warning edit-btn"data-bs-toggle="modal" data-bs-target="#edit" value=<?php echo base64_encode($account['accountID']);
                ?>>Edit</button>
                 <!-- <a class="btn btn-outline-warning" href="http://localhost/PasswordGenerator/update.php?id=<?php echo base64_encode($account['accountID'])
                ?>" role="button">Edit</a> -->
                <form action="account.php" method="post" style="display:inline-block;">
                  <input type="hidden" name="actID" value=<?php echo $account['accountID'] ?>>
                  <input class="btn btn-outline-danger" name="id-delete" type="submit" value="Delete">
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<script>
  const hiddenEdit = document.getElementById('hidden-edit');
  Array.from(document.getElementsByClassName('edit-btn')).forEach((item) => {
    item.addEventListener('click',()=>{
      hiddenEdit.value = item.value;
    })
  });
</script>
<script src="generate.js"></script>
</body>
</html>
