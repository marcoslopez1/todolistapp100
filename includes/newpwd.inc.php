<?php

require 'dbh.inc.php';

// first we read the variables from the newpwd.php page
$email = $_POST['email'];
$hashedemail = $_POST['hashedemail'];
$password = $_POST['password'];
$passwordRepeat = $_POST['repassword'];


if(isset($_POST['change_password'])){

  if (empty($password) || empty($passwordRepeat)) {
    header("Location: ../newpwd.php?error=emptyfields");
    exit();
  } else {
    if($password !== $passwordRepeat) {
      header("Location: ../newpwd.php?error=passwordcheck");
      exit();
    } else {

      $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
      $sql = "UPDATE users SET password=? WHERE email=?";
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../newpwd.php?error=sqlerror");
        exit();
      }
      else {
        mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $email);
        mysqli_stmt_execute($stmt);

        //And now we return a success message
        header("Location: ../newpwd.php?pwd=changed");
        exit();
      }
    }
  }
} else {
  header("Location: ../newpwd.php");
  exit();
}



?>
