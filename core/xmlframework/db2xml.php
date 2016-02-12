<?php

	include_once '../includes/db_connect.php';
	include_once 'stock_functions.php';

	echo db2xml("stock.xml",$con);
?>