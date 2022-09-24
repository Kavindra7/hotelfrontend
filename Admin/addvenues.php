<?php

error_reporting(~E_ALL );
session_start();

if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $number = $_POST["number"];
    $roomarray  = $_POST["roomarray"];


  include 'config.php';

  $url = $projcet_URL."/venues";

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
    "venue_name": "'.$name.'",
    "venue_address": "'.$address.'",
    "venue_city": "'.$city.'",
    "venue_contact_number": "'.$number.'",
    "rooms": '.$roomarray.'
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
  text: 'Venue added is successful.!'
  }).then(function() {
         
   window.location.href = 'venues.php';
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
         
   window.location.href = 'addvenues.php';
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
      <li><a href="viewReservation.php"  ><span class="las la-calendar"></span><span>Reservation</span></a></li>
        <li><a href="checkin.php" ><span class="las la-plus-square"></span><span>Check In</span></a></li>
        <?php  } ?>
        <li><a href="venues.php"  class="active"><span class="las la-hotel"></span><span>Venues Details</span></a></li>
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
        <h1>Add New Venue</h1>
      </div>
    </div>
    
  </header>
  <main>

  <form method="post" action="<?php  $_PHP_SELF ?>"    role="form">

  <b>Venue Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>
<input type="text" name="name" placeholder="Venue Name" required  >

<br>
<b>Venue Address:&nbsp;&nbsp;&nbsp;</b>
<input type="text" name="address" placeholder="Venue Address"  required >
<br>
<b>Venue City: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
<input type="text" name="city" placeholder="Venue City"  required >

<br>
<b>Contact Number:</b> 
<input type="text" name="number" placeholder="Contact Number"  required >
<br>
<b>Room Deatials:</b> <br>
<div class="row">
  
<input type="text" name="room_type" id="room_type" placeholder="Room Type" style="width:30% !important;"   >

<input type="text" name="max_no_of_occupants" id="max_no_of_occupants" placeholder="Max no of occupants" style="width:18% !important;"   >

<input type="text" name="no_of_rooms" id="no_of_rooms" placeholder="No of rooms" style="width:18% !important;"    >

<input type="text" name="base_fee" id="base_fee" placeholder="Base fee" style="width:18% !important;"     >
<span  onclick="addRoomData()"   class="las la-plus" style="margin-left:5px;border-radius:10px;font-size:30px !important;background-color: #06032b !important;padding:5px;color: #fff !important;"></span>
<input type="hidden" name="roomarray" id="roomarray"  >
</div>
<br><br>


<button type="submit" name="submit" class="btn btn-succes">
    <span class="las la-check-square"></span>
    Submit Data
  </button>

  </form>
  </main>
</div>

<script>
    
 function addRoomData(){
    
    var  room_type = document.getElementById("room_type").value; 
     var  max_no_of_occupants = document.getElementById("max_no_of_occupants").value; 
     var  no_of_rooms = document.getElementById("no_of_rooms").value; 
    var  base_fee = document.getElementById("base_fee").value; 
    var roomarrayString = document.getElementById("roomarray").value;  
    
    if(roomarrayString==""){
        var  roomarray =  [];
    }else{
        var  roomarray = JSON.parse(roomarrayString);
    }
    if(room_type==""){
        document.getElementById("room_type").focus();
    }else if(max_no_of_occupants =="" ){
        document.getElementById("max_no_of_occupants").focus();
    }else if(no_of_rooms =="" ){
        document.getElementById("no_of_rooms").focus();
    }else if(base_fee =="" ){
        document.getElementById("base_fee").focus();
    }else{
    var obj = {};
    obj['room_type'] = room_type;
    obj['max_no_of_occupants'] = parseInt(max_no_of_occupants);
    obj['no_of_rooms'] = parseInt(no_of_rooms);
    obj['base_fee'] = parseInt(base_fee);
    
     roomarray.push(obj);
     document.getElementById("roomarray").value = JSON.stringify(roomarray);
     document.getElementById("room_type").value = "";
     document.getElementById("max_no_of_occupants").value = "";
     document.getElementById("no_of_rooms").value = "";
     document.getElementById("base_fee").value= "";
    }
 }
</script>

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
}

?>