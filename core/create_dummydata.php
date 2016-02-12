<?php
	
	include_once '../includes/db_connect.php';

	date_default_timezone_set("Asia/Kolkata");
	
	if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
	}

	$timestamp=time();
	for($i=0; $i<30; $i++){
		$timestamp+=60;
		$timestampsql=date("Y-m-d H:i:s",$timestamp);
		$stockvalue+=5;
		$stmt="INSERT INTO vsm_stock_value(stock_id,value,timestamp) VALUES(1,'$stockvalue','$timestampsql')";
		$query = mysqli_query($con, $stmt);
		if ($query) {
			echo "done<br />";
		}
		else{
			echo "error<br />".mysqli_error($con);
		}
	}

?>
