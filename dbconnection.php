<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=password_storage','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>
