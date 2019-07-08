<?php

if(isset($_POST['send_email'])){

  require 'dbh.inc.php';
  $email = $_POST['email'];
  if (empty($email)) {
    header("Location: ../forgottenpwd.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "SELECT username FROM users WHERE (username=? and active ='1')";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../forgottenpwd.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 1) {
        header("Location: ../forgottenpwd.php?error=usertaken");
        exit();
      }
      //But incase the username nor the email are taken, then we are going to actually create the username in the database
      else {
        $sql = "SELECT username FROM users WHERE email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../forgottenpwd.php?error=sqlerror");
          exit();
        }
        else {
          //For recovering password url construction
          //$hashedemail = password_hash($email, PASSWORD_DEFAULT);
          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);

          header("Location: phpmailer_forgottenpwd.php?email=".$email);
          exit();
        }
      }
    }
  }
  //Now we are closing the connection to save resources.
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  //And finally, if the user didn't send the POST form the signup.php page, we are going to send him back to that page without further action
  } else {
    header("Location: ../forgottenpwd.php");
    exit();
  }



?>
