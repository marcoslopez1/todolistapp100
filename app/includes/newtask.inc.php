
<?php

session_start();
require 'dbh.inc.php';

if (isset($_POST['name'])){
  $token = trim($_POST['name']);
  //Encryotion of the name of the task
  $cipher_method = 'aes-128-ctr';
  $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
  $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
  $name = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
  //unset($token, $cipher_method, $enc_key, $enc_iv);


  if(!empty($name)){
    $addedQuery = $db->prepare("
      INSERT INTO items (name, userid, done, created)
      VALUES (:name, :user, 0, NOW())
    ");

    $addedQuery->execute([
      'name' => $name,
      'user' => $_SESSION['userid'],
    ]);
  }
}

header('Location: ../todos.php');

?>
