<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add account</h5>
        <button type="button" class="btn-close close-1" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col modal-input">
            <?php if(!empty($errors) && end($errors)=='addAccount'&& array_pop($errors)):?>
              <div class="row modal-errors">
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
                  <button type="button" class="btn btn-primary manual">Manual</button>
                  <button type="button" class="btn btn-primary generate">Generate</button>
                </div>
                <input class="form-control password" type="text" aria-label="Disabled input example" readonly name="password" value=<?php echo $password?>>
              </div>
              <input type="submit" class="btn btn-primary" name="submit">
            </form>
          </div>
          <div class="col pwd-div" style="display:none;">
            <form class="pwd-generator" >
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password length</label>
                <input type="number" class="form-control length">
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
        <button type="button" class="btn btn-secondary close-2" data-bs-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>
