<?php
  
  session_start();

  if(!isset($_SESSION['user'])){
    header("location:enroll.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>VSM Reloaded</title>

    <!-- Bootstrap core CSS -->
    <link href="resources/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="resources/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="resources/css/style.css" rel="stylesheet">
    <link href="resources/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="resources/simple-lineicons/simple-line-icons.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    .white-panel{
      color: #999;
    }

    .white-header{
      color: #999 !important;
    }

    .ds .details{
      width: 250px;
    }

    .darkblue-panel h4{
      font-weight: 200;
      margin-top: 10px;
      padding-left: 0px;
      padding-right: 0px;
      color: white;
      }

    .darkblue-panel h3{
      font-weight: 200;
      margin-top: 10px;
      padding-left: 0px;
      padding-right: 0px;
      color: white;
      }

      .darkblue-panel h5{
      font-weight: 200;
      margin-top: 10px;
      padding-left: 0px;
      padding-right: 0px;
      color: white;
      }

      .pn .upperhalf{
        height:50%;
        border-bottom: 2px solid #f4f4f4;
        padding-top: 30px;
      }

      .pn .lowerhalf{
        height:50%;
        padding-top: 30px;
      }

      .darkblue-panel .darkblue-header{
        margin-bottom:0px;
      }


      .btn-trans-white{
        border-width: 1px;
        border-style: solid;
        border-color: #FFF;
        color: #FFF;
        background-color: transparent;
      }

      .btn-trans-white:hover{
        background-color: #FFF;
        color: #999;
      }
    </style>
  </head>

  <body>

  <section id="container" >
      <div class="alert alert-danger">
        <b>Sorry it's closed as of now
      </div>
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="resources/js/jquery.js"></script>
    <script src="resources/js/bootstrap.min.js"></script>
    <script src="resources/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="resources/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="resources/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="resources/js/jquery.scrollTo.min.js"></script>
    <script src="resources/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="resources/js/jquery.sparkline.js"></script>
    <script type="text/javascript" src="resources/js/sparkline-chart.js"></script>
    <script type="text/javascript" src="resources/js/jquery.bootstrap-touchspin.min.js"></script>
      <script type="text/javascript">
      $("#point-diff").TouchSpin({
        min: -20,
        max: 20
      });
    </script>


    <!--common script for all pages-->
    <script src="resources/js/common-scripts.js"></script>

    <!--script for this page-->
    
  <!--script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script-->

  </body>
</html>
