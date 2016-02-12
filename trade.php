<?php

  
  session_start();

  if(!isset($_SESSION['user'])){
    header("location:enroll.php");
  }
  //echo json_encode($_SESSION['user']);
  $userid=$_SESSION['user'][0];
  $username=$_SESSION['user'][1];
  $usertekname=$_SESSION['user'][2];
  $useremail=$_SESSION['user'][3];
  $usercredit=$_SESSION['user'][4];

  include_once 'includes/db_connect.php';
  include_once 'core/stock_functions.php';


  setlocale(LC_MONETARY, 'en_IN');

  if (isset($_GET['sid'])) {
    $sid=$_GET['sid'];
  }
  else{
    header("location:error.php?e=1");
  }

  

  $news=getNews("core/data/news.xml");
  $stockdata=getStock("core/stock.xml");
  $stock=$stockdata[$sid-1];
  if (!isset($stockdata[$sid-1])) {
    header("location:error.php?e=1");
  }
  $stockvolumeleft=portfolioVolumeCheck($con,$userid,$sid);


  $stmt1="SELECT * FROM vsm_transaction WHERE user_id='$userid' AND stock_id='$sid' AND trashed=0 ORDER BY timestamp DESC LIMIT 5";

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
    <link rel="stylesheet" type="text/css" href="resources/css/jquery.bootstrap-touchspin.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
    .textlabel-primary{
      color: hsl(183,47%,51%);
    }

    .trans-row{
      margin-bottom: 10px;
    }
    </style>
  </head>

  <body style="color:hsl(191 ,36% ,20%);">

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
              
                <div class="col-md-12 col-sm-12" style="color:#def2f3">
                <?php
                  echo "<h1>".$stock['name']."</h1>";
                ?>
                  <div id="stock-chart-overview"></div>
                </div>
                <div class="col-md-8 col-sm-12">
                  <h4 style="color:#def2f3">Value</h4>
                  <div id="stock-chart"></div>
                </div>
                <div class="col-md-4 col-sm-12 stock-pane">
                  <div style="margin-bottom:30px;" id="stock-trade">
                    <h4 style="color:#def2f3">Trade</h4>
                      <div style="margin-top:15px;" class="well clearfix">

                        <div class="row">
                          <div class="col-sm-5" style="border-right:1px solid #999">
                            <h6 style="padding:0px;">Volume Available:</h6>
                            <?php
                              echo '<h3 class="text-right"><span id="stock-volume-left">'.$stockvolumeleft.'</span></h3>';
                            ?>
                          </div>
                          <div class="col-sm-7">
                            <h6 style="padding:0px;">In account:</h6>
                            <?php
                              echo '<h3 class="text-right"><i class="fa fa-inr"></i> <span id="user-credit">'.$usercredit.'</span></h3>';
                            ?>
                          </div>
                          
                        </div>
                        
                      </div>
                      <div style="margin-top:15px;" class="well">
                        <div class="form-horizontal">
                          <div class="form-group">
                            <div class="col-sm-6">
                              <input type="text" id="stock-value" class="form-control" readonly="readonly">
                            </div>
                            <div class="col-sm-6 col-xs-12">
                              <input type="text" id="stock-amount" value="1" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-12">
                              <div class="input-group">
                                <span class="input-group-addon">+ (0.5% of <span id="stock-value-total">3586.55</span>)</span>
                                <input type="text" id="stock-grandtotal" class="form-control" readonly="readonly">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-12">
                              <button id="buy-btn" class="btn btn-success btn-block btn-transact" name="buysell" value="1" data-toggle="modal" data-target="#transactmodal" data-buysell="1">Buy</button>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-12">
                              <button id="sell-btn" class="btn btn-danger btn-block btn-transact" name="buysell" value="0" data-toggle="modal" data-target="#transactmodal" data-buysell="0">Sell</button>
                            </div>
                          </div>
                        </div>
                      </div>

                  </div>
                  <div id="stock-prev-transcations">
                    <h4 style="color:#def2f3">Previous Transactions</h4>
                    <div>
                      <?php
                         $query1=$con->query($stmt1);
                          if (!$query1) {
                            echo "error";
                          }
                          while ($row=$query1->fetch_array(MYSQLI_ASSOC)) {
                            if($row['buysell']){
                              $buysell="Bought";
                              $bssymbol="fa-minus";
                            }
                            else{
                              $buysell="Sold";
                              $bssymbol="fa-plus";
                            }
                            $time=date("d,M h:i a",strtotime($row['timestamp']));
                            $amountdesc="(".$row['volume']." x ".$row['value'].") + ".$row['fees'];
                            echo '<div class="panel panel-default">
                                    <div class="panel-body-nobuff">
                                      <h5 class="clearfix"><span class="pull-left">'.$buysell.'</span><span class="pull-right">'.$time.'</span></h5>
                                      <h3> <i class="fa '.$bssymbol.'"></i> '.$row["amount"].'</h3>
                                      <h6><i>'.$amountdesc.'</i></h6>
                                    </div>
                                  </div>';
                          }
                      ?>
                    </div>

                    
                  </div>                  
                </div>
                <div style="margin-top:20px;" class="col-md-8 col-sm-12">
                  <h4 style="margin-bottom:15px; color:#def2f3;">News</h4>
                  <div class="row">
                    <?php

                      foreach ($news as $value) {
                        if($value['stockid']==$sid){
                          echo "<div class=\"col-md-4 mb\">
                                  <div class=\"white-panel pn\">
                                    <div class=\"white-header\">
                                      <h5>".$value['title']."</h5>
                                    </div>
                                    <h6 style=\"margin-left:10px;\" class=\"text-left\"><span class=\"glyphicon glyphicon-time\"></span>&nbsp;".$value['timestamp']."</h6>
                                    <p style=\"margin-left:10px;margin-right:10px;\" class=\"text-justify\"><small>".$value['description']."<a href=\"#\">  Read more</a></small></p>
                                    
                                  </div>
                                </div>";
                        }
                      }
                    ?>
                    
                    


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


<div class="modal fade" id="transactmodal" tabindex="-1" role="dialog" aria-labelledby="transactmodallabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="transactmodallabel">Transaction Sucessful</h4>
      </div>
      <div class="modal-body">
        <div id="transaction-details">

          <div class="panel panel-default">
            <div class="row">
              <div class="col-sm-4">
                <h4 class="textlabel-primary">Transaction Date:</h4>
              </div>
              <div  class="col-sm-8">
                <h4 id="transactmodal-date"></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <h4 class="textlabel-primary">Transaction:</h4>
              </div>
              <div class="col-sm-8">
                <h4 id="transactmodal-buysell"></h4>
              </div>
            </div> 
          </div>

          <div class="panel panel-default">
            <div class="row">
              <div class="col-sm-4">
                <h4 class="textlabel-primary">Stock price:</h4>
              </div>
              <div class="col-sm-8">
                <h4 id="transactmodal-stockvalue"></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <h4 class="textlabel-primary">Volume:</h4>
              </div>
              <div class="col-sm-8">
                <h4 id="transactmodal-stockvolume"></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <h4 class="textlabel-primary">Stock fees:</h4>
              </div>
              <div class="col-sm-8">
                <h4 id="transactmodal-stockfees"></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <h4 class="textlabel-primary">Grand Total:</h4>
              </div>
              <div class="col-sm-8">
                <h4 id="transactmodal-stocktotal"></h4>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="row">
              <div class="col-sm-4">
                <h4 class="textlabel-primary">New Credit:</h4>
              </div>
              <div class="col-sm-8">
                <h4 id="transactmodal-usercredit"></h4>
              </div>
            </div>            
          </div>
         
          
          


        </div>
      
      </div>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
      </div>
    </div>
  </div>
