<?php
	if (isset($_POST['stockid']) && isset($_POST['stockdiff'])) {
		
		include_once '../includes/db_connect.php';
		include_once 'stock_functions.php';

		$stockid=$_POST['stockid'];
		$stockdiff=$_POST['stockdiff'];
		$stockaddpoint=stockAddPoint($con,"stock.xml",$stockid,$stockdiff);
		if($stockaddpoint){
			echo json_encode(array("status"=>true));
		}
		else{
			echo json_encode(array("status"=>false));
		}
	}
	else{
		echo json_encode(array("status"=>false));
	} 
?>