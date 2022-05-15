<?php include_once __DIR__.'/../extraComponents/functions.php';?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Account Name</th>
      <th scope="col">Email</th>
      <th scope="col">Username</th>
      <th scope="col">Password</th>
      <th scope="col">Actions</th>
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
          <button  type='submit' class="btn btn-outline-warning edit-btn" value=<?php echo $account['accountID'] ?> >Edit</button>
          <form action="account.php" method="post" style="display:inline-block;">
            <input type="hidden" name="actID" value=<?php echo $account['accountID'] ?>>
            <input class="btn btn-outline-danger" name="id-delete" type="submit" value="Delete">
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
