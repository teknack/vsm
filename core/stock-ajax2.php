<?php

header("Content-type: text/json");
include_once '../includes/db_connect.php';


$stockid=1;
$currenttimestamp=time();

$mem = new Memcached();
$mem->addServer("127.0.0.1", 11211);

$stmt = "SELECT * FROM vsm_stock_value WHERE stock_id='$stockid'";
$querykey = "KEY" . md5($stmt);
$result = $mem->get($querykey);

if($result){
	$cached=1;
} 
else {
	$query = $con->query($stmt);
	if (!$query) {
		echo "<br />Query didn't execute";
	}
	while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
		$result[]=$row;
	}
  $mem->set($querykey, $result, 10);
  $cached=0;
}
$lateststockpoint=array(time()*1000,floatval(end($result)['value']));
echo json_encode(array("cached" => $cached, "stockpoint" => $lateststockpoint));
//echo json_encode($lateststockpoint);
?>