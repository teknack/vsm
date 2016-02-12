<?php
	include_once '../includes/db_connect.php';
	include_once 'stock_functions.php';

	
	
	echo news_xml2db("data/news.xml",$con);
?>