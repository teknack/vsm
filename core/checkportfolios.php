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
	$stmt1="SELECT p.*,u.username,p.bought-p.sold as volume,s.name as stockname FROM vsm_portfolio p 
					LEFT JOIN vsm_stock s ON p.stock_id=s.id 
					LEFT JOIN vsm_user u ON p.user_id=u.id
					WHERE p.state=0 AND p.trashed=0 ORDER BY p.user_id";
	$stmt2="SELECT p.*,SUM(p.bought-p.sold) as volume,s.name as stockname FROM vsm_portfolio p 
					LEFT JOIN vsm_stock s ON p.stock_id=s.id 
					WHERE p.state=0 AND p.trashed=0 
					GROUP BY p.stock_id
					ORDER BY p.stock_id";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Check Portfolios</title>
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
				<div class="col-sm-6 col-xs-12">

				<h3>Portfolio (Users)</h3>
				<table class="table">
					<thead>
						<tr>
							<th>User ID</th>
							<th>Username</th>
							<th>Stock name</th>
							<th>Stock volume</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$query1=$con->query($stmt1);
					if ($query1) {
						while ($row=$query1->fetch_array(MYSQLI_ASSOC)) {
							echo '
										<tr>
											<td>'.$row["user_id"].'</td>
											<td>'.$row["username"].'</td>
											<td>'.$row["stockname"].'</td>
											<td>'.$row["volume"].'</td>
										</tr>'	;
						}
					}
					else{
						echo "Error :".$con->error;
					}
						
					?>
					</tbody>
				</table>
				
				</div>
				<div class="col-sm-6 col-xs-12">
					<h3>Portfolio (per Stock)</h3>
					<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Stock name</th>
							<th>in Market</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$query2=$con->query($stmt2);
					if ($query2) {
						$i=0;
						while ($row=$query2->fetch_array(MYSQLI_ASSOC)) {
							$i++;
							echo '
										<tr>
											<td>'.$i.'</td>
											<td>'.$row["stockname"].'</td>
											<td>'.$row["volume"].'</td>
										</tr>'	;
						}
					}
					else{
						echo "Error :".$con->error;
					}
						
					?>
					</tbody>
				</table>
				</div>
			</div>
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