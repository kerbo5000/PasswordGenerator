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
  <div class="d-grid gap-2 d-md-block mb-3 text-end">
    <button type="submit" class="btn btn-primary" name="search-btn">Search</button>
    <button type="submit" class="btn btn-primary">Reset</button>
  </div>
</form>
