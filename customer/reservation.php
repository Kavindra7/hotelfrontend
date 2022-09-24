<?php
error_reporting(~E_ALL );
session_start();
if(isset($_POST["update"])){
    include '../Admin/config.php';
        
    $address = $_POST["address"];
    $name = $_POST["name"];
    $contact = $_POST["contact"];
    $adate = $_POST["adate"];
    $ddate= $_POST["ddate"];


    $url = $projcet_URL."/reservation/customer";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl,  CURLOPT_CUSTOMREQUEST, "PATCH");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $authorization = "Authorization: Bearer ".$_SESSION['token']; 
  $headers = array(
  "Content-Type: application/json",
  $authorization 
  );

  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

  $data ='{
    "customer_name": "'.$name.'",
    "customer_address": "'.$address.'",
    "customer_contact_number": "'.$contact.'",
    "arrival_date": "'.$adate.'",
    "departure_date": "'.$ddate.'"
}';

  curl_setopt($curl, CURLOPT_POSTFIELDS,  $data );
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $resp = curl_exec($curl);
  curl_close($curl);




  $result = json_decode($resp, true);
 if($result["status"]=="Success"){
    $encryptempData=urlencode(base64_encode(json_encode($result["data"]["updated"])));
  echo "
  <html>	
      <body>
      <script src='../Admin/js/sweetalert2.all.js'></script><script>swal({
  type: 'success',
  title: 'Success...',
  text: 'Data update is successful.!'
  }).then(function() {
         
   window.location.href = 'reservation.php?data=$encryptempData';
   console.log('The Ok Button was clicked.');
   });</script></body>
   </html>";

 }else{
  $errorMsg = $result["message"];
  $data = $_GET["data"];
  echo "
  <html>	
      <body>
      <script src='../Admin/js/sweetalert2.all.js'></script><script>swal({
  type: 'error',
  title: 'Oops...',
  text: '$errorMsg'
  }).then(function() {
         
   window.location.href = 'reservation.php?data=$data';
   console.log('The Ok Button was clicked.');
   });</script></body>
   </html>";
 }


}

if(isset($_POST["cancel"])){
    include '../Admin/config.php';

    $url = $projcet_URL."/reservation/cancel";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl,  CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $authorization = "Authorization: Bearer ".$_SESSION['token']; 
  $headers = array(
  "Content-Type: application/json",
  $authorization 
  );

  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $resp = curl_exec($curl);
  curl_close($curl);




  $result = json_decode($resp, true);
 if($result["status"]=="Success"){
   
  echo "
  <html>	
      <body>
      <script src='../Admin/js/sweetalert2.all.js'></script><script>swal({
  type: 'success',
  title: 'Success...',
  text: 'Reservation cancel is successful.!'
  }).then(function() {
         
   window.location.href = '../index.php';
   console.log('The Ok Button was clicked.');
   });</script></body>
   </html>";

 }else{
  $errorMsg = $result["message"];
  $data = $_GET["data"];
  echo "
  <html>	
      <body>
      <script src='../Admin/js/sweetalert2.all.js'></script><script>swal({
  type: 'error',
  title: 'Oops...',
  text: '$errorMsg'
  }).then(function() {
         
   window.location.href = 'reservation.php?data=$data';
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
    <link rel="icon" type="image/x-icon" href="../Admin/images/fav.png">
    <title>Hotel Ocean Blue</title>
    <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css"
  rel="stylesheet"
/>
</head>
<body>
    <?php $values = json_decode(base64_decode(urldecode($_GET["data"]))); ?>
<div class="card border border-primary shadow-0  m-5">
<form method="post" action="<?php  $_PHP_SELF ?>" >
  <div class="card-header">Reservation Id <?php echo $values->reservation_id ?></div>
  <div class="card-body">
    
    <div class="row">
        <div class="col-6">
        <div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
  <input type="text" value="<?php echo $values->customer_name ?>"  class="form-control" id="name" name="name" aria-label="Sizing example input" aria-describedby="Name" />
</div>
        
        </div>
        <div class="col-6">
        <div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Address</span>
  <input type="text" value="<?php echo $values->customer_address ?>"  class="form-control" id="address" name="address"  />
</div>
           
        </div>
    </div>
    
    <div class="row">
        <div class="col-6">
        <div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Contact Number</span>
  <input type="text" value="<?php echo $values->customer_contact_number ?>"  class="form-control" id="contact" name="contact"  />
</div>
          
        </div>
        <div class="col-6">
           <p class="fw-bold">Email : <span class="fw-normal"><?php echo $values->email ?></span></p> 
        </div>
    </div>

    <div class="row">
    <div class="col-6">
    <div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Arrival Date</span>
  <input type="date" value="<?php echo $values->arrival_date ?>"  class="form-control" id="adate" name="adate"  />
</div>
     </div>   
        <div class="col-6">
        <div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Departure Date</span>
  <input type="date" value="<?php echo $values->departure_date ?>"  class="form-control" id="ddate" name="ddate"  />
</div>
             </div>
    </div>
    
  </div>
  <div class="card-footer">
    
  <button name="update" type="submit" class="btn btn-success btn-rounded">Update</button>
  <button name="cancel"  type="submit" class="btn btn-danger btn-rounded">Cancel</button>
  </div>
  </form>
</div>
</body>
</html>