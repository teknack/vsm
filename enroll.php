<?php 

	session_start();


  include_once 'includes/db_connect.php';
  include_once 'core/stock_functions.php';

  $_SESSION['tek_userid']="ngdas@ttt.com";
  $_SESSION['tek_name']="ngdas";
  
	if(isset($_SESSION['user'])){
		header("location:index.php");
	}

	else{
		if (isset($_SESSION['tek_userid']) && $_SESSION['tek_name']) {
			$useremail=$_SESSION['tek_userid'];
			$usertekname=$_SESSION['tek_name'];
			$stmt1="SELECT * FROM vsm_user WHERE tek_email='$useremail' AND tek_name='$usertekname'";
			$query1=$con->query($stmt1);
			if($query1->num_rows>0){
				while ($row=$query1->fetch_array(MYSQLI_ASSOC)) {
					$userid=$row['id'];
					$usertekname=$row['tek_name'];
					$useremail=$row['tek_email'];
					$username=$row['username'];
					$credit=$row['credit'];
					$timestamp=$row['timestamp'];
				}
				$_SESSION['user']=array($userid,$username,$usertekname,$useremail,$credit,$timestamp);
				header("location:index.php");
			}
			else{
				if (isset($_POST['vsmalias'])) {
					$vsmalias=$_POST['vsmalias'];
					$credit="100000";
					$stmt2="INSERT INTO vsm_user (tek_email,tek_name,credit,username) VALUES ('$useremail','$usertekname','$credit','$vsmalias')";
					$query2=$con->query($stmt2);
					if ($query2) {
						$stmt3="SELECT * FROM vsm_user WHERE tek_email='$useremail' AND tek_name='$usertekname'";
						$query1=$con->query($stmt1);
						if($query1){
							while ($row=$query1->fetch_array(MYSQLI_ASSOC)) {
								$userid=$row['id'];
								$usertekname=$row['tek_name'];
								$useremail=$row['tek_email'];
								$username=$row['username'];
								$credit=$row['credit'];
								$timestamp=$row['timestamp'];
							}
							$_SESSION['user']=array($userid,$username,$usertekname,$useremail,$credit,$timestamp);
							header("location:index.php");
						}
						else{
							header("location:error.php?e=2");
						}
					}
					else{
						header("location:error.php?e=3");
					}
				}
				else{

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>VSM Reloaded | Enroll</title>

    <!-- Bootstrap core CSS -->
    <link href="resources/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="resources/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="resources/css/style.css" rel="stylesheet">
    <link href="resources/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body style="color:rgb(32, 62, 69);">

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		      <form class="form-login" action="enroll.php" method="POST">
		        <h2 class="form-login-heading">Get Started</h2>
		        <div class="login-wrap">
		        		<h4 style="padding:10px 0px;">
		        			Hey <?php echo $usertekname; ?>, </h4>
		        		<p>
		        			Thanking you for choosing VSM. We see you are new around here. Get started by choosing a unique <b>alias</b> for you.
		        		</p>
		            <input type="text" class="form-control" placeholder="VSM alias" name="vsmalias" autofocus>
		            <br>
		            <button class="btn btn-theme btn-block" href="index.html" type="submit">SIGN IN</button>
		            
		
		        </div>
		
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="resources/js/jquery.js"></script>
    <script src="resources/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="resources/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/images/news-stockmarketnew.jpg", {speed: 500});
    </script>


  </body>
</html>

<?php

				}
				
			}
		}
		else{
			header("location:error.php?e=1");
		}
	}
	?>