<?php

error_reporting(~E_ALL );
session_start();

if(isset($_POST["reg"])){
  include 'Admin/config.php';
  $com_name = $_POST["com_name"];
  $email = $_POST["email"];
  $url = $projcet_URL."/auth/travel-company";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $headers = array(
  "Content-Type: application/json"
  );

  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

  $data ='{
    "email": "'.$email.'",
    "name": "'.$com_name.'"
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
      <link rel='stylesheet' type='text/css' href='Admin/css/loginstyle.css'><body>
      <script src='js/sweetalert2.all.js'></script><script>swal({
  type: 'success',
  title: 'Success...',
  text: 'Company Registrating is successful.!'
  }).then(function() {
         
   window.location.href = 'index.php';
   console.log('The Ok Button was clicked.');
   });</script></body>
   </html>";

 }else{
  $errorMsg = $result["message"];
  echo "
  <html>	
      <link rel='stylesheet' type='text/css' href='Admin/css/loginstyle.css'><body>
      <script src='js/sweetalert2.all.js'></script><script>swal({
  type: 'error',
  title: 'Oops...',
  text: '$errorMsg'
  }).then(function() {
         
   window.location.href = 'travel-company.php';
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
    <link rel="stylesheet" href="Admin/css/loginstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/fav.png">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>Hotel Ocean Blue</title>
</head>
<body>
    <div class="container" id="container">
       

        <div class="form-container sign-in-container">
            
            <form method="post" action="<?php  $_PHP_SELF ?>"   id="contact-form"  style="margin-top: -30px;" class="main-form needs-validation" role="form">
               
                <h3 >Travel Company Registration</h3>
                <br /><br />
                <div class="input">
                    <input type="text" placeholder="Company Name" name="com_name" required>
                    <div class="bar"></div>
                    <div class="highlight"></div>
                 </div>
                
               <div class="input">
                    <input type="email" placeholder="Email" name="Email" required>
                    <div class="bar"></div>
                    <div class="highlight"></div>
               </div> 

            

                <br /><br />
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary mt-2 mx-auto" name="reg" >Register</button>
                </div>

                <a style="color:#0a9af3" href="index.php">Go To Home</a>

            </form>
            
        </div>
        


        <div class="overlay-container">
          
               <img src="images/bg-1.png"  style="width: 390px !important;height:500px !important;" alt="">
            
        </div>

    </div>

    <script>

        
    </script>
</body>
</html>