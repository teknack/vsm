<?php

include_once '../includes/db_connect.php';
include_once 'stock_functions.php';

echo news_db2xml("data/news.xml",$con);
//echo "hello";
?>