<?php
  
  session_start();
  date_default_timezone_set("Asia/Kolkata");
 //unset($_SESSION['user']);
  if(!isset($_SESSION['user'])){
    header("location:enroll.php");
  }
  //echo json_encode($_SESSION['user']);
  $userid=$_SESSION['user'][0];
  $username=$_SESSION['user'][1];

  $useremail=$_SESSION['user'][3];
  $usercredit=$_SESSION['user'][4];
  $usertime=$_SESSION['user'][5];

//  $userid=1;

  include_once 'includes/db_connect.php';
  include_once 'core/stock_functions.php';

  $news=getNews("core/data/news.xml");
  $news=array_reverse($news);
  $stockdata=getStock("core/stock.xml");

  $stmt1="SELECT * FROM vsm_transaction WHERE user_id='$userid' AND trashed=0 ORDER BY timestamp DESC LIMIT 6"; 
  $stmt2="SELECT * FROM vsm_portfolio WHERE user_id='$userid' AND state=0 AND trashed=0";
  $stmt3="  SELECT stock_id, SUM(bought+sold) AS netvolume 
            FROM vsm_portfolio 
            WHERE trashed=0
            GROUP BY stock_id
            ORDER BY netvolume DESC LIMIT 3";
    $stmt4="  SELECT u.id as userid,u.tek_name as name,u.username as username ,u.credit,p.stock_id,p.id, SUM((p.bought-p.sold)*p.value*0.995) AS stocktotal, SUM((p.bought-p.sold)*p.value*0.995)+u.credit AS total
            FROM vsm_user u 
            LEFT JOIN vsm_portfolio p ON u.id=p.user_id
            WHERE u.trashed = 0 AND u.id!=23
            GROUP BY u.id
            ORDER BY total DESC LIMIT 5";
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
      color: hsl(191 ,36% ,20%);
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
      color: hsl(191 ,36% ,5%);
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
      color:hsl(191 ,36% ,5%);
      }

      .pn .upperhalf{
        height:50%;
        border-bottom: 2px solid hsl(183,47%,71%);
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
		<!-- <div class="alert alert-warning"><b>There is some issue</b><br />Users are losing their account on VSM. We accept that their is a bug. If you seem to have the same problem, text +91-8007029068, saying "VSM Account Retrieval" followed by you "First Name" and "Email ID" registered with Teknack '15.<br />Sorry for the inconvenience</div>
     -->            <div class="row">
                  <div class="col-lg-6">
                    <h3>Portfolio</h3>
                    <div class="row">
                    <?php
                      echo '<div class="col-lg-6 mb">
                              <!-- WHITE PANEL - TOP USER -->
                              <div style="padding:20px;text-align:left" class="darkblue-panel pn">   
                                <h3>'.$usertekname.'</h3>
                                <h5 style="padding-top:0px;">('.$username.')</h5>
                                <div style="padding-top:60px; color:hsl(191 ,36% ,20%);">
                                  <p>Joined: '.date("jS M, Y",strtotime($usertime)).'</p>
                                  <p>Email: '.$useremail.'</p>
                                </div>
                              </div>
                            </div>
                      

                            <div class="col-lg-6 mb">
                              <!-- WHITE PANEL - TOP USER -->
                              <div style="padding:0px 10px;color:hsl(191 ,36% ,2  0%);" class="white-panel pn">
                                <div class="upperhalf">
                                  <div class="col-xs-5">
                                      <span style="font-size:64px;" aria-hidden="true" class="icon-wallet"></span>
                                  </div>
                                  <div class="col-xs-7">
                                    <p style="padding-top:20px;">Rs. '.$usercredit.'</p>
                                  </div>
                                </div>
                                <div class="lowerhalf">';

                                $query2=$con->query($stmt2);
                                if ($query2) {
                                  $stocksamount=$query2->num_rows;
                                }
                                else{
                                  echo "Error: ".$con->error;
                                }

                      echo '
                                  <div class="col-xs-5">
                                      <span style="font-size:64px;" aria-hidden="true" class="icon-graph"></span>
                                  </div>
                                  <div class="col-xs-7">
                                    <p style="padding-top:20px;">'.$stocksamount.' Stock(s)</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                      ';                      
                    ?>
                    </div>
                  </div>



                  <div class="col-lg-6">
                    <h3>Scoreboard</h3>
                    <div class="row">
                      <div class="col-lg-12 mb">
                        <!-- WHITE PANEL - TOP USER -->
                        <div style="padding:10px;text-align:left;" class="white-panel pn">
                          <table class="table table-responsive">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>VSM Alias</th>
                                <th>Total Score</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                              $query4=$con->query($stmt4);
                              $i=1;
                              while ($row=$query4->fetch_array(MYSQLI_ASSOC)) {
                                echo '
                                          <tr>
                                            <td>'.$i.'</td>
                                            <td>'.$row["name"].'</td>
                                            <td>'.$row["username"].'</td>
                                            <td>'.round($row["total"],2).'</td>
                                          </tr>
                                        ';
                                $i++;
                              }
                            ?>
                            </tbody>
                          </table>
                        </div>

                      </div>
                    </div>
                    </div>



                </div>
          		  
                

              <div class="row mt">
                <div class="col-md-9 col-sm-12">

                    <h3>Hot Stocks</h3>
                      <div class="row">
                      <?php 
                        $query3=$con->query($stmt3);
                        if ($query3) {
                          while ($row=$query3->fetch_array(MYSQLI_ASSOC)) {
                            $stock=$stockdata[$row['stock_id']-1];
                            $stockprice=$stock['latest'][1];
                            $stockpricediff=round($stockprice-$stock['parentvalue'],2);
                            foreach ($stock['points'] as $value) {
                              //echo $value[1];
                              $point[]=$value[1];
                            }

                            $point = array_splice($point, (sizeof($point)-10));

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
                              <div class="col-md-4 col-sm-4 mb">
                                <div class="darkblue-panel pn">
                                  <div class="darkblue-header">
                                    <h4>'.$stock["name"].'</h4>
                                  </div>
                                  <div style="margin-bottom:10px;" class="chart mt">
                                    <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="hsl(191 ,36% ,50%)" data-spot-color="hsl(191 ,36% ,30%)" data-fill-color="" data-highlight-line-color="#000" data-spot-radius="4" data-data="'.json_encode($point).'"></div>
                                  </div>
                                  '.$pricestring.'
                                  <div style="margin-top:15px;padding:10px;"><a href="trade.php?sid='.$stock["id"].'" class="btn btn-trans-white btn-block">Trade</a></div>
                                </div>
                              </div>
                            ';
                            unset($point);
                          }
                        }
                        else{
                          echo "Error : ".$con->error;
                        }
                      ?>
                      </div>

                      <h3>News</h3>

                      <div class="row">

                        <?php
                          $i=0;
                          foreach ($news as $value) {
                            if ($i>5) {
                              break;
                            }
                            echo "<div class=\"col-md-4 mb\">
                                    <div style=\"text-align:justify; padding:20px 10px;\" class=\"white-panel pn\">
                                      <h4 style=\"\">".$value['title']."</h4>
                                      <h6  ><span class=\"glyphicon glyphicon-time\"></span>&nbsp;".$value['timestamp']."</h6>
                                      <p style=\"margin-left:10px;margin-right:10px;\" class=\"text-justify\"><small>".$value['description']."</small></p>
                                      
                                    </div>
                                  </div>";
                            $i++;
                          }
                        ?>
                    
                  </div>
                </div>


                <div class="col-md-3 col-sm-12">
                    <h3>Transactions</h3>
                    <div style="background:  hsl(183,47%,91%);" class="pn-double">
                      <div class="col-sm-12 ds">
                        <?php 
                          $query1=$con->query($stmt1);
                          if (!$query1) {
                            echo "error";
                          }
                          while ($row=$query1->fetch_array(MYSQLI_ASSOC)) {

                            //echo $row['credit_before'];
                            if ($row['buysell']==true) {
                              $transtmt="<span style='color:hsl(120,100%,30%);'>Bought</span> ";
                            }
                            else{
                              $transtmt="<span style='color:hsl(39,100%,30%);'>Sold</span> ";
                            }
                            $transtmt.=$row['volume']." shares of ";
                            $stockname=$stockdata[$row['stock_id']-1]['name'];
                            $transtmt.=$stockname." at ".$row['amount']." INR";
                            echo '<div class="desc" >
                                      
                                    <div >
                                      <p><span><i class="fa fa-clock-o"></i></span>&nbsp;&nbsp;'.$row["timestamp"].'<br/>
                                        <span style="font-size:12px"> '.$transtmt.'</span><br/>
                                      </p>
                                    </div>
                                  </div>';
                          }
                          
                        ?>
                      </div>
                      
                    </div>
                </div>

                <div>
                  
                </div>
                
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
