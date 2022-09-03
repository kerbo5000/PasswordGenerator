<?php
// INSERT YOUR DATABASE CONNECTION DATA HERE
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$DB_HOST = $cleardb_url["host"]; //localhost
$DB_NAME = "heroku_3fb36c838d9f1bd"; //password_storage
$DB_USR = $cleardb_url["user"]; // root
$DB_PWD = $cleardb_url["pass"];
// encryption/decryption key
$private_key = "3sME4onR0Zbsybkeg8Ql4nLE5EAIfsjx20ybOV4N/5M="; //3sME4onR0Zbsybkeg8Ql4nLE5EAIfsjx20ybOV4N/5M=
// hashing key
$index_key = "CWjGRyEpefknC39hrTUnww=="; //CWjGRyEpefknC39hrTUnww==
$pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME",$DB_USR,$DB_PWD);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>

