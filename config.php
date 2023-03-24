<?php 
    $db = new mysqli('localhost','root','','budget_management');
 	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error(); exit;
	}
?>