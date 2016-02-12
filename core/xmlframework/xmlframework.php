
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
	$xml=simplexml_load_file($xmlfile) or die("Error: Cannot create object");
	$stockdata=getStock($xml);

	foreach ($stockdata as $key => $value) {

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
		
		if($query2){
			return true;
		}
		else{
			return false;
		}
	}
}
