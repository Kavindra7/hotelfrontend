<?php

error_reporting(~E_ALL );
session_start();

if(isset($_POST["login"])){
    include 'config.php';
  $username = $_POST["username"];
  $password= $_POST["password"];


  $url = $projcet_URL."/auth/login";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  $headers = array(
  "Content-Type: application/json"
  );

  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

  $data ='{
    "email": "'.$username.'",
    "password": "'.$password.'"
}';

  curl_setopt($curl, CURLOPT_POSTFIELDS,  $data );
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $resp = curl_exec($curl);
  curl_close($curl);




  $result = json_decode($resp, true);
 if($result["status"]=="Success"){
    $_SESSION['userRole']=$result["data"]["user"]['userRole'];
    $_SESSION['token']=$result['token'];
    $_SESSION['login']=true;

    if($result["data"]["user"]['userRole']=="super-admin"){
        echo "<script type='text/javascript'>window.location.href='venues.php';</script>";
    }else{
        echo "<script type='text/javascript'>window.location.href='viewReservation.php';</script>";
    }
    
 }else{
    echo "
    <html>	
        <link rel='stylesheet' type='text/css' href='css/loginstyle.css'><body>
        <script src='js/sweetalert2.all.js'></script><script>swal({
    type: 'error',
    title: 'Oops...',
    text: 'You password or User Name is wrong. Please enter again both.'
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
    <link rel="stylesheet" href="css/loginstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/fav.png">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>Hotel Ocean Blue</title>
</head>
<body>
    <div class="container" id="container">
       

        <div class="form-container sign-in-container">
            
            <form method="post" action="<?php  $_PHP_SELF ?>"   id="contact-form"  style="margin-top: -30px;" class="main-form needs-validation" role="form">
               
                <h3 >User Login</h3>
                <br /><br />
                <div class="input">
                    <input type="text" placeholder="User Name" name="username" required>
                    <div class="bar"></div>
                    <div class="highlight"></div>
                 </div>
                
               <div class="input">
                    <input type="password" placeholder="Password" name="password" required>
                    <div class="bar"></div>
                    <div class="highlight"></div>
               </div> 

            

                <br /><br />
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary mt-2 mx-auto" name="login" >Login</button>
                </div>

                <a style="color:#0a9af3" href="forgetpassword.php">Reset/Forget Password?</a>

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