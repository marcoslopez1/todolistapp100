<?php

//The condition to run this file is to have the session started
session_start();

//This will unassign all the session variables
session_unset();

//This will delete the values of the session variables (condition we have to know if an user is logged in)
session_destroy();

//We redirect to the index.php wihout values on the session variables. This will show the login option again, since it understands the user is not logged in
header("Location: ../index.php")
?>
