<?php

	$mem = new Memcached();
	$mem->addServer("127.0.0.1", 11211);

	if($mem->flush()){
		echo "Memcache cleared";
	}
	else{
		echo "Some error occured";
	}
?>