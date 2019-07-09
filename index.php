<?php
  //required for the login system
  session_start();
?>

<html lang="en-Us">
<head>

	<meta charset="utf-8">

	<title>Index</title>
	<link rel="shortcut icon" href="images/favicon.png">

	<link rel="stylesheet" href="css/style.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:400,300'>

  <!--For responsive user -->
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">

</head>

<body>



	<?php
		if (isset($_SESSION['username'])) {
      header('Location: todos.php');
      //echo '	<div id="login">
			//		<p><span class="btn-round">:-)</span></p>
			//		<h1 align = "center"><strong>Welcome '.$_SESSION['username'].'.</strong> Page in construction.</h1>
			//		<form action="includes/logout.inc.php" method="post">
			//			<fieldset>
			//				<p align="center"><input type="submit" name="logout" value="logout"></p>
			//			</fieldset>
			//		</form>
			//	</div>';
		}
    else if (isset($_GET['error'])) {
      if ($_GET['error'] == "emptyfields") {
        echo '	<div id="login">
  					<p><span class="btn-round">:-(</span></p>
  					<h1 align = "center"><strong>Welcome.</strong> Please login.</h1>
            <p class="message" align="center" style="color:red">Fill in all fields!</p>
            <form action="includes/login.inc.php" method="post">
  						<fieldset>
  							<p>Username or email:</p>
  							<p align="center"><input type="text" name="uid" id="uid" required placeholder=""></p>
  							<p>Password: <a href="forgottenpwd.php"> Forgot Password?</a></p>
  							<p align="center"><input type="password" name="password" id="password" required placeholder=""></p>
  							<a align="right" href="signup.php"> Create an account here!</a></p>
  							<p align="center"><input type="submit" name="login" value="Login"></p>
  						</fieldset>
  					</form>
  				</div>';
      }
      else if ($_GET['error'] == "sqlerror") {
        echo '	<div id="login">
  					<p><span class="btn-round">:-(</span></p>
  					<h1 align = "center"><strong>Welcome.</strong> Please login.</h1>
            <p class="message" align="center" style="color:red">Sorry, something went wrong. Try again later.</p>
            <form action="includes/login.inc.php" method="post">
  						<fieldset>
  							<p>Username or email:</p>
  							<p align="center"><input type="text" name="uid" id="uid" required placeholder=""></p>
  							<p>Password: <a href="forgottenpwd.php"> Forgot Password?</a></p>
  							<p align="center"><input type="password" name="password" id="password" required placeholder=""></p>
  							<a align="right" href="signup.php"> Create an account here!</a></p>
  							<p align="center"><input type="submit" name="login" value="Login"></p>
  						</fieldset>
  					</form>
  				</div>';
      }
      else if ($_GET['error'] == "wrongpwd") {
        echo '	<div id="login">
  					<p><span class="btn-round">:-(</span></p>
  					<h1 align = "center"><strong>Welcome.</strong> Please login.</h1>
            <p class="message" align="center" style="color:red">Wrong password. Please try again.</p>
            <form action="includes/login.inc.php" method="post">
  						<fieldset>
  							<p>Username or email:</p>
  							<p align="center"><input type="text" name="uid" id="uid" required placeholder=""></p>
  							<p>Password: <a href="forgottenpwd.php"> Forgot Password?</a></p>
  							<p align="center"><input type="password" name="password" id="password" required placeholder=""></p>
  							<a align="right" href="signup.php"> Create an account here!</a></p>
  							<p align="center"><input type="submit" name="login" value="Login"></p>
  						</fieldset>
  					</form>
  				</div>';
      }
      else if ($_GET['error'] == "nouser") {
        echo '	<div id="login">
  					<p><span class="btn-round">:-(</span></p>
  					<h1 align = "center"><strong>Welcome.</strong> Please login.</h1>
            <p class="message" align="center" style="color:red">That user is not correct.</p>
            <form action="includes/login.inc.php" method="post">
  						<fieldset>
  							<p>Username or email:</p>
  							<p align="center"><input type="text" name="uid" id="uid" required placeholder=""></p>
  							<p>Password: <a href="forgottenpwd.php"> Forgot Password?</a></p>
  							<p align="center"><input type="password" name="password" id="password" required placeholder=""></p>
  							<a align="right" href="signup.php"> Create an account here!</a></p>
  							<p align="center"><input type="submit" name="login" value="Login"></p>
  						</fieldset>
  					</form>
  				</div>';
      }
    }
    else {
			echo '	<div id="login">
					<img class="img-responsive" src="images/favicon.png">
					<h1 align = "center"><strong>Welcome.</strong> Please login.</h1>
          <form action="includes/login.inc.php" method="post">
						<fieldset>
							<p>Username or email:</p>
							<p align="center"><input type="text" name="uid" id="uid" required placeholder=""></p>
							<p>Password: <a href="forgottenpwd.php"> Forgot Password?</a></p>
							<p align="center"><input type="password" name="password" id="password" required placeholder=""></p>
							<a align="right" href="signup.php"> Create an account here!</a></p>
							<p align="center"><input type="submit" name="login" value="Login"></p>
						</fieldset>
					</form>
				</div>';
		}








	?>






</body>
</html>
