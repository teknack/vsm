<?php
	include_once '../includes/db_connect.php';
	include_once 'stock_functions.php';

	//if ($_POST) {
	//	if($_POST['buy']){
			//$buysell=$_POST['buysell'];
			//$stockid=$_POST['stockid'];
			//$stockamount=$_POST['samount'];
			$buysell=true;
			$stockamount=200;
			$stockid=1;
			$mem= new Memcached();
			$mem->addServer("127.0.0.1", 11211);

			$stmt1="SELECT credit FROM vsm_user WHERE user_id=1 LIMIT 1";
			$querykey1 = "KEY" . md5($stmt1);
			$result1 = $mem->get($querykey1);
			if($result1){
				$cached=1;
			} 
			else {
				$query1 = $con->query($stmt1);
				if (!$query1) {
					echo "<br />Query didn't execute";
				}
				while ($row = $query1->fetch_array(MYSQLI_ASSOC)) {
					$result1=$row;
				}
			  $mem->set($querykey1, $result1, 60);
			  $cached=0;
			}
			if($cached==1){
				echo "cached";
			}
			$creditbefore=$result1['credit'];
			echo $creditbefore."<br />";
			$stockid=1;

			$stmt2 = "SELECT * FROM vsm_stock_value WHERE stock_id='$stockid'";
			$query2 = $con->query($stmt2);
			if (!$query2) {
				echo "<br />Query didn't execute";
			}
			while ($row = $query2->fetch_array(MYSQLI_ASSOC)) {
				$result2[]=$row;
			}
			

			$stockvalue=end($result2)['value'];
			echo $stockvalue."<br />";
			$stockfees=0.005*$stockvalue*$stockamount;
			$stockgrandtotal=($stockvalue*$stockamount)+$stockfees;
			if($buysell){
				$creditafter=$creditbefore-$stockgrandtotal;
			}
			else{
				$creditafter=$creditbefore+$stockgrandtotal;
			}
			
			$stmt3="INSERT INTO vsm_transaction(user_id,credit_before,credit_after,stock_id,buysell,value,volume,fees,amount)
							VALUES(1,'$creditbefore','$creditafter','$stockid','$buysell','$stockvalue','$stockamount','$stockfees','$stockgrandtotal')";
			//echo $stmt3;
			$query3=$con->query($stmt3);
			if (!$query3) {
				echo "Error". $con->error;
			}

			$stmt4="SELECT buysell,SUM(volume) AS volume FROM vsm_transaction GROUP BY buysell";
			$querykey4 = "KEY" . md5($stmt4);
			$result4 = $mem->get($querykey4);

			if($result4){
				$cached4=1;
			} 
			else {
				$query4 = $con->query($stmt4);
				if (!$query4) {
					echo "<br />Query didn't execute";
				}
				while ($row = $query4->fetch_array(MYSQLI_ASSOC)) {
					$result4[]=$row;
				}
			  $mem->set($querykey4, $result4, 0);
			  $cached4=0;
			}

			if ($cached4==1) {
				echo "cached";
			}
			$buyvolume=$result4[0]['volume'];
			$sellvolume=0;
			$randomvar=mt_rand(0, mt_getrandmax())/mt_getrandmax();
			$nextstockvalue=nextPrice($stockvalue,$buysell,$stockamount,1,$buyvolume,$sellvolume,$randomvar);
			echo $nextstockvalue;
			$stmt5="INSERT INTO vsm_stock_value(stock_id,value)
							VALUES('$stockid','$nextstockvalue')";
			$query5=$con->query($stmt5);
			if (!$query5) {
				echo "Error: ". $con->error;
			}
			else{
				echo "done";
			}


			$stmt6 = "SELECT * FROM vsm_stock_value WHERE stock_id='$stockid'";
			$query6 = $con->query($stmt6);
			if (!$query6) {
				echo "<br />Query didn't execute";
			}
			while ($row = $query6->fetch_array(MYSQLI_ASSOC)) {
				$result6[]=$row;
			}
			$querykey6 = "KEY" . md5($stmt6);
			$mem->set($querykey6, $result6, 0);
			//$result6 = $mem->get($querykey6);
			
			//$nextstockvalue=nextPrice()
			//$stmt2="	INSERT INTO vsm_stock_value(stock_id,value)
								//VALUES($stockid,$stockvalue)"

	//	}
	//}
?>