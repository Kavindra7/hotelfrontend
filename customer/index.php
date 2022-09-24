<?php

error_reporting(~E_ALL );
session_start();

if(isset($_POST["submit"])){
    include '../Admin/config.php';
  $username = $_POST["username"];
  $resid= $_POST["resid"];


  $url = $projcet_URL."/auth/customer";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  $headers = array(
  "Content-Type: application/json"
  );

  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

  $data ='{
    "reservation_id": "'.$resid.'",
    "email": "'.$username.'"
}';

  curl_setopt($curl, CURLOPT_POSTFIELDS,  $data );
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $resp = curl_exec($curl);
  curl_close($curl);




  $result = json_decode($resp, true);
 if($result["status"]=="Success"){
    $encryptempData=urlencode(base64_encode(json_encode($result["data"]["reservation"])));
    $_SESSION['token']=$result['token'];
    echo "<script type='text/javascript'>window.location.href='reservation.php?data=$encryptempData';</script>";
 }else{
    $error= $result["message"];
    echo "
    <html>	
        <link rel='stylesheet' type='text/css' href='../Admin/css/loginstyle.css'><body>
        <script src='../Admin/js/sweetalert2.all.js'></script><script>swal({
    type: 'error',
    title: 'Oops...',
    text: '$error'
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
    <link rel="stylesheet" href="../Admin/css/loginstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../Admin/images/fav.png">
    <title>Hotel Ocean Blue</title>
</head>
<body>
    <div class="container" id="container">
       

        <div class="form-container sign-in-container">
            
            <form method="post" action="<?php  $_PHP_SELF ?>"   id="contact-form"  style="margin-top: -30px;" class="main-form needs-validation" role="form">
               
                <h3 >Get Details Reservation </h3>
                <br /><br />
                <div class="input">
                    <input type="text" placeholder="Email" name="username" required>
                    <div class="bar"></div>
                    <div class="highlight"></div>
                 </div>
                
               <div class="input">
                    <input type="text" placeholder="Reservation ID" name="resid" required>
                    <div class="bar"></div>
                    <div class="highlight"></div>
               </div> 

            

                <br /><br />
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary mt-2 mx-auto" name="submit" >Submit</button>
                </div>


            </form>
            
        </div>
        


        <div class="overlay-container">
          
               <img src="../Admin/images/bg-1.png"  style="width: 390px !important;height:500px !important;" alt="">
            
        </div>

    </div>

    <script>

        
    </script>
</body>
</html>