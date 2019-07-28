<?php

//This page is only accesible if users hit the Submit button in the "signup.php" page. Therefore, even if we write thte path in the browsers, this document will not work. The condition to work is defined in the "if" statement that checks if the 'signup-submit' value from the "signup.php" page is actually "POSTed"

if(isset($_POST['create_account'])){

  require 'dbh.inc.php';

  //Now variables as assigned from the "signup.php" with the POST method and their "names" in that page.
  $email = $_POST['email'];
  $username = $_POST['username'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $passwordRepeat = $_POST['repassword'];
  if ($_POST["terms"] == "1") {
    $terms = "terms";
  } else {
    $terms = NULL;
  }
  $active = "0";
  $banned = "0";

  //Now we're gonna check for errors in the registration date_create_from_format
  //First if the all the fields are not empty:
  if (empty($email) || empty($username) || empty($name) || empty($password) || empty($passwordRepeat) || empty($terms)) {
    //We are redirecting to thr signup.php page again with some of the fields as defined before for the user, and for that we are building an url like this:
    header("Location: ../signup.php?error=emptyfields&email=".$email."&username=".$username."&name=".$name);
    //in case there is a mistake, we don't want to continue, therefore we need to break the php with an exit option
    exit();
  } // Now the next possible errors.
  //Starting with the invalid email error.
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signup.php?error=invalidmail&username=".$username."&name=".$name);
    exit();
  }//Checking valid Username, basically without speciall characters
  else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../signup.php?error=invaliduid&email=".$email."&name=".$name);
    exit();
  }//Checking valid Username and valid email at the same time
  else if(!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../signup.php?error=invalidemailandusername&name=".$name);
    exit();
  }//Checking if 2 passwords match and are equal
  else if($password !== $passwordRepeat) {
    header("Location: ../signup.php?error=passwordcheck&username=".$username."&email=".$email."&name=".$name);
    exit();
  }
  //Terms have to be accepted
  else if($password !== $passwordRepeat) {
    header("Location: ../signup.php?error=passwordcheck&username=".$username."&email=".$email."&name=".$name);
    exit();
  }//Checking if the username entered already exists
  else {
    //We look for an username with the same username or email existing already in the db
    $sql = "SELECT username FROM users WHERE (username=? OR email=?)";
    //In order to trigger the estatment, we need to refer to the connection variable in the dbh.inc.php page
    $stmt = mysqli_stmt_init($conn);
    //Now we are checkin if the query with the connection fails or not, and in case it fails, we are returning an error
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../signup.php?error=sqlerror");
      exit();
    }
    //In case no errors find, we are sending the information to the database, to create new users
    else {
      //The s means we are using the variable $username as a string. And this is related to the question mark (?) we put in the query before, because we don't want MySQL injection, we want to treat users imput as a string, not as MySQL code.
      mysqli_stmt_bind_param($stmt, "ss", $username, $email);
      mysqli_stmt_execute($stmt);
      //Now we save the result in the stmt, because it may happen that already an user exists with that given username
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      //This means basically that if we get 0 lines of result, it means no users witht that username already in the database. But if we get 1 o more, then we have an username with that username in the db
      if ($resultCheck > 0) {
        header("Location: ../signup.php?error=usertaken&username=".$username."&email=".$email."&name=".$name);
        exit();
      }
      //But incase the username nor the email are taken, then we are going to actually create the username in the database
      else {
        $sql = "INSERT INTO users (name, username, email, hashedemail, password, active, banned) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../signup.php?error=sqlerror");
          exit();
        }
        else {
          //We are hashing the password, in case we have a bridge in the db, hackers could not see it as the users wrote it down, creating a new variable
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          //For recovering password url construction
          $emailmodified = "sdflkvj209".$email."lquq30u1go";
          $hashedemail = strrev($emailmodified);
          mysqli_stmt_bind_param($stmt, "sssssss", $name, $username, $email, $hashedemail, $hashedPwd, $active, $banned);
          mysqli_stmt_execute($stmt);

          //Create a new email and send it out to activate the user:
          //$subject = "To Do List Application - Activate your user";
          //$send_to = $email;
          //$titulo = 'Message from the web';
          //$header = 'From: ' . $email;
          //$msjCorreo = "Hello, $name,\nWe have received your new user request. To activate your user, please, ckick in the link below:\n..........";
          //if (mail($para, $titulo, $msjCorreo, $header)) {
          //echo 'User created, please activate your user';
          //} else {
          //echo 'An error occurred, please try it again';
          //}

          //And now we forward the action to the "phpmailer_activation.php" page to continue sending the email to users for further activation:
          header("Location: phpmailer_activation.php?action=sendemailtoactivate&email=".$email."&username=".$username);
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
    header("Location: ../signup.php");
    exit();
  }


?>
