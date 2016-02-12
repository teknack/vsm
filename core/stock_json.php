<?php

header("Content-type: text/json");

include_once 'stock_functions.php';

echo json_encode(getStock("stock.xml"));

?>