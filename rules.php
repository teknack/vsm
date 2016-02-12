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
      color: white;
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
                
                
                <div class="col-lg-8">
                  <h1 style="margin-bottom:20px;">Guide</h1>
                  <p class="text-justify" style="font-size:14px;">Hello <b><?php echo $usertekname; ?></b>,<br />Looks like you need a little help for playing <b>"Virtual Stock Market"</b>. Well, there is not much to say when it comes to Stock Market. There is only one and only one rule and that is <b>TO MAKE MONEY</b>. Join the rigorous battle of making money by buying and selling stocks</p>
                  <p class="text-justify" style="font-size:14px;">
                    We, in this help section, can't teach you how to make more money (obviously not, 'coz then that would be cheating). But, we can surely make you acquainted with the basics of this game. Go ahead, read on.
                  </p>
                  <h3 style="padding: 10px 0px ;">Getting Started (Dashboard)</h3>
                  <p class="text-justify" style="font-size:14px;">The <b>Dashboard</b> is the main heart of the game. It gives you an overview of the game as a whole.</p>
                  <ol style="font-size:14px;">
                    <li>The Portfolio section of the dashboard shows your information which includes your name, VSM alias, email and date of joining as well as credit left in your account and number of stocks in your portfolio.</li>
                    <li>Scoreboard gives you the top three players in the game. Play harder and you might just see your name there.</li>
                    <li>The News section contains all the news that float up in the market.</li>
                    <li>Transaction section on the dashboard shows your recent transactions.</li>
                    <li>The Hot Stocks sections indicates the three major stocks which has seen a lot of activity in the market</li>
                  </ol>
                  <h3 style="padding: 10px 0px ;">Portfolio</h3>
                  <p class="text-justify" style="font-size:14px;">
                    <b>Porfolio</b> page shows the amount of money left in your account and the number of stocks in your portfolio. It also provides the functionality to directly sell your stocks from the portfolio.
                  </p>
                  <h3 style="padding: 10px 0px ;">Stocks</h3>
                  <p class="text-justify" style="font-size:14px;">
                    The <b>stocks</b> page gives you an insight of all the stocks that are available in the market. Every stock tab shows it's last ten change points. The trade button that follows allows you to trade in that particular stock.
                  </p>
                  <h3 style="padding: 10px 0px ;">Trade</h3>
                  <p class="text-justify" style="font-size:14px;">
                    <b>Trade</b> page is where all the action happens.
                  <ol style="font-size:14px;">
                      <li>The <b>Overview</b> graph is the stock overview graph and helps one detrmine the pattern in ehich the stock is changing.</li>
                      <li>The <b>Live Feed</b> graph gives the live data feed of that stock.</li>
                      <li>Buy/Sell module is where you can transact with your stock.</li>
                    </ol>
                  </p>
                  <p>Go ahead! Be the wolf of the Wall Street</p>
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
