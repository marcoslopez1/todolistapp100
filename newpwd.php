<html lang="en-Us">
<head>
	<meta charset="utf-8">
	<title>New Password</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:400,300'>

	<!--For responsive user -->
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="HandheldFriendly" content="true">
</head>
<body>
	<?php
	require 'includes/dbh.inc.php';
	if (isset($_GET['request'])=="changepassword") {
		$hashedemail = $_GET['hashedemail'];
		//In the "phpmailer_forgotthenpwd.php" file we created a encryption of the email variable. That encrypted value is been shared in the url we recieve within this page. Now we are gling to dencrypt that variable using the same libreries:
		list($hashedemail, $enc_iv) = explode("::", $hashedemail);;
		$cipher_method = 'aes-128-ctr';
		$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
		$email = openssl_decrypt($hashedemail, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
		unset($hashedemail, $cipher_method, $enc_key, $enc_iv);
		//End of the decryption


		$sql = "SELECT username FROM users WHERE email=?";
		//In order to trigger the estatment, we need to refer to the connection variable in the dbh.inc.php page
		$stmt = mysqli_stmt_init($conn);
		//Now we are checkin if the query with the connection fails or not, and in case it fails, we are returning an error
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: newpwd.php?error=sqlerror");
			exit();
		}
		//In case no errors find, we are sending the information to the database, to create new users
		else {
			//The s means we are using the variable $username as a string. And this is related to the question mark (?) we put in the query before, because we don't want MySQL injection, we want to treat users imput as a string, not as MySQL code.
			mysqli_stmt_bind_param($stmt, "s", $email);
			mysqli_stmt_execute($stmt);
			//Now we save the result in the stmt, because it may happen that already an user exists with that given username
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
			//This means basically that if we get 0 lines of result, it means no users witht that username already in the database. But if we get 1 o more, then we have an username with that username in the db
			if ($resultCheck > 1) {
				echo '<div id="login">
					<p><span class="btn-round">:-(</span></p>
					<h1 align = "center"><strong>We are sorry, something went wrong.</strong></h1></br>
				</div>';
			}
			//But incase the username nor the email are taken, then we are going to actually create the username in the database
			else {

				echo '	<div id="login">
						<p><span class="btn-round">:-)</span></p>
						<h1 align = "center"><strong>Welcome '.$email.'</strong>.<br/>Please define a new password.</h1></br>
						<form action="includes/newpwd.inc.php" method="post">
							<fieldset>
								<p>Enter your new password:</p>
								<p align="center"><input type="password" name="password" id="password" required placeholder=""></p></br>
								<p>Repeat your new password:</p>
								<p align="center"><input type="password" name="repassword" id="repassword" required placeholder=""></p></br>
								<p align="center"><input type="hidden" name="email" id="email" value='.$email.'></p>
								<p align="center"><input type="hidden" name="hashedemail" id="hashedemail" value='.$hashedemail.'></p>
								<p align="center"><input type="submit" name="change_password" value="Change Password"></p>
							</fieldset>
						</form>
					</div>';
			}
		}
		//Now we are closing the connection to save resources.
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
	else if (isset($_GET['pwd'])=="changed") {
		echo '<div id="login">
			<p><span class="btn-round">:-)</span></p>
			<h1 align = "center"><strong>Your password has been changed.</strong></h1></br>
				<form action="index.php" method="get">
					<fieldset>
						<p align="center"><input type="submit" value="Return to home page"></p>
				</fieldset>
			</form>
		</div>';
	}
	else {
		echo '<div id="login">
			<p><span class="btn-round">:-(</span></p>
			<h1 align = "center"><strong>We are sorry, something went wrong.</strong></h1></br>
		</div>';
	}

	 ?>






</body>
</html>
