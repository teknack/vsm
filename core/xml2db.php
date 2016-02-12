<?php
	include_once '../includes/db_connect.php';
	include_once 'stock_functions.php';
	// header("string")
	header('Content-Type: application/json');
	echo xml2db("stock.xml",$con);
?>