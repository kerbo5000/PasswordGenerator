<?php
// INSERT YOUR DATABASE CONNECTION DATA HERE
$DB_HOST = ""; //localhost
$DB_PORT = ""; //3306
$DB_NAME = ""; //password_storage
$DB_USR = ""; // root
$DB_PWD = "";
// encryption/decryption key
$private_key = ""; //3sME4onR0Zbsybkeg8Ql4nLE5EAIfsjx20ybOV4N/5M=
// hashing key
$index_key = ""; //CWjGRyEpefknC39hrTUnww==
$pdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME",$DB_USR,$DB_PWD);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>
