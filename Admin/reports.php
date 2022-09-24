<?php

//error_reporting(~E_ALL );
session_start();

if($_SESSION['login']){
  $token =$_SESSION['token'];
  $token_decode =json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))));


if($token_decode->exp < time()){
  echo "
  <html>	
      <link rel='stylesheet' type='text/css' href='css/style.css'><body>
      <script src='js/sweetalert2.all.js'></script><script>swal({
  type: 'error',
  title: 'Oops...',
  text: 'Your token has expired, Please login again.!'
  }).then(function() {
         
   window.location.href = 'index.php';
   console.log('The Ok Button was clicked.');
   });</script></body>
   </html>";
}else{
  include 'config.php';

  $currentMonth = date("m")+0;
 $lastMonth= $currentMonth -4;
 $dataOccupants = array();
 $dataRevenue= array();
 for ($currentMonth; $currentMonth < 12; $currentMonth--) {
  $url = $projcet_URL."/reports/getRevenueReportForMonth";
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $authorization = "Authorization: Bearer ".$_SESSION['token']; 
  $headers = array(
  "Content-Type: application/json",
   $authorization 
  );

  
  $year = "2022";
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  $data ='{
    "revenue_month": "'.$currentMonth.'",
    "revenue_year": "'.$year.'"
}';

  curl_setopt($curl, CURLOPT_POSTFIELDS,  $data );
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $resp = curl_exec($curl);
  curl_close($curl);


 $stringMonth =date('F', mktime(0, 0, 0, $currentMonth , 10)); 

  $result = json_decode($resp, true);

  array_push($dataOccupants,array("y" => $result["total_occupants"], "label" => $stringMonth ));
  array_push($dataRevenue,array("y" => $result["total_revenue"], "label" => $stringMonth ));
  
  if ($currentMonth == $lastMonth) {
    break;
  }
  }
 ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Ocean Blue</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="images/fav.png">
    <link rel="stylesheet" href="css/style.css">

    <script>
window.onload = function () {
 

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
  exportEnabled: true,
	theme: "light2",
	title:{
		text: "Last Five Months Total Occupants"
	},
	axisY: {
		title: " No of Occupants"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## tonnes",
		dataPoints: <?php echo json_encode($dataOccupants, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
  exportEnabled: true,
	theme: "light2",
	title:{
		text: "Last Five Months Total Revenue"
	},
	axisY: {
		title: " No of Revenue"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## tonnes",
		dataPoints: <?php echo json_encode($dataRevenue, JSON_NUMERIC_CHECK); ?>
	}]
});
chart2.render();
 
}
</script>
</head>


<body>
    <input type="checkbox" name="" id="menu-toggle">
<div class="overlay"><label for="menu-toggle">
  </label></div>
<div class="sidebar">
  <div class="sidebar-container">
    <div class="brand">
      <img src="images/logo.png" alt="logo" >
    </div>
    <div class="sidebar-avatar">
      <div>
        <img src="images/users/user1.jpeg" alt="avatar">
      </div>
      <div class="avatar-info">
        <div class="avatar-text">
          <h4><?php echo $_SESSION['userRole']; ?></h4>
        </div>
         <a href="logout.php" class="las la-power-off logout"></a>
      </div>
    </div>
    <div class="sidebar-menu">
      <ul>
      <?php if($_SESSION['userRole']=="admin"){ ?>
      <li><a href="viewReservation.php"  ><span class="las la-calendar"></span><span>Reservation</span></a></li>
        <li><a href="checkin.php"  ><span class="las la-plus-square"></span><span>Check In</span></a></li>
        <?php  } ?>
        <li><a href="venues.php"  ><span class="las la-hotel"></span><span>Venues Details</span></a></li>
        <li><a href="reports.php" class="active"><span class="las la-chart-bar"></span><span>Reports</span></a></li>
        <?php if($_SESSION['userRole']=="super-admin"){ ?><li><a href="viewAdmin.php"  ><span class="las la-user"></span><span>View Admin</span></a></li><?php } ?>
       
    </ul>
    </div>
 
  </div>
</div>
<div class="main-content">
  <header>
    <div class="header-wrapper">
      <label for="menu-toggle">
        <span class="las la-bars"></span>
      </label>
      <div class="header-title">
        <h1>Reports</h1>
      </div>
    </div>
    
  </header>
  <main>

  <div id="chartContainer" style="height: 270px; width: 80%;"></div> <br />
  <div id="chartContainer2" style="height: 270px; width: 80%;"></div>
    
  </main>
</div>
<script src="js/canvasjs.min.js"> </script>
</body>
</html>
<?php 
}
}else{
 echo "
 <html>	
     <link rel='stylesheet' type='text/css' href='css/style.css'><body>
     <script src='js/sweetalert2.all.js'></script><script>swal({
 type: 'error',
 title: 'Oops...',
 text: 'Your session is faild, Please login again.!'
 }).then(function() {
        
  window.location.href = 'index.php';
  console.log('The Ok Button was clicked.');
  });</script></body>
  </html>";
} ?>