<?php
function nextPrice($price, $buysell, $volume, $intensity, $buy, $sell, $rand) {
  
  
  $difffactor=1+(($buy-$sell)/($buy+$sell));
  $scalingfactor=0.00006;
  $probpoint=mt_rand(0,100);
  if($probpoint<95){
    $changefactor=$volume*$scalingfactor *(0.5*($difffactor+(0.1*$rand)))*($intensity+(0.1*$rand));
    if(!$buysell){
      $changefactor*=-1;
    }
  }
  else {
    $changefactor=0;
  }

	
  $invchangefactor=1+$changefactor;

  return $price*$invchangefactor;
}

function getStock($xmlfile){

	$xml=simplexml_load_file($xmlfile) or die("Error: Cannot create object");
	$xml2= json_decode(json_encode($xml), TRUE);
	foreach ($xml2['stock'] as $key => $value) {
		unset($stockpoint);
		$pointcount=0;
		foreach ($value['point'] as $pointvalue) {
			$stockpoint[] = array( $pointvalue['timestamp']*1000,floatval($pointvalue['value']));
			$pointcount++;
		}
		$laststockpoint=end($stockpoint);
		$latestvalue=floatval(end($laststockpoint));
		$nowtimestring=array(time()*1000,$latestvalue);
		$stockdata[]=array ("id" => $value["id"], "name" => $value['name'] , "code" => $value['code'], "parentvalue" =>  $value["parentvalue"],
																								"pointcount" => $pointcount,	"points" => $stockpoint, "latest" => $nowtimestring);
	}
	return $stockdata;
}

function db2xml($xmlfile,$con){
	$stmt="SELECT * FROM vsm_stock WHERE trashed=0";
	$query=$con->query($stmt);

	/* create a dom document with encoding utf8 */
	$domtree = new DOMDocument();
	/* create the root element of the xml tree */
  $xmlRoot = $domtree->createElement("stockmarket");
  /* append it to the document created */
  $xmlRoot = $domtree->appendChild($xmlRoot);
	
	

  while ($row=$query->fetch_array(MYSQLI_ASSOC)) {
  	$stock = $domtree->createElement("stock");
  	$stock = $xmlRoot->appendChild($stock);
  	$stock->appendChild($domtree->createElement('id',$row['id']));
	  $stock->appendChild($domtree->createElement('name',$row['name']));
	  $stock->appendChild($domtree->createElement('code',$row['code']));
	  $stock->appendChild($domtree->createElement('parentvalue',$row['parent_value']));
	  $stockpoints=json_decode($row['points']);
	  //echo json_encode($stockpoints);
	  foreach ($stockpoints as $value) {
	  	$point = $domtree->createElement("point");
		  $point = $stock->appendChild($point);
		  $point->appendchild($domtree->createElement('value',$value[1]));
		  $point->appendchild($domtree->createElement('timestamp',$value[0]/1000));
	  }

  }

	return $domtree->save($xmlfile);
}

function xml2db($xmlfile,$con){
	// echo "hello";
	// libxml_use_internal_errors(true);
	// $xml=simplexml_load_file($xmlfile) or die("Error: Cannot create object. Error: ");
	$stockdata=getStock($xmlfile);
	echo json_encode($stockdata);
	foreach ($stockdata as $key => $value) {
		echo $value['id'];
		$stockid=$value['id'];
		$stockname=$value['name'];
		$stockcode=$value['code'];
		$stockpvalue=$value['parentvalue'];
		$stockpoints=json_encode($value['points']);

		$stmt1 = "SELECT * FROM vsm_stock WHERE id = '$stockid'";
		//	echo $stmt1."<br />";
		$query1 = $con->query($stmt1);
		if ($query1->num_rows > 0) {
			$stmt2="UPDATE vsm_stock SET name='$stockname',code='$stockcode',parent_value='$stockpvalue',points='$stockpoints' WHERE id='$stockid'";
		}
		else {
			$stmt2="INSERT INTO vsm_stock(id , name , code , parent_value , points) VALUES('$id','$stockname','$stockcode','$stockpvalue','$stockpoints')";
		}

		//echo $stmt2."<br />";
		$query2 = $con->query($stmt2);
		
		// if($query2){
		// 	return true;
		// }
		// else{
		// 	return false;
		// }
	}
}


function checkCredit($con,$usercredit,$stock,$buysell,$stockamount){

	$stockvalue=$stock["latest"][1];

	//echo $stockvalue."<br />";
	$stockfees=0.005*$stockvalue*$stockamount;
	$stocktotal=($stockvalue*$stockamount);

	if($buysell){
		$stockgrandtotal=$stocktotal+$stockfees;
		$creditafter=round(($usercredit-$stockgrandtotal),2);
	}
	else{
		$stockgrandtotal=$stocktotal-$stockfees;
		$creditafter=round(($usercredit+$stockgrandtotal),2);
	}

	if($creditafter<0){
		return false;
	}
	return true;

}

//********************************************************************************************
//CODE HERE
//********************************************************************************************


function transactPortfolio($con,$userid,$stockid,$stockvalue,$buysell,$volume)
{
	if($buysell){
		$stmt1="SELECT * FROM vsm_portfolio WHERE user_id='$userid' AND stock_id='$stockid' AND value='$stockvalue' AND state=0 AND trashed=0 LIMIT 1";
		$query1=$con->query($stmt1);
		if($query1){
			if($query1->num_rows>0){
				while ($row=$query1->fetch_array(MYSQLI_ASSOC)) {
					$portfolioid=$row['id'];
					$portfoliovolume=$row['bought'];
					$portfoliovolumereturn=$portfoliovolume;
				}
				$portfoliovolume+=$volume;
				$stmt2="UPDATE vsm_portfolio SET bought='$portfoliovolume' WHERE id='$portfolioid'";
			}
			else{
				$stmt2="INSERT INTO vsm_portfolio(user_id,stock_id,value,bought) VALUES('$userid','$stockid','$stockvalue','$volume')";
			}
			$query2=$con->query($stmt2);
			if(!$query2){
				echo "Error: ".$con->error;
				return false;
			}
		}
		else{
			echo "Error: ".$con->error;
			return false;
		}

		$porfolioreceipt=array($portfolioid,$buysell,$portfoliovolumereturn);
		return $porfolioreceipt;
	}
	else{
		$stmt1="SELECT * FROM vsm_portfolio WHERE user_id='$userid' AND stock_id='$stockid' AND bought-sold>0 AND state=0 AND trashed=0";
		$query1=$con->query($stmt1);
		if($query1){
			if($query1->num_rows>0){
				while ($row=$query1->fetch_array(MYSQLI_ASSOC)) {
					$breakflag=0;
					$portfolioid=$row['id'];
					$portfoliobought=$row['bought'];
					$portfoliosold=$row['sold'];
					$portfoliosoldreturn=$portfoliosold;

					$volumegap=$portfoliobought-$portfoliosold;

					//$tobesold+=$volume;

					if ($volume<$volumegap) {
						$netsold=$volume+$portfoliosold;
						$stmt2="UPDATE vsm_portfolio SET sold='$netsold' WHERE id='$portfolioid'";
						$volume=0;
						$stmt2arr[]=$stmt2;
						break;
					}
					elseif ($volume==$volumegap){
						$netsold=$volume+$portfoliosold;
						$stmt2="UPDATE vsm_portfolio SET sold='$netsold',state=1 WHERE id='$portfolioid'";
						$volume=0;
						$stmt2arr[]=$stmt2;
						break;
					}
					elseif ($volume>$volumegap){
						$volumepart=$volumegap;
						$netsold=$volumepart+$portfoliosold;
						$stmt2="UPDATE vsm_portfolio SET sold='$netsold',state=1 WHERE id='$portfolioid'";
						$volume-=$volumepart;
						$stmt2arr[]=$stmt2;
					}

				}

				if ($volume==0) {
					foreach ($stmt2arr as $value) {
						$query2=$con->query($value);
						if (!$query2) {
							echo "Error: ".$con->error;
							return false;
						}
					}
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		else{
			echo "Error: ".$con->error;
			return false;
		}

		$porfolioreceipt=array($portfolioid,$buysell,$portfoliosoldreturn);
		return $porfolioreceipt;
	}
}

function portfolioSellAll($con,$userid,$stockid,$stockvalue){
	$stmt1="SELECT * FROM vsm_portfolio WHERE user_id='$userid' AND stock_id='$stockid' AND value='$stockvalue' AND state=0 AND trashed=0 LIMIT 1";
		$query1=$con->query($stmt1);
		if($query1){
			if ($query1->num_rows>0) {
				while ($row=$query1->fetch_array(MYSQLI_ASSOC)) {
					$volumebought=$row['bought'];
					$volumesold=$row['sold'];
					$portfolioid=$row['id'];
				}
				$volumeleft=$volumebought-$volumesold;
				$stmt2="UPDATE vsm_portfolio SET sold='$volumebought',state=1 WHERE id='$portfolioid'";
				$query2=$con->query($stmt2);
				if ($query2) {
					$porfolioreceipt=array($portfolioid,false,$volumeleft);
					return $porfolioreceipt;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
}

function portfolioVolumeCheck($con,$userid,$stockid){
	$stmt="	SELECT SUM(bought-sold) AS volumeleft 
					FROM vsm_portfolio 
					WHERE user_id='$userid' AND stock_id='$stockid' AND state=0 AND trashed=0 
					GROUP BY stock_id";
	$query=$con->query($stmt);
	if($query){
		if ($query->num_rows>0) {
			while($row=$query->fetch_array(MYSQLI_ASSOC)){
				$volumeleft=$row['volumeleft'];
			}
			return $volumeleft;
		}
		else{
			return 0;
		}
	}
	else{
		return false;
	}
}

function transact($con,$xmlfile,$userid,$stock,$sbuysell,$samount){

	$buysell=$sbuysell;
	$stockamount=$samount;
	$stockid=$stock["id"];
	$user_id=$userid;

	$error=0;

	$stmt1="SELECT credit FROM vsm_user WHERE id='$user_id' LIMIT 1";
	$query1 = $con->query($stmt1);
	if (!$query1) {
		echo "<br />Query didn't execute";
		$error=1;
	}
	while ($row = $query1->fetch_array(MYSQLI_ASSOC)) {
		$result1=$row;
	}

	$creditbefore=$result1['credit'];
	//echo $creditbefore."<br />";

	$stockvalue=$stock["latest"][1];

	//echo $stockvalue."<br />";
	$stockfees=0.005*$stockvalue*$stockamount;
	$stocktotal=($stockvalue*$stockamount);

	if($buysell){
		$stockgrandtotal=$stocktotal+$stockfees;
		$creditafter=round(($creditbefore-$stockgrandtotal),2);
	}
	else{
		$stockgrandtotal=$stocktotal-$stockfees;
		$creditafter=round(($creditbefore+$stockgrandtotal),2);
	}

	if ($creditafter<0) {
		return false;
	}

			
	$stmt3="INSERT INTO vsm_transaction(user_id,credit_before,credit_after,stock_id,buysell,value,volume,fees,amount)
					VALUES('$userid','$creditbefore','$creditafter','$stockid','$buysell','$stockvalue','$stockamount','$stockfees','$stockgrandtotal')";

	$query3=$con->query($stmt3);
	if (!$query3) {
		echo "Error". $con->error;
		$error=2;
		return false;
	}

	$stmt4="SELECT buysell,SUM(volume) AS volume FROM vsm_transaction WHERE stock_id='$stockid' GROUP BY buysell";
	$query4 = $con->query($stmt4);

	if (!$query4) {
		echo "<br />Query didn't execute";
		$error=3;
		return false;
	}
	while ($row = $query4->fetch_array(MYSQLI_ASSOC)) {
		$result4[]=$row;
	}

	$buyvolume=$result4[0]['volume'];
	$sellvolume=$result4[1]['volume'];
	$randomvar=mt_rand(0, mt_getrandmax())/mt_getrandmax();
	$nextstockvalue=round(nextPrice($stockvalue,$buysell,$stockamount,1,$buyvolume,$sellvolume,$randomvar),2);

	$stockpoints=$stock['points'];


	if(sizeof($stockpoints) > 29){
		array_shift($stockpoints);
		array_push($stockpoints,array(time()*1000,$nextstockvalue));
	}
	else{
		array_push($stockpoints,array(time()*1000,$nextstockvalue));
	}

	$stockpointsjson=json_encode($stockpoints);
	$stmt5="UPDATE vsm_stock SET points='$stockpointsjson' WHERE id='$stockid'";
	$query5=$con->query($stmt5);

	if (!$query5) {
		echo "Error: ". $con->error;
		$error=4;
		return false;
	}/*
	else{
		echo "<br />done";
	}
	*/
	db2xml($xmlfile,$con);
	$transactreceipt=array($creditbefore,round($creditafter,2),$buysell,$stockvalue,$stockamount,round($stockfees,2),round($stockgrandtotal,2),time());

	if($error==0){
		return $transactreceipt;
	}
	else{
		return false;
	}
}


function getNews($xmlfile){
	$xml=simplexml_load_file($xmlfile) or die("Error: Cannot create object");
	$xml2= json_decode(json_encode($xml), TRUE);
	$news=$xml2['news'];
	return $news;
}

function news_xml2db($xmlfile,$con){
	$news=getNews($xmlfile);
	$error=0;
	
	foreach ($news as $value) {
		$nid=$value["id"];
		$nstock=$value["stockid"];
		$ntitle=$value["title"];
		$ndesc=$value["description"];
		$nintensity=$value["intensity"];
		$neffectdelay=$value["effectdelay"];
		$ntime=$value["timestamp"];

		$stmt1="SELECT * FROM vsm_news WHERE id='$nid'";
		$query1=$con->query($stmt1);
		if (!$query1) {
			$error=1;
			echo "Error ".$con->error;
		}
		else{
			if($query1->num_rows>0){
				$stmt2="	UPDATE vsm_news 
									SET news_title='$ntitle',news_desc='$ndesc',intensity='$nintensity',effect_delay='$neffectdelay',timestamp='$ntime'
									WHERE id='$nid'";
			}
			else{
				$stmt2="	INSERT INTO vsm_news(stock_id,news_title,news_desc,intensity,effect_delay,timestamp) 
									VALUES('$nstock','$ntitle','$ndesc','$nintensity','neffectdelay','$ntime')";
			}
			$query2 = $con->query($stmt2);
			if (!$query2) {
				$error=1;
			}
		}
	}

		if ($error==0) {
			return true;
		}
		else{
			return false;
		}		
}


function news_db2xml($xmlfile,$con){
	$stmt="SELECT * FROM vsm_news WHERE trashed=0";
	$query=$con->query($stmt);

	/* create a dom document with encoding utf8 */
	$domtree = new DOMDocument();
	/* create the root element of the xml tree */
  $xmlRoot = $domtree->createElement("stocknews");
  /* append it to the document created */
  $xmlRoot = $domtree->appendChild($xmlRoot);



  while ($row=$query->fetch_array(MYSQLI_ASSOC)) {
  	//echo $row['news_title']	;
  	$news = $domtree->createElement("news");
  	$news = $xmlRoot->appendChild($news);
  	$news->appendChild($domtree->createElement('id',$row['id']));
  	$news->appendChild($domtree->createElement('stockid',$row['stock_id']));
	  $news->appendChild($domtree->createElement('title',$row['news_title']));
	  $news->appendChild($domtree->createElement('description',$row['news_desc']));
	  $news->appendChild($domtree->createElement('intensity',$row['intensity']));
	  $news->appendChild($domtree->createElement('effectdelay',$row['effect_delay']));
	  $news->appendChild($domtree->createElement('timestamp',$row['timestamp']));
  }

	return $domtree->save($xmlfile);
}

function stockAddPoint($con,$xmlfile,$stockid,$stockdiff){


	$stockdata=getStock($xmlfile);
	$stock=$stockdata[$stockid-1];
	$nextstockvalue=$stock["latest"][1]+$stockdiff;
	$stockpoints=$stock["points"];
	if(sizeof($stockpoints) > 29){
		array_shift($stockpoints);
		array_push($stockpoints,array(time()*1000,$nextstockvalue));
	}
	else{
		array_push($stockpoints,array(time()*1000,$nextstockvalue));
	}

	$stockpointsjson=json_encode($stockpoints);
	$stmt5="UPDATE vsm_stock SET points='$stockpointsjson' WHERE id='$stockid'";
	$query5=$con->query($stmt5);

	if (!$query5) {
		echo "Error: ". $con->error;
		$error=4;
		return false;
	}

	db2xml($xmlfile,$con);
	return true;
}
?>