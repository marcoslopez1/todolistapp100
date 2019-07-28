<?php

//This php page only works in case se hit the submit button in the login portal
if(isset($_POST['login'])) {

  require 'dbh.inc.php';
  //Now we create the variables we are going to work with based on the user's imput
  $mailuid = $_POST['uid'];
  $password = $_POST['password'];

  //Now we check for errors:
  //First thing is to check if either the email or the password are empty
  if (empty($mailuid) || empty($password)) {
    header("Location: ../login.php?error=emptyfields");
    exit();
  }
  //Now we find the match for the users and the pass in the db
  else {
    $sql = "SELECT * FROM users WHERE (username=? OR email=?) and active='1';";
    $stmt = mysqli_stmt_init($conn);
    //In case the connection or the stmt didn't work
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../login.php?error=sqlerror");
      exit();
    }
    else {
      //In case of no error, then execute the stmt
      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      //In case the result we get is not empty, that means, we are getting a locale_filter_match
      if ($row = mysqli_fetch_assoc($result)) {
        //Now it seems the user exists in the db, we only need to check if the password allocated in our db (hashed) is the same as the one the user entered (hased as well)
        //This password_verify function returns a true or a false result
        $pwdCheck = password_verify($password, $row['password']);
        if ($pwdCheck == false) {
          header("Location: ../login.php?error=wrongpwd");
          exit();
        }
        //In case the password matchs
        else if ($pwdCheck == true) {
          //Here we define how much the session can be started withoutexplicitatly sign out, in seconds
          require '../config.php';
          //Now we start session
          session_start();
          setcookie(session_name(),session_id(),time()+$sessionlifetime);
          //Now we create the sessions variables with the values we get in return from the db after checking the match
          $_SESSION['username'] = $row['username'];
          $_SESSION['name'] = $row['name'];
          $_SESSION['userid'] = $row['id'];

          header("Location: ../login.php?login=success");
          exit();
        }
        //In case there is an error with our code
        else {
          header("Location: ../login.php?error=wrongpwd");
          exit();
        }
      }
      else {
        header("Location: ../login.php?error=nouser");
        exit();
      }
    }
  }


}
else {
  header("Location: ../login.php");
  exit();
}

?>
