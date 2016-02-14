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
  echo "<br /><br />Price: ".$price;
  echo "<br />Buy?: ".$buysell;
  echo "<br />Volume: ".$volume;
  echo "<br />Intensity: ".$intensity;
  echo "<br />Buy/Sell: ".$buy."/".$sell;
  echo "<br />Scaling Factor: ".$scalingfactor;
  echo "<br />Random: ".$rand;
  echo "<br />Probpoint: ",$probpoint;
  echo "<br />Difffactor: ".$difffactor;
  echo "<br />Change Factor: ".$changefactor;
  echo "<br />Inv. Change Factor: ".$invchangefactor;
  echo "<br />New Stock Value: ".sprintf("%0.2f",($price*$invchangefactor));
}

// Can tweak these values between runs, or put them in a loop if you want
$testPrice = 256.04;
$testBuy = 6292;
$testSell = 2776;
$testbuysell = true;
$testvolume =100;

for ($i = 0; $i <= 5; $i++) {
  // random float, from http://stackoverflow.com/a/14155720/113632
  // set to a constant if you want to isolate the randomness and test other variables
  $testRand = mt_rand(0, mt_getrandmax())/mt_getrandmax();
       nextPrice($testPrice, $testbuysell, $testvolume, $i, $testBuy, $testSell, $testRand);
}

?>