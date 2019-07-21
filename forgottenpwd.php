<html lang="en-Us">
<head>

	<meta charset="utf-8">

	<title>Forgotten Password</title>
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

if (isset($_GET['request'])=="sent") {
	echo '<div id="login">
			<p><span class="btn-round">:-)</span></p>
			<h1 align = "center"><strong>We have received your request.</strong> Please, check you email for further instructions.</h1></br>
				<form action="index.php" method="get">
					<fieldset>
						<p align="center"><input type="submit" value="Return to home page"></p>
					</fieldset>
				</form>
	</div>';
	}
else {
	echo '<div id="login">
		<img class="img-responsive" src="images/favicon.png">
		<h1 align = "center"><strong>Please provide us your email address.</strong></h1></br>
		<form action="includes/forgottenpwd.inc.php" method="post">
			<fieldset>
				<p>We will send you all the instructions you need to change your password.</br></br>Enter your email:</p>
				<p align="center"><input type="email" name="email" id="email" required placeholder=""></p></br>
				<p align="center"><input type="submit" name="send_email" value="Send Email"></p>
			</fieldset>
		</form>
	</div>';
}


	//Version variables
	require 'config.php';
	echo '<p align="center" class="terms">'.$version_id.'<br/>made with <a>♥</a> and <strong>< / ></strong> by <a href="https://marcoslopezsite.com" target="blank">Marcos López</a></p>';

 ?>




</body>
</html>
