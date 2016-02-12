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



	$news=getNews("data/news.xml");
	$latestnewsid=end($news)["id"];
	//echo $latestnewsid;
	$stockdata=getStock("stock.xml");

?>
<!DOCTYPE html>
<html>
<head>
	<title>News backend</title>
	<link rel="stylesheet" type="text/css" href="../resources/css/bootstrap.css">
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
							<label class="control-label col-sm-4">News ID (estimated)</label>
							<div class="col-sm-8">
								<?php 
									echo "<input class=\"form-control\" type=\"text\" value=\"".($latestnewsid+1)."\"  readonly=\"readonly\"/>";
								?>
								
							</div>
						</div>
						<div class="form-group"> 
							<label class="control-label col-sm-4">Stock</label>
							<div class="col-sm-8">
								<select id="newsstock" class="form-control" type="text" >
								<?php
									foreach ($stockdata as $value) {
										echo "<option value=\"".$value['id']."\">".$value['name']."</option>";	
									}
								?>
								</select>
							</div>
						</div>
						<div class="form-group"> 
							<label class="control-label col-sm-4">News Title</label>
							<div class="col-sm-8">
								<input id="newstitle" class="form-control" type="text" />
							</div>
						</div>
						<div class="form-group"> 
							<label class="control-label col-sm-4">News Description</label>
							<div class="col-sm-8">
								<textarea id="newsdesc" rows="3" class="form-control" type="text" ></textarea>
							</div>
						</div>
						<div class="form-group"> 
							<label class="control-label col-sm-4">Intensity</label>
							<div class="col-sm-8">
								<select id="newsintensity" class="form-control">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>								
								</select>
							</div>
						</div>
						<div class="form-group"> 
							<label class="control-label col-sm-4">Effect Delay (in mins)</label>
							<div class="col-sm-8">
								<input id="newseffectdelay" class="form-control" type="text" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<button id="submit-news" class="btn btn-primary pull-right">Update News</button>
							</div>
						</div>
					</div>
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
<script type="text/javascript">
	$("#submit-news").on("click",function(){
		
      var newsstock=$("#newsstock").val();
      var newstitle=$("#newstitle").val();
      var newsdesc=$("#newsdesc").val();
      var newsintensity=$("#newsintensity").val();
      var newseffectdelay=$("#newseffectdelay").val();

      $.ajax({
        url:"news-ajax.php",
        type:"POST",
        data:{ nstock: newsstock, ntitle: newstitle, ndesc: newsdesc, nintensity: newsintensity, neffectdelay: newseffectdelay},
        dataType: "JSON",
        success: function(str){
          if(str.status==true){
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