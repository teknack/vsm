<?php

  
  session_start();

  if(!isset($_SESSION['user'])){
    header("location:enroll.php");
  }

  $userid=$_SESSION['user'][0];
  $usercredit=$_SESSION['user'][0];
  $usertekname=$_SESSION['user'][2];
  $username=$_SESSION['user'][1];

  include_once 'includes/db_connect.php';
  include_once 'core/stock_functions.php';


  setlocale(LC_MONETARY, 'en_IN');

  $stockdata=getStock("core/stock.xml");
  //$stmt="SELECT u.*,t.";
  $stmt1="SELECT * FROM vsm_user WHERE id='$userid'";
  $stmt2="SELECT * FROM vsm_transaction WHERE user_id='$userid' AND trashed=0 ORDER BY timestamp DESC LIMIT 10";
  $stmt3="SELECT * FROM vsm_portfolio WHERE user_id='$userid' AND state=0 AND trashed=0";


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
    .darkblue-panel h4{
      font-weight: 200;
      margin-top: 10px;
      color: hsl(191 ,36% ,5%);
      }

    .darkblue-panel h3{
      font-weight: 200;
      margin-top: 10px;
      color: white;
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
                
                
                  <h3>Portfolio</h3>

                  <div class="row mt">

                    <!--user panel-->
                    <?php 
                      $query1=$con->query($stmt1);
                      if ($query1) {
                        while ($row=$query1->fetch_array(MYSQLI_ASSOC)) {
                          $tekname=$row['tek_name'];
                          $username=$row['username'];
                          $credit=money_format('%!i',$row['credit']);
                          $timestamp=$row['timestamp'];
                          $timestamp=date('jS M, Y',strtotime($timestamp));
                        }
                      }
                      else{
                        echo "Error: ".$con->error;
                      }
                      echo '<div class="col-md-3 mb">
                            <div style="padding-top:30px;" class="white-panel pn">
                             
                              <p><img src="assets/images/ui-zac.jpg"  width="80"></p>
                              <p><b>'.$tekname.'</b></p>
                              <div class="row">
                                
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                  <p class="small mt">ALIAS</p>
                                  <p>'.$username.'</p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                  <p class="small mt">JOINED</p>
                                  <p>'.$timestamp.'</p>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-sm-3 mb">
                            <div style="padding:30px 10px;" class="white-panel pn">
                                <div class="row">
                                  <span style="font-size:108px;" aria-hidden="true" class="icon-wallet"></span>
                                  <h4>In Wallet</h4>
                                  <h3><span class="fa fa-inr"></span>&nbsp;<span id="user-credit">'.$credit.'</span></h3>
                                </div><!--/grey-panel -->
                            </div><!-- /col-md-4-->
                          </div>';

                          $query2=$con->query($stmt2);
                          if($query2){
                            if($query2->num_rows>0){
                              while ($row=$query2->fetch_array(MYSQLI_ASSOC)) {
                                $moneygraphdata[]=floatval($row['credit_after']);
                              }
                            }
                            else{
                              $moneygraphdata=array(floatval($usercredit));
                            }
                          }
                          else{
                            echo "Error: ".$con->error;
                          }
                          echo '<div class="col-md-3 col-sm-3 mb">
                                  <!-- REVENUE PANEL -->
                                  <div style="padding:30px 10px;" class="white-panel pn">
                                    <h4>Money Graph</h4>
                                    <div class="chart mt">
                                      <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="hsl(191 ,36% ,50%)" data-spot-color="hsl(191 ,36% ,30%)" data-fill-color="" data-highlight-line-color="#000" data-spot-radius="4" data-data="'.json_encode(array_reverse($moneygraphdata)).'"></div>
                                    </div>
                                    <p style="margin-top:20px;" class="mt"><span class="fa fa-inr"></span>&nbsp;<span id="user-credit-graph">'.$credit.'</span></p>
                                  </div>
                                </div>';


                      $query3=$con->query($stmt3);
                      if($query3){
                        $stocksamount=$query3->num_rows;
                        echo '<div class="col-md-3 col-sm-3 mb">
                                  <div style="padding:30px 10px;" class="white-panel pn">
                                      <div class="row">
                                        <span style="font-size:108px;" aria-hidden="true" class="icon-graph"></span>
                                        <h4>In your Portfolio</h4>
                                        <h3><span id="stocks-amount">'.$stocksamount.'</span> Stocks</h3>
                                      </div><!--/grey-panel -->
                                  </div><!-- /col-md-4-->
                                </div>';

                        if($stocksamount>0){
                          
                          while($row=$query3->fetch_array(MYSQLI_ASSOC)){
                            $stockname=$stockdata[$row['stock_id']-1]['name'];
                            $stockcode=$stockdata[$row['stock_id']-1]['code'];
                            $stockparentprice=$stockdata[$row['stock_id']-1]['parentvalue'];
                            $stockprice=$stockdata[$row['stock_id']-1]['latest'][1];
                            $stockpricediff=round($stockprice-$stockparentprice,2);



                            if($stockpricediff>0){
                              $pricestring="<p style=\"color:rgb(0, 153, 0);\">".$stockprice."&nbsp;&nbsp;<span class=\"fa fa-caret-up\"></span>&nbsp;".$stockpricediff."</p>";
                            }
                            elseif ($stockpricediff==0) {
                              $pricestring="<p style=\"color:rgb(255, 180, 0);\">".$stockprice."&nbsp;&nbsp;<span class=\"fa fa-circle\"></span>&nbsp;".$stockpricediff."</p>";
                            }
                            else{
                              $pricestring="<p style=\"color:rgb(159, 52, 52);\">".$stockprice."&nbsp;&nbsp;<span class=\"fa fa-caret-down\"></span>&nbsp;".$stockpricediff."</p>";
                            }
                            echo '<div class="portfolio-stocks col-md-3 col-sm-3 mb">
                                    <div style="padding:20px 10px;text-align:left" class="darkblue-panel pn">
                                          <p style="padding-left:15px;" class="muted"><b>'.$stockcode.'</b></p>
                                          <h4 style="padding-left:15px;">'.$stockname.'</h4>
                                          <div class="clearfix" style="margin-top:5px;font-size:14px;">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                              <p>Bought at</p>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                              <p>'.$row["value"].' INR</p>
                                            </div>
                                          </div>
                                          <div class="clearfix" style="margin-top:5px;font-size:14px;">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                              <p>Volume</p>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                              <p>'.($row["bought"]-$row["sold"]).'</p>
                                            </div>
                                          </div>
                                          <div class="clearfix" style="margin-top:5px;font-size:14px;">
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                              <p>Current</p>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                              '.$pricestring.'
                                            </div>
                                          </div>

                                          <div class="clearfix" style="margin-top:10px;font-size:14px;">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                              <input class="input-stockid" type="hidden" value="'.$row["stock_id"].'">
                                              <input class="input-stockboughtvalue" type="hidden" value="'.$row["value"].'" />
                                              <button class="btn btn-trans-white btn-block btn-sell-all" name="sellall">Sell All</button>
                                            </div>
                                          </div>
                                    </div><!-- /col-md-4-->
                                  </div>';
                          }

                          
                        }
                        else{
                          echo "";
                        }
                      }
                      else{
                        echo "Error: ".$con->error;
                      }
                    ?>



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

    <script type="text/javascript">
      $(".btn-sell-all").on("click",function(){
        var stockid=$(this).siblings(".input-stockid").val();
        var stockboughtvalue=$(this).siblings(".input-stockboughtvalue").val();
        var parentelement=$(this).parents(".portfolio-stocks");
        var stocksamount=$('#stocks-amount').html();
        $.ajax({
          url:"core/transact.php",
          type:"POST",
          data:{ transactmode : 2, sid: stockid, sboughtprice : stockboughtvalue},
          dataType: "JSON",
          success: function(str){
            if (str.status==1) {
              alert("transaction successful");
              //alert(str.credit);
              //
              parentelement.fadeOut(function(){
                this.remove();
              });
              stocksamount--;
              $("#user-credit").html(str.credit);
              $("#user-credit-graph").html(str.credit);
              $('#stocks-amount').html(stocksamount);

            }
            else{
              alert("failed");
            }
            
          },
          error: function(jqXHR,textStatus){
            alert( "Request failed: " + textStatus )}
        });
      });
    </script>

    <!--script for this page-->
    
  <!--script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script-->

  </body>
</html>
