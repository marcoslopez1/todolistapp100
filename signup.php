<html lang="en-Us">
<head>

	<meta charset="utf-8">

	<title>Sign up</title>

	<link rel="stylesheet" href="css/style.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:400,300'>

	<!--For responsive user -->
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">
</head>

<body>

	<div id="login">
		<p><span class="btn-round">:-)</span></p>
		<h1 align = "center"><strong>Welcome.</strong> Please sign up.</h1>

		<!--Here the error messages based on the error definition we set in the urls. Those error messages in the urls have been created in the file "signup.inc.php" file-->
		<?php
			//The first if check if there is string in the url with the error word on it
			if (isset($_GET['error'])) {
				if ($_GET['error'] == "emptyfields") {
					echo '<p class="message" align="center" style="color:red">Fill in all fields! Remember to accept the terms of use.</p>';
				}
				else if ($_GET['error'] == "invaliduidmail") {
					echo '<p class="message" align="center" style="color:red">Invalid username and e-mail!</p>';
				}
				else if ($_GET['error'] == "invaliduid") {
					echo '<p class="message" align="center" style="color:red">Invalid username!</p>';
				}
				else if ($_GET['error'] == "invalidmail") {
					echo '<p class="message" align="center" style="color:red">Invalid e-mail!</p>';
				}
				else if ($_GET['error'] == "passwordCheck") {
					echo '<p class="message" align="center" style="color:red">Your passwords do not match!</p>';
				}
				else if ($_GET['error'] == "usertaken") {
					echo '<p class="message" align="center" style="color:red">Either email or username already in use!</p>';
				}
			}
			//In case of a success message
			else if ($_GET["signup"] == "success") {
				echo '<p class="message" align="center" style="color:#33cc33">Your user has been created. Please check your inbox to activate your user.</p>';
			}
		?>

		<form action="includes/signup.inc.php" method="post">
			<fieldset>
				<p>Enter your email:</p>
				<p align="center"><input type="email" name="email" id="email" required placeholder=""></p>
				<p>Enter a valid username:</p>
				<p align="center"><input type="text" name="username" id="username" required placeholder=""></p>
				<p>Enter your name:</p>
				<p align="center"><input type="text" name="name" id="name" required placeholder=""></p>
				<p> Enter your password:</p>
				<p align="center"><input type="password" name="password" id="password" required placeholder=""></p>
				<p>Repeat your password:</p>
				<p align="center"><input type="password" name="repassword" id="repassword" required placeholder=""></p>
				<p class="terms"><input type="checkbox" name="terms" value="1"/> I have read and accept the <a class="terms" href="#">terms and conditions</a>.<br></p>
				<p align="center"><input type="submit" name ="create_account" value="Create Account"></p>
			</fieldset>
		</form>
	</div>

</body>
</html>