</div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="resources/js/jquery.js"></script>
    <script src="resources/js/bootstrap.min.js"></script>
    <script src="resources/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="resources/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="resources/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="resources/js/jquery.scrollTo.min.js"></script>
    <script src="resources/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="resources/js/jquery.bootstrap-touchspin.min.js"></script>

    <script type="text/javascript" src="resources/js/highstock.js"></script>
    <script type="text/javascript" src="resources/js/exporting.js"></script>


    <!--common script for all pages-->
    <script src="resources/js/common-scripts.js"></script>
    <script type="text/javascript">
      $("#stock-amount").TouchSpin({
        min: 1,
        max: 100
      });
    </script>

    <script type="text/javascript">
      var chart; // global
      var stockname=<?php echo "'".$stock['name']."'"; ?>;
      var stockcode=<?php echo "'".$stock['code']."'"; ?>;


     function getVar(sParam){
      var sPageURL = window.location.search.substring(1);
      var sURLVariables = sPageURL.split('&');
      for (var i = 0; i < sURLVariables.length; i++){
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam){
          return sParameterName[1];
        }
        else{
          return false;
        }
      }
    }
    
    function buysellFigures(svalue,samount){
      var stotal=samount*svalue;
      var sgrandtotal=stotal+(0.005*stotal);
      $("#stock-value").val(svalue.toFixed(2));
      $("#stock-value-total").html(stotal.toFixed(2));
      $("#stock-grandtotal").val(sgrandtotal.toFixed(2));
    }


    /**
     * Request data from the server, add it to the graph and set a timeout 
     * to request again
     */
    function requestData() {
        $.ajax({
            url: 'core/stock_json.php',
            success: function(point) {
                //alert(JSON.stringify(point[0].latest[1]));
                var series = chart.series[0],
                    shift = series.data.length > 60; // shift if the series is 
                                                     // longer than 30

                // add the point
                chart.series[0].addPoint(point[getVar('sid')-1].latest, true, shift);
                
                var stockamount=$("#stock-amount").val();
                buysellFigures(point[getVar('sid')-1].latest[1],stockamount);
                // call it again after one second
                setTimeout(requestData, 1000);    
            },
            cache: false
        });
    }

    $(document).ready(function() {

        var currentdate= new Date();
        Highcharts.setOptions({
          global: {
            timezoneOffset: currentdate.getTimezoneOffset()
              }
        });

        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'stock-chart',
                defaultSeriesType: 'line',
                events: {
                    load: requestData
                }
            },
            title: {
                text: stockname+' Realtime Data Feed'
            },
            rangeSelector : {
                inputEnabled: false,
                buttons: [
                  {
                    type: 'minute',
                    count: 30,
                    text: '30m'
                  },
                  {
                    type: 'minute',
                    count: 60,
                    text: '1h'
                  },
                  {
                    type: 'day',
                    count: 1,
                    text: '1d'
                  },
                  {
                    type: 'all',
                    text: 'All'
                  }
                ],
                buttonTheme:{
                  style:{
                    width: 100
                  }
                },
                selected : 0

            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150,
                maxZoom: 60 * 1000
            },
            yAxis: {
                minPadding: 0.2,
                maxPadding: 0.2,
                title: {
                    text: 'Value',
                    margin: 80
                }
            },
            series: [{
                name: stockname+' Stock Value',
                data: [],
                type : 'line',
                threshold : null,
                tooltip : {
                    valueDecimals : 2
                }
            }]
        });        
    });
    

  //  var chart; 

   
/*
    function stockajax(s){
      $.ajax({
        url:"core/stock-ajax2.php",
        type:"POST",
        data:{stockid : s},
        dataType: "JSON",
        success: function(point){
          var series = chart.series[0],
                shift = series.data.length > 20; // shift if the series is 
                                                 // longer than 20

            // add the point
            chart.series[0].addPoint(point, true, shift);
            
            // call it again after one second
            setTimeout(requestData, 1000);
          
        },
        error: function(jqXHR,textStatus){
          alert( "Request failed: " + textStatus )
        },
        cache: false
      });
    }
    
*/
    $(document).ready(function(){

      function makeChart(){
      $.getJSON('core/stock_json.php', function (data) {
          var chartdata=data[getVar('sid')-1].points;
          chartdata.push(data[getVar('sid')-1].latest);
          var currentdate= new Date();
          Highcharts.setOptions({
            global: {
              timezoneOffset: currentdate.getTimezoneOffset()
                }
          });
          // Create the chart
          $('#stock-chart-overview').highcharts('StockChart', {


              rangeSelector : {
                  inputEnabled: $('#stock-chart-overview').width() > 480,
                  selected : 1,
                  buttons: [{
                    type: 'minute',
                    count: 1,
                    text: '1m'
                  }, {
                    type: 'minute',
                    count: 30,
                    text: '30m'
                  }, {
                    type: 'minute',
                    count: 60,
                    text: '1h'
                  }, {
                    type: 'day',
                    count: 1,
                    text: '1d'
                  }, {
                    type: 'all',
                    text: 'All'
                  }],
                  inputEnabled:false
              },

              title : {
                  text : stockname+' Stock Value'
              },

              series : [{
                  name : stockname+' Stock Value',
                  data : chartdata,
                  type : 'area',
                  threshold : null,
                  tooltip : {
                      valueDecimals : 2
                  },
                  fillColor : {
                      linearGradient : {
                          x1: 0,
                          y1: 0,
                          x2: 0,
                          y2: 1
                      },
                      stops : [
                          [0, Highcharts.getOptions().colors[0]],
                          [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                      ]
                  }
              }]
          });
      });
    }
    
    makeChart();
    setInterval(makeChart,60000); 


    var transactdetails=$('#transaction-details').html();
    $('#transactmodal').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget);
      var buysellval = button.data('buysell');
      var stockid=getVar('sid');
      var stockamount = $('#stock-amount').val();
      var stockvolumeleft = $('#stock-volume-left').html();
      var volumediff=0;

      //alert(buysellval);
      $.ajax({
        url:"core/transact.php",
        type:"POST",
        data:{ transactmode : 1, sid: stockid, sbuysell: buysellval, samount: stockamount},
        dataType: "JSON",
        success: function(str){
          if (str.status==1) {
            $("#transactmodal-date").html(str.transactdate);
            $("#transactmodal-stockvalue").html(str.stockvalue);
            $("#transactmodal-stockvolume").html(str.stockvolume);
            $("#transactmodal-stockfees").html(str.stockfees);
            $("#transactmodal-stocktotal").html(str.stocktotal);
            $("#transactmodal-usercredit").html(str.credit);

            if(buysellval==1){
              $("#transactmodal-buysell").html("Buy");
            }
            else if(buysellval==0){
              $("#transactmodal-buysell").html("Sell");
            }
            //alert("transaction successful");
            $("#user-credit").html(str.credit);

            if(buysellval==1){
              volumediff=parseInt(stockvolumeleft)+parseInt(stockamount);
            }
            else if(buysellval==0){
              volumediff=parseInt(stockvolumeleft)-parseInt(stockamount);
            }
            $('#stock-volume-left').html(volumediff);
          }
          else{
            if(str.error==1){
              $('#transaction-details').html("Some error occured with the transaction. We are sorry!");
            }
            else if(str.error==2){
              $('#transaction-details').html("You don't have anymore stock volume to sell");
            }
            else if(str.error==3){
              $('#transaction-details').html("Boo! Looks like you are out of credit.");
            }
          }
          
        },
        error: function(jqXHR,textStatus){
          alert( "Request failed: " + textStatus );
        }
      });
    }).on("hidden.bs.modal",function (event){
      $('#transaction-details').html(transactdetails);
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
  <script type="text/javascript">
     
    

  </script>
  </body>
</html>
