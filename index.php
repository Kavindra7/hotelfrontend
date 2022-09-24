<?php

//error_reporting(~E_ALL );
session_start();

if(isset($_POST["submit"])){
include 'Admin/config.php';
 $full_name = $_POST["full_name"];
 $address = $_POST["address"];
 $email = $_POST["email"];
 $number = $_POST["number"];
 $satartdate = $_POST["satartdate"];
 $enddate = $_POST["enddate"];
 $hotel = $_POST["hotel"];
 $cardAdd = $_POST["cardAdd"];

 $occupants = $_POST["occupants"]+0;
 $split =  preg_split ("/\,/", $_POST["room"]);  
 $price = $split[2];
 $roomID = $split[0];

 $data ='{
  "email": "'.$email.'",
  "customer_name": "'.$full_name.'",
  "customer_address": "'.$address.'",
  "customer_contact_number": "'.$number.'",
  "arrival_date": "'.$satartdate.'",
  "departure_date": "'.$enddate.'",
  "hotel_id": "'.$hotel.'",
  "room": {
    "room_type_id": "'.$roomID.'",
    "no_of_occupants": '.$occupants.'
  }
}';

 if($cardAdd==true){
  $encryptempData=urlencode(base64_encode($data));
  echo "<script type='text/javascript'>window.location.href='pay.php?data=$encryptempData';</script>";
 }else{
   $url = $projcet_URL."/reservation/customer";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $headers = array(
  "Content-Type: application/json"
  );

  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);





  curl_setopt($curl, CURLOPT_POSTFIELDS,  $data );
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $resp = curl_exec($curl);
  curl_close($curl);




  $result = json_decode($resp, true);
 if($result["status"]=="Success"){

 $id = urlencode($result["data"]["reservation_id"]);
 $emailenr =  urlencode($result["data"]["email"]);
 $fee =  urlencode($result["data"]["base_fee"]);
  echo "
  <html>	
      <link rel='stylesheet' type='text/css' href='css/style.css'><body>
      <script src='js/sweetalert2.all.js'></script><script>swal({
  type: 'success',
  title: 'Success...',
  text: 'Reservation create successful.! Your id is : $id'
  }).then(function() {
         
   window.location.href = 'index.php';
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
  text: '$errorMsg '
  }).then(function() {
         
   window.location.href = 'index.php';
   console.log('The Ok Button was clicked.');
   });</script></body>
   </html>";
 }


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
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="images/fav.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">


        <nav style="background-color:#ffffff;" class="navbar navbar-default navbar-transparent navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand page-scroll" href="#page-top">Ocean <span style="color:#3969a1 ;font-weight: bold;">Blue</span> </a>
                </div>
    
          
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav navbar-right">
       
                        <li class="hidden">
                            <a class="page-scroll" href="#page-top"></a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#about">About</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#Booking">Booking</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#contact">Contact</a>
                        </li>
                        <li>
                        <a href="travel-company.php" class="button-link" >Reg. Travel Company</a>

                        </li>
                    </ul>
                </div>
            
            </div>
          
        </nav>
    
        <section id="intro" class="intro-section">
            <div class="container">
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Welcome to Hotel Ocean Blue</h1>
                        <p>Luxury at your fingertips</p>
                        <a class="button" href="customer/">View Booking!</a>
                    </div>
                </div>
            </div>
        </section>
    
   
        <section id="about" class="about-section">
            <div class="container">
                
                <div class="row">

                    <div class="col-lg-6">
                        <br>
                     <h3 class="sub-heading"> About As<span style="color: #303030;font-size:90px;">.</span></h3>
                   <br>
                   <p>The finest star class hotel in Sri Lanka with the best of dinning, accommodation and entertainment facilities. This 450 roomed beauty is located facing the foaming ripples of the Indian Ocean and remains to be one of the best hotels in Sri Lanka. Step-in to be lost in unearthly cuisines, cosy hideouts, heavenly surrounding and the best of services, which other hotels in Sri Lanka could not offer. Ocean Blue Hotel Sri Lanka; one of the finest hotels in Sri Lanka is not only the best place to relax, eat and indulge, but is also the finest place to celebrate. Come! Delight & breathe the air of luxury at the heart of Colombo. </p>
                    </div>

                    <div class="col-lg-6">
                     <img class="side-img" src="images/about.jpg" alt="">
                    </div>
                </div>
            </div>
        </section>
    
    
        
        <section id="Booking" class="services-section">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6">
                        <img class="side-img-2" src="images/book.jpg" alt="">
                     </div>

                    <div class="col-lg-6">
                        <br>
                        <h3 class="sub-heading"> Book Now<span style="color: #303030;font-size:90px;">.</span></h3>
                      <br>
                      <form method="post" action="<?php  $_PHP_SELF ?>"  >
                        <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="full_name">Full Name</label>
                              <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" required>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="address">Address </label>
                              <input type="text" class="form-control" name="address" id="address" placeholder="Address" required>
                            </div>
                          </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="number">Phone Number </label>
                            <input type="text" class="form-control" name="number" id="number" placeholder="Phone Number " required>
                          </div>
                        </div>

                   

                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="satartdate">Start Date</label>
                              <input type="date" class="form-control" name="satartdate" id="satartdate" placeholder="Start Date" required>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="enddate">End Date</label>
                              <input type="date" class="form-control" name="enddate" id="enddate" placeholder="End Date" required>
                            </div>
                           
                          </div>
                        
                          <div class="form-row">
                            <div class="form-group col-md-6">
                            <?php
 include 'Admin/config.php';
$url =$projcet_URL."/venues";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPGET, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array(
"Content-Type: application/json"
);


curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);




$result = json_decode($resp, true);

if($result["status"]=="Success"){
  $data = $result["data"]["venues"];
?>
                              <label for="hotel">Select Hotel</label>
                              <select class="form-control" name="hotel" onchange="showRoomData(this.value)" id="hotel" aria-label="Default select example">
                              <?php  foreach($data as $value){ ?>
                                <option value="<?php echo $value["venue_id"];  ?>"> <?php echo $value["venue_name"];  ?></option>
                                <?php }?>
                              </select>

                              <?php } ?>
                            </div>
                            <div class="form-group col-md-6" id="roomData">
                               </div>
                           
                          </div>

                          <div class="form-row">
                          <div class="form-group col-md-6" id="maxOcData">
                               </div>
                               <div class="form-group col-md-6">
                               </div>
                          </div>
                          <br>
                          <div class="form-check" id="carddata" >
                            <input class="form-check-input" type="checkbox" name="cardAdd"  id="cardAdd">
                            <label class="form-check-label" for="cardAdd">
                                  Add Card Details to Pay
                            </label>
                          </div>
                          <button name="submit" type="submit" id="sub-btn" >Book Now</button>
                      </form>
                    </div>
                </div>
            </div>
        </section>
    
        <script>
function showRoomData(str) {
  var xhttp;    
  if (str == "") {
    document.getElementById("roomData").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("roomData").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "getrooms.php?hotelid="+str, true);
  xhttp.send();
}

function showOccupants(str) {
  if(str!==""){
  var xhttp;    
  if (str == "") {
    document.getElementById("maxOcData").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("maxOcData").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "MaxOccupants.php?data="+str, true);
  xhttp.send();
}
}
function showBtn(){
  var x = document.getElementById("sub-btn");
  var a = document.getElementById("carddata");
  a.style.display = "block";
  x.style.display = "block";
}
</script>
    

        <section id="contact" class="contact-section">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6">
                        <br>
                        <h3 class="sub-heading"> Contact Now<span style="color: #303030;font-size:90px;">.</span></h3>
                      <br>
                      <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">First Name</label>
                              <input type="text" class="form-control" id="inputEmail4" placeholder="First Name">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputPassword4">Last Name </label>
                              <input type="text" class="form-control" id="inputPassword4" placeholder="Last Name ">
                            </div>
                          </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="inputPassword4">Phone Number </label>
                            <input type="text" class="form-control" id="inputPassword4" placeholder="Phone Number ">
                          </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label for="inputEmail4">Subject</label>
                              <input type="text" class="form-control" id="inputEmail4" placeholder="Number Of Children">
                            </div>
                            
                          </div>


                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label for="inputEmail4">Message</label>
                              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                          
                           
                          </div>
                          <br />
                       
                          <button type="button" class="button" >Send</button>
                      </form>
                    </div>

                    <div class="col-lg-6">
                        <img class="side-img" src="images/contact.jpg" alt="">
                       </div>
                </div>
            </div>
        </section>

        <footer>
            <p style="text-align:center">  &copy; Ocean Blue. 2022. All rights reserved. </p>
         </footer>
        
    
        <script>
           
    var header_height  = $('.navbar').height(),
        intro_height    = $('.intro-section').height(),
        offset_val = intro_height + header_height;
    $(window).scroll(function() {
      var scroll_top = $(window).scrollTop();
        if (scroll_top >= offset_val) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
                $(".navbar-fixed-top").removeClass("navbar-transparent");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
          $(".navbar-fixed-top").addClass("navbar-transparent");
        }
    });
    

    $(function() {
        $('a.page-scroll').bind('click', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
    });
    
    
    // //jQuery to collapse the navbar on scroll
    // $(window).scroll(function() {
    //     if ($(".navbar").offset().top > 100) {
    //         $(".navbar-fixed-top").addClass("top-nav-collapse");
    //             $(".navbar-fixed-top").removeClass("navbar-transparent");
    //     } else {
    //         $(".navbar-fixed-top").removeClass("top-nav-collapse");
    //       $(".navbar-fixed-top").addClass("navbar-transparent");
    //     }
    // });
        </script>
    </body>
</body>
</html>