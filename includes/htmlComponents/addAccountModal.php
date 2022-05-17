<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Add account</h5>
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
                <label class="form-label">Account Name</label>
                <input type="text" class="form-control" name="account-name" autocomplete="off" value=<?php echo $accountName?>>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" autocomplete="off" name="email" value=<?php echo $email?>>
              </div>
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" autocomplete="off" name="username" value=<?php echo $username?>>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="d-grid gap-2 d-md-block mb-3">
                  <button type="button" class="btn btn-primary manual">Manual</button>
                  <button type="button" class="btn btn-primary generate">Generate</button>
                </div>
                <input class="form-control password" type="text" autocomplete="off" aria-label="Disabled input example" readonly name="password" value=<?php echo $password?>>
              </div>
              <input type="submit" class="btn btn-primary" autocomplete="off" name="submit">
            </form>
          </div>
          <?php include 'pwdGenerator.html'?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-2" data-bs-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>
