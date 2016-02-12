<?php
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

foreach ($result as $row) {
	$stockpoint[]=array(strtotime($row['timestamp'])*1000,intval($row['value']));
}

echo json_encode(array("cached" => $cached, "stockpoint" => $stockpoint));
?>