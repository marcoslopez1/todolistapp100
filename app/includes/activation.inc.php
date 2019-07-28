<html lang="en-Us">
<head>
	<meta charset="utf-8">
	<title>Sign up</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:400,300'>

	<!--For responsive user -->
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">
</head>

<body>


<?php

require 'dbh.inc.php';

//URLs to activate users, format:
//http://83.165.235.220:5001/to_do_list_app/includes/activation.inc.php?activation=useractivation&username=marcos

$username = $_GET['username'];

if ($_GET['activation'] == "useractivation") {
    //We look for an username with the same username or email existing already in the db
    $sql = "SELECT username FROM users WHERE username=?";
    //In order to trigger the estatment, we need to refer to the connection variable in the dbh.inc.php page
    $stmt = mysqli_stmt_init($conn);
    //Now we are checkin if the query with the connection fails or not, and in case it fails, we are returning an error
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: activation.inc.php?error=sqlerror");
      exit();
    }
    //In case no errors find, we are sending the information to the database, to create new users
    else {
      //The s means we are using the variable $username as a string. And this is related to the question mark (?) we put in the query before, because we don't want MySQL injection, we want to treat users imput as a string, not as MySQL code.
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      //Now we save the result in the stmt, because it may happen that already an user exists with that given username
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      //This means basically that if we get 0 lines of result, it means no users witht that username already in the database. But if we get 1 o more, then we have an username with that username in the db
      if ($resultCheck > 1) {
        header("Location: activation.inc.php?error=morethanoneresultunabetoactivate");
        exit();
      }
			//In case somebody modifies manually the url trying to activate an no created user:
			else if ($resultCheck == 0) {
				header("Location: activation.inc.php?error=nocreateduser");
        exit();
			}
      //But incase the username nor the email are taken, then we are going to actually create the username in the database
      else {
        $sql = "UPDATE users SET active='1' WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: activation.inc.php?error=sqlerror");
          exit();
        }
        else {
          //We are hashing the password, in case we have a bridge in the db, hackers could not see it as the users wrote it down, creating a new variable
          mysqli_stmt_bind_param($stmt, "s", $username);
          mysqli_stmt_execute($stmt);

          //And now we return a success message
          header("Location: activation.inc.php?activation=success&username=".$username);
          exit();
        }
      }
    }
  }
  //Now we are closing the connection to save resources.
  mysqli_stmt_close($stmt);
  mysqli_close($conn);


  //Message to be shown to the user after activation or errors.
  if (isset($_GET['error'])) {
  	if ($_GET['error'] == "sqlerror") {
  		echo '<div id="login">
  			<p><span class="btn-round">:-(</span></p>
  			<h1 align = "center"><strong>Something wrong happened.</strong> Please, try again later</h1></br>
					<form action="../login.php" method="get">
						<fieldset>
	  					<p align="center"><input type="submit" value="Return to home page"></p>
	  				</fieldset>
					</form>
  		</div>';
  	}
  	else {
  		echo '<div id="login">
  			<p><span class="btn-round">:-(</span></p>
  			<h1 align = "center"><strong>Something wrong happened.</strong> Please, try again later</h1></br>
				<form action="../login.php" method="get">
					<fieldset>
						<p align="center"><input type="submit" value="Return to home page"></p>
					</fieldset>
				</form>
  		</div>';
  	}
  }
  //In case of a success message
  else if ($_GET["activation"] == "success") {
      $username = $_GET['username'];
      echo '<div id="login">
  		<p><span class="btn-round">:-)</span></p>
  		<h1 align = "center"><strong>Thank you '.$username.'!</strong> Your user has been activated.</h1></br>
			<form action="../login.php" method="get">
				<fieldset>
					<p align="center"><input type="submit" value="Return to home page"></p>
				</fieldset>
			</form>
  	</div>';
  }

?>
</body>
</html>
