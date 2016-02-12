<?php
	include_once '../includes/db_connect.php';
	include_once 'stock_functions.php';

	$psell=portfolioSellAll($con,1,2,210.28);

	if($psell){
		echo "heya";
	}
	else{
		echo "notheya";
	}
?>