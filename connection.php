<?php

	$hostname = "localhost:3307";
	$username = "restpos";
	$password = "restpos";
	$database = "ssl";


	$conn = mysqli_connect("$hostname","$username","$password",$database ) or die(mysqli_error());


?>