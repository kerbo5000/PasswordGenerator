<?php
echo 'h18';

function invalidUsername($username){
  return (!preg_match('/^[a-zA-Z0-9]*$/',$username));
}
function invalidEmail($email){
  return (!filter_var($email,FILTER_VALIDATE_EMAIL));
}
function pwdMatch($password,$repeatPwd){
  return $password !== $repeatPwd;
}
function userExists($pdo,$username,$email,$private_key,$index_key){
  echo 'h19';

  $statement = $pdo->prepare('SELECT id,username,password FROM users WHERE usernameHash = :userHash OR emailHash = :emailHash LIMIT 1');
  echo 'h22';

  $statement->bindValue(':userHash',getHash($username,$index_key));
  echo 'h23';

  $statement->bindValue(':emailHash',getHash($email,$index_key));
  echo 'h24';

  $statement->execute();
  echo 'h25';

  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  echo $result;
  if($result){
    echo 'h20';
    return $result;
  }else{
    echo 'h21';
    return false;
  }
}
function createUser($pdo,$username,$email,$password,$private_key,$index_key){
  $statement = $pdo->prepare('INSERT INTO users (username, email, password,usernameHash,emailHash) VALUES (:user, :email, :password,:usernameHash,:emailHash)');
  $hashedPwd = password_hash($password,PASSWORD_DEFAULT);
  $statement->bindValue(':user',enc($username,$private_key));
  $statement->bindValue(':email',enc($email,$private_key));
  $statement->bindValue(':usernameHash',getHash($username,$index_key));
  $statement->bindValue(':emailHash',getHash($email,$index_key));
  $statement->bindValue(':password',$hashedPwd);
  $statement->execute();
  return;
}

function enc($data,$private_key){
  $key = base64_decode($private_key);
  $nonce_data = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
  $data = sodium_crypto_secretbox($data, $nonce_data, $key);
  $data = base64_encode($nonce_data . $data);
  return $data;
}
function dec($data,$private_key) {
  $decoded = base64_decode($data);
  $key = base64_decode($private_key);
  $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
  $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
  $plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
  return $plaintext;
}
function getHash($string,$index_key){
    
    try {
      echo 'h26';
      $index_key = base64_decode($index_key);
      $testtt = function_exists(sodium_crypto_pwhash);
      echo $testtt;

      $test = sodium_crypto_pwhash(32,$string,$index_key,SODIUM_CRYPTO_PWHASH_OPSLIMIT_MODERATE,SODIUM_CRYPTO_PWHASH_MEMLIMIT_MODERATE);
      echo $test;
      $hash = bin2hex($test);
      echo $hash;
      return $hash;
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
	}
?>
