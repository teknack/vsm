<?php
//include 'home_admin.html';
	$hostname="localhost";  // Hostname
	$username="teknajvh_root";       // Username for Database
	$password="Meradata#1#1";           // Database password
	$dbname="teknajvh_teknack15";        // Database name
	
	$con = mysql_connect($hostname,$username,$password) or die("Error connecting to database");  // Make Connection	
	mysql_select_db($dbname)                     // Select Database
?>
