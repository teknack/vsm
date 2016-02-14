<?php
	
	session_start();
	$userid=$_SESSION['user'][0];

	include_once '../includes/db_connect.php';
	include_once 'stock_functions.php';

			$sid=1;
			$sbuysell=1;
			$samount=100;
			if ($sbuysell==1) {
				$sbuysell=true;
			}
			elseif ($sbuysell) {
				$sbuysell=false;
			}

			$stockdata=getStock("stock.xml",$con);
			$stock=$stockdata[$sid-1];
			$stockvalue=$stock["latest"][1];
			$uesrcredit=$_SESSION['user'][4];
			//$creditcheck=true;
			$creditcheck=checkCredit($con,$uesrcredit,$stock,$sbuysell,$samount);
			if ($creditcheck) {
				$portfolioreceipt=transactPortfolio($con,$userid,$sid,$stockvalue,$sbuysell,$samount);
					if($portfolioreceipt){
						$transactreceipt=transact($con,"stock.xml",$userid,$stock,$sbuysell,$samount);
						if ($transactreceipt) {
								$_SESSION['user'][4]=$transactreceipt[1];
								echo json_encode(array("status" => 1, "credit" => $transactreceipt[1], "stockvalue"=>$transactreceipt[3], "stockvolume"=>$transactreceipt[4], 
																				"stockfees"=>$transactreceipt[5], "stocktotal"=>$transactreceipt[6], "transactdate"=>date("d-m-Y H:i:s",$transactreceipt[7]) ));
						}
						else {
							echo json_encode(array("status" => 0));
							echo "2";
						}
					}
					else{
						echo json_encode(array("status" => 0));
						echo "3";
					}
			}
			else{
				echo json_encode(array("status" => 0));
				echo "4";
			}


?>