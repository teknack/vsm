<?php

  
  session_start();

  if(!isset($_SESSION['user'])){
    header("location:enroll.php");
  }

  $userid=$_SESSION['user'][0];
  $usertekname=$_SESSION['user'][2];
  $username=$_SESSION['user'][1];

  include_once 'includes/db_connect.php';
  include_once 'core/stock_functions.php';

  $stockdata=getStock("core/stock.xml");

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
    <link rel="stylesheet" type="text/css" href="resources/lineicons/style.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    .darkblue-panel h4 {
      font-weight: 200;
      margin-top: 10px;
      color: hsl(191 ,36% ,5%);
      }


      .darkblue-panel .darkblue-header{
        margin-bottom:0px;
      }



      .btn-trans-white{
        border-width: 1px;
        border-style: solid;
        border-color: hsl(191 ,36% ,20%);
        color: hsl(191 ,36% ,10%);
        background-color: transparent;
      }

      .btn-trans-white:hover{
        background-color: rgb(32, 62, 69);
        color: #def2f3;
      }
    </style>
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->

      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul style="margin-top:40px;" class="sidebar-menu" id="nav-accordion">

                  <p class="centered"><img src="assets/images/vsmnew.png" width="200"></p>
              
                  <h4 style="color:#000;" class="text-center"><?php echo $usertekname ?></h4>
                  <h5 style="color:#000;font-weight:100;" class="text-center"><?php echo $username ?></h5>
                  <!--p class="centered"><a href="profile.html"><img src="assets/images/ui-sam.jpg" class="img-circle" width="60"></a></p-->
                    
                  <li class="mt">
                      <a href="index.php">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>

                  <li>
                    <a href="portfolio.php">
                          <i class="fa fa-file-o"></i>
                          <span>Portfolio</span>
                      </a>
                  </li>

                  <li>
                      <a href="stocks.php">
                          <i class="fa fa-line-chart"></i>
                          <span>Stocks</span>
                      </a>
                  </li>

                  <li>
                      <a href="news.php">
                          <i class="fa fa-newspaper-o"></i>
                          <span>News</span>
                      </a>
                  </li>


                  <li>
                      <a href="rules.php">
                          <i class="fa fa-question"></i>
                          <span>Guide</span>
                      </a>
                  </li>


              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
            <!--h3><i class="fa fa-angle-right"></i> Blank Page</h3-->
            <div class="row mt">
              <div class="col-lg-12">
                
                
                    <h3>Stocks</h3>

                  <div style="padding-top:20px;" class="row">

                    <?php
                      foreach ($stockdata as $value) {
                        foreach ($value['points'] as $value2) {
                          $point[]=$value2[1];
                        }
                        $point = array_splice($point, (sizeof($point)-10));

                        $stockprice=$value["latest"][1];
                        $stockpricediff=round($stockprice-$value["parentvalue"],2);
                        
                        if($stockpricediff>0){
                          $pricestring="<p style=\"color:rgb(0, 153, 0);\">".$stockprice."&nbsp;&nbsp;<span class=\"fa fa-caret-up\"></span>&nbsp;".$stockpricediff."</p>";
                        }
                        elseif ($stockpricediff==0) {
                          $pricestring="<p style=\"color:rgb(255, 180, 0);\">".$stockprice."&nbsp;&nbsp;<span class=\"fa fa-circle\"></span>&nbsp;".$stockpricediff."</p>";
                        }
                        else{
                          $pricestring="<p style=\"color:rgb(159, 52, 52);\">".$stockprice."&nbsp;&nbsp;<span class=\"fa fa-caret-down\"></span>&nbsp;".$stockpricediff."</p>";
                        }
                        echo '
                          <div class="col-md-3 col-sm-3 mb">
                            <div class="darkblue-panel pn">
                              <div class="darkblue-header">
                                <h4>'.$value["name"].'</h4>
                              </div>
                              <div style="margin-bottom:10px;" class="chart mt">
                                <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="hsl(191 ,36% ,50%)" data-spot-color="hsl(191 ,36% ,30%)" data-fill-color="" data-highlight-line-color="#000" data-spot-radius="4" data-data="'.json_encode($point).'"></div>
                              </div>
                              '.$pricestring.'
                              <div style="margin-top:15px;padding:10px;"><a href="trade.php?sid='.$value["id"].'" class="btn btn-trans-white btn-block">Trade</a></div>
                            </div>
                          </div>
                        ';

                        unset($point);
                      }
                    ?>


                    <!--div class="col-md-4 mb">
                      <div class="white-panel pn">
                        <div class="white-header">
                          <h5>TOP USER</h5>
                        </div>
                        <p><img src="assets/images/ui-zac.jpg" class="img-circle" width="80"></p>
                        <p><b>Zac Snider</b></p>
                        <div class="row">
                          <div class="col-md-6">
                            <p class="small mt">MEMBER SINCE</p>
                            <p>2012</p>
                          </div>
                          <div class="col-md-6">
                            <p class="small mt">TOTAL SPEND</p>
                            <p>$ 47,60</p>
                          </div>
                        </div>
                      </div>
                    </div-->



                  </div>
                  



            </div>

          </div>
      
        </section><!--/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              Developed by Asphalo Studios
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
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
