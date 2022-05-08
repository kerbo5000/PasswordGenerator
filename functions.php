<?php
function missingSignupInput($username,$email,$password,$repeatPwd){
return (empty($username) ||  empty($email) ||  empty($password) || empty($repeatPwd));
}
function missingLoginInput($username,$password){
return (empty($username) || empty($password));
}
function invalidUsername($username){
  return (!preg_match('/^[a-zA-Z0-9]*$/',$username));
}

function invalidEmail($email){
  return (!filter_var($email,FILTER_VALIDATE_EMAIL));
}

function pwdMatch($password,$repeatPwd){
  return $password !== $repeatPwd;
}
function userExists($pdo,$username,$email){
  $statement = $pdo->prepare('SELECT * FROM users WHERE username = :user OR email = :email');
  $statement->bindValue(':user',$username);
  $statement->bindValue(':email',$email);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  if($result){
    return $result;
  }else{
    return false;
  }
}
function createUser($pdo,$username,$email,$password){
  $statement = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (:user, :email, :password)');
  $hashedPwd = password_hash($password,PASSWORD_DEFAULT);
  $statement->bindValue(':user',$username);
  $statement->bindValue(':email',$email);
  $statement->bindValue(':password',$hashedPwd);
  $statement->execute();
}
?>
