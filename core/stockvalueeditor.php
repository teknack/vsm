<?php

	if(!isset($_GET['key'])){
			header("location:../error.php?e=1");
	}
	else{
		if ($_GET['key']!="romeoandjuliet") {
			header("location:../error.php?e=1");
		}
	}
	include_once '../includes/db_connect.php';
	include_once 'stock_functions.php';



	$stockdata=getStock("stock.xml");

?>
<!DOCTYPE html>
<html>
<head>
	<title>News backend</title>
	<link rel="stylesheet" type="text/css" href="../resources/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../resources/css/jquery.bootstrap-touchspin.min.css">
	<style type="text/css">
	.news-panel{
		padding: 0px 10px;
		color: #666;
	}
	.news-panel p{
		color: #999;
	}
	</style>
</head>
<body>
	<div class="container">
			<h1 class="text-center">Virtual Stock Market</h1>
			<div class="row">
				<h3>News Update</h3>
				<div style="margin-top:30px;" class="col-sm-6 col-xs-12">

					<div class="form-horizontal">
						
						<div class="form-group"> 
							<label class="control-label col-sm-4">Stock</label>
							<div class="col-sm-8">
								<select id="selectstock" class="form-control" type="text" >
								<?php
									foreach ($stockdata as $value) {
										echo "<option value=\"".$value['id']."\">".$value['name']."</option>";	
									}
								?>
								</select>
							</div>
						</div>
						<div class="form-group"> 
							<label class="control-label col-sm-4">Increase/Decrease:</label>
							<div class="col-sm-8">
								<input id="point-diff" class="form-control" type="text" value="0" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<button id="updatestockpoint" class="btn btn-primary pull-right">Update Stock Value</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Stock ID</th>
								<th>Stock Name</th>
								<th>Current Stock Value</th>
							</tr>
						</thead>
						<?php
							foreach ($stockdata as $value) {
								$stockprice=$value["latest"][1];
                $stockpricediff=round($stockprice-$value["parentvalue"],2);
                        
                if($stockpricediff>0){
                  $pricestring="<p style=\"color:#05E177;\">".$stockprice."&nbsp;&nbsp;<span class=\"glyphicon glyphicon-chevron-up\"></span>&nbsp;".$stockpricediff."</p>";
                }
                elseif ($stockpricediff==0) {
                  $pricestring="<p style=\"color:#FFDF00;\">".$stockprice."&nbsp;&nbsp;<span class=\"glyphicon glyphicon-minus\"></span>&nbsp;".$stockpricediff."</p>";
                }
                else{
                  $pricestring="<p style=\"color:#FE4D4D;\">".$stockprice."&nbsp;&nbsp;<span class=\"glyphicon glyphicon-chevron-down\"></span>&nbsp;".$stockpricediff."</p>";
                }
								echo "<tr>
												<td>".$value['id']."</td>
												<td>".$value['name']."</td>
												<td>".$pricestring."</td>
											</tr>";
							}
						?>
						<tbody>
							<tr>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
<!--
			<div class="col-sm-6">
				<div style="margin-top:30px;" class="well">
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default news-panel">
									<h4>Something random Stock News</h4>
									<p>Check any cables and reboot any routers, modems, or other network devices you may be using. If it is already listed as a program allowed to access the network, try removing it from the list and adding it again.</p>
									<div class="row">
										<center>
										<div class="col-sm-3">
											<h6>11:44 am</h6>
										</div>
										
										<div class="col-sm-3">
											<h6>Stock 1</h6>
										</div>
										<div class="col-sm-3">
											<h6>4</h6>
										</div>
										<div class="col-sm-3">
											<h6>Delay: 55mins</h6>
										</div>
										</center>
									</div>
									
							</div>
						</div>
					</div>
					
				</div>
			</div>
-->
	</div>
<script type="text/javascript" src="../resources/js/jquery.js"></script>
<script type="text/javascript" src="../resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../resources/js/jquery.bootstrap-touchspin.min.js"></script>
      <script type="text/javascript">
      $("#point-diff").TouchSpin({
        min: -20,
        max: 20,
        step: 0.1,
        decimals: 2
      });
    </script>
<script type="text/javascript">
	$("#updatestockpoint").on("click",function(){
		
      var sid=$("#selectstock").val();
      var sdiff=$("#point-diff").val();

      $.ajax({
        url:"stockpoint-ajax.php",
        type:"POST",
        data:{ stockid: sid, stockdiff: sdiff},
        dataType: "JSON",
        success: function(str){
          if(str.status==1){
          	alert("Done");
          }
          else{
          	alert("Failed");
          }
        },
        error: function(jqXHR,textStatus){
          alert( "Request failed: " + textStatus )}
      });
    });
</script>
</body>
</html>