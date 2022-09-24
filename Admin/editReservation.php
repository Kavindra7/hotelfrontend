<?php

error_reporting(~E_ALL );
session_start();
include 'config.php';

if(isset($_POST["paysub"])){
      
    include 'config.php';

    $url = $projcet_URL."/payments/customer";
    $id = $_POST["id"];
    $fee = $_POST["fee"];
    $nights = $_POST["nights"];
  
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $authorization = "Authorization: Bearer ".$_SESSION['token']; 
    $headers = array(
    "Content-Type: application/json",
    $authorization 
    );
  
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  
    $data ='{
      "reservation_id": "'.$id.'",
      "no_of_additional_nights": "'.$nights.'",
      "fee_for_additional_nights": "'.$fee.'"
  }';
  
    curl_setopt($curl, CURLOPT_POSTFIELDS,  $data );
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  
    $resp = curl_exec($curl);
    curl_close($curl);
  
  
  
  
    $result = json_decode($resp, true);
   if($result["status"]=="Success"){
  
    echo "
    <html>	
        <link rel='stylesheet' type='text/css' href='css/style.css'><body>
        <script src='js/sweetalert2.all.js'></script><script>swal({
    type: 'success',
    title: 'Success...',
    text: 'Payement adding is  successful.!'
    }).then(function() {
           
     window.location.href = 'viewReservation.php';
     console.log('The Ok Button was clicked.');
     });</script></body>
     </html>";
  
   }else{
    $errorMsg = $result["message"];
    echo "
    <html>	
        <link rel='stylesheet' type='text/css' href='css/style.css'><body>
        <script src='js/sweetalert2.all.js'></script><script>swal({
    type: 'error',
    title: 'Oops...',
    text: '$errorMsg'
    }).then(function() {
           
     window.location.href = 'editReservation.php';
     console.log('The Ok Button was clicked.');
     });</script></body>
     </html>";
   }
}


if(isset($_POST["addonsub"])){
      
    include 'config.php';

    
    $id = $_POST["id"]; 
    $url = $projcet_URL."/addon"."/".$id;
    $addonName = $_POST["addonName"];
    $charge = $_POST["charge"];
  
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $authorization = "Authorization: Bearer ".$_SESSION['token']; 
    $headers = array(
    "Content-Type: application/json",
    $authorization 
    );
  
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  
    $data ='{
      "addonName": "'.$addonName.'",
      "charge": "'.$charge.'"
  }';
  
    curl_setopt($curl, CURLOPT_POSTFIELDS,  $data );
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  
    $resp = curl_exec($curl);
    curl_close($curl);
  
  
  
  
    $result = json_decode($resp, true);
   if($result["status"]=="Success"){
  
    echo "
    <html>	
        <link rel='stylesheet' type='text/css' href='css/style.css'><body>
        <script src='js/sweetalert2.all.js'></script><script>swal({
    type: 'success',
    title: 'Success...',
    text: 'Addon adding is  successful.!'
    }).then(function() {
           
     window.location.href = 'viewReservation.php';
     console.log('The Ok Button was clicked.');
     });</script></body>
     </html>";
  
   }else{
    $errorMsg = $result["message"];
    echo "
    <html>	
        <link rel='stylesheet' type='text/css' href='css/style.css'><body>
        <script src='js/sweetalert2.all.js'></script><script>swal({
    type: 'error',
    title: 'Oops...',
    text: '$errorMsg'
    }).then(function() {
           
     window.location.href = 'editReservation.php';
     console.log('The Ok Button was clicked.');
     });</script></body>
     </html>";
   }
}

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
        
    if(isset($_POST["addon"]) || isset($_POST["pay"]) ||  isset($_POST["checkout"]) || isset($_POST["paysub"]) || isset($_POST["addonsub"]) ){

        if(isset($_POST["checkout"])){

            include 'config.php';

            $url = $projcet_URL."/checkout/clerk";
            $id = $_POST["id"];
            $departure_date = date("d/m/Y");
          
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $authorization = "Authorization: Bearer ".$_SESSION['token']; 
            $headers = array(
            "Content-Type: application/json",
            $authorization 
            );
          
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
          
            $data ='{
              "reservation_id": "'.$id.'",
              "departure_date": "'.$departure_date.'"
          }';
          
            curl_setopt($curl, CURLOPT_POSTFIELDS,  $data );
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
          
            $resp = curl_exec($curl);
            curl_close($curl);
          
          
          
          
            $result = json_decode($resp, true);
           if($result["status"]=="Success"){
          
            echo "
            <html>	
                <link rel='stylesheet' type='text/css' href='css/style.css'><body>
                <script src='js/sweetalert2.all.js'></script><script>swal({
            type: 'success',
            title: 'Success...',
            text: 'Check out is  successful.!'
            }).then(function() {
                   
             window.location.href = 'viewReservation.php';
             console.log('The Ok Button was clicked.');
             });</script></body>
             </html>";
          
           }else{
            $errorMsg = $result["message"];
            echo "
            <html>	
                <link rel='stylesheet' type='text/css' href='css/style.css'><body>
                <script src='js/sweetalert2.all.js'></script><script>swal({
            type: 'error',
            title: 'Oops...',
            text: '$errorMsg'
            }).then(function() {
                   
             window.location.href = 'editReservation.php';
             console.log('The Ok Button was clicked.');
             });</script></body>
             </html>";
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
      <li><a href="viewReservation.php"  class="active"><span class="las la-calendar"></span><span>Reservation</span></a></li>
        <li><a href="checkin.php"  ><span class="las la-plus-square"></span><span>Check In</span></a></li>
        <?php  } ?>
        <li><a href="venues.php" ><span class="las la-hotel"></span><span>Venues Details</span></a></li>
        <li><a href="reports.php"><span class="las la-chart-bar"></span><span>Reports</span></a></li>
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
        <h1><?php echo $_POST["id"] ?></h1>
      </div>
    </div>
    
  </header>
  <main>
<?php if(isset($_POST["pay"])) { ?>
  <form method="post" action="<?php  $_PHP_SELF ?>"    role="form">

    <b>No of additional nights:&nbsp;&nbsp; </b>
    <input type="text" name="nights" placeholder="No of additional nights" required >
    <input type="hidden" name="id" value="<?php echo $_POST["id"] ;  ?>">

<br>
    <b>Fee for additional nights:</b>
    <input type="text" name="fee" placeholder="Fee for additional nights" required >

<br><br>
<button type="submit" name="paysub" class="btn btn-succes">
    <span class="las la-check-square"></span>
    Submit Data
  </button>
  </form>

<?php } ?>
<?php if(isset($_POST["addon"])) { ?>
  <form method="post" action="<?php  $_PHP_SELF ?>"    role="form">
  <input type="hidden" name="id" value="<?php echo $_POST["id"] ;  ?>">
<b>Addon Name: </b>
<input type="text" name="addonName" placeholder="Addon Name" required >

<br>
<b>Charge:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
<input type="text" name="charge" placeholder="Charge" required >

<br><br>
<button type="submit" name="addonsub" class="btn btn-succes">
<span class="las la-check-square"></span>
Submit Data
</button>
</form>
<?php } ?>
  </main>
</div>



</body>
</html>
<?php
}else{
    echo "
    <html>	
        <link rel='stylesheet' type='text/css' href='css/style.css'><body>
        <script src='js/sweetalert2.all.js'></script><script>swal({
    type: 'error',
    title: 'Oops...',
    text: 'Something wrong please try agian.!'
    }).then(function() {
           
     window.location.href = 'viewReservation.php';
     console.log('The Ok Button was clicked.');
     });</script></body>
     </html>";
   }
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
}

?>