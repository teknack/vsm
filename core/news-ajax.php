<?php
	$error=0;
	if ($_POST['nstock'] && $_POST['ntitle'] && $_POST['ndesc'] && $_POST['nintensity'] && $_POST['neffectdelay'] ) {


		include_once '../includes/db_connect.php';
		include_once 'stock_functions.php';

		$nstock=$_POST['nstock'];
		$ntitle=$_POST['ntitle'];
		$ndesc=$_POST['ndesc'];
		$nintensity=$_POST['nintensity'];
		$neffectdelay=$_POST['neffectdelay'];


		$stmt="	INSERT INTO vsm_news(stock_id,news_title,news_desc,intensity,effect_delay) 
						VALUES('$nstock','$ntitle','$ndesc','$nintensity','$neffectdelay')";

		$query=$con->query($stmt);
		if (!$query) {
			//echo "Error ".$con->error;
			$error=1;
		}

	news_db2xml("data/news.xml",$con);

	}
	else{
		$error=1;
	}

	if ($error==1) {
		echo json_encode(array("status" => false)) ;
	}
	else{
		echo json_encode(array("status" => true)) ;
	}
?>