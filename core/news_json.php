<?php

	include_once 'stock_functions.php';

	echo json_encode(getNews("data/news.xml"));
?>