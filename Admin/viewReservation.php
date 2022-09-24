<?php

error_reporting(~E_ALL );
session_start();
include 'config.php';


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
      <li><a href="viewReservation.php" class="active" ><span class="las la-calendar"></span><span>Reservation</span></a></li>
        <li><a href="checkin.php" ><span class="las la-plus-square"></span><span>Check In</span></a></li>
        <?php } ?>
        <li><a href="venues.php" ><span class="las la-hotel"></span><span>Venues Details</span></a></li>
        <li><a href="reports.php"><span class="las la-chart-bar"></span><span>Reports</span></a></li>
        <?php if($_SESSION['userRole']=="super-admin"){ ?><li><a href="viewAdmin.php" ><span class="las la-user"></span><span>View Admin</span></a></li><?php } ?>
       
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
        <h1>View Reservation</h1>
      </div>
    </div>
    
  </header>
  <main>


<?php

  $url = $projcet_URL."/reservation/view-all";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_GET, true);
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
    $data = $result["data"]["list"];

    
?>

<div class="card">
  
  <div class="container">
   
        <span style="font-size:24;color: #e3ffe0;">• Reserved</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span style="font-size:24;color: #dbe8ff;">• Checked-in</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span style="font-size:24;color: #ffdbdb;">• Cancelled</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span style="font-size:24;color: #fff8db;">• Checked-out</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </div>
</div> 
  
  <input type="text" id="searchID" onkeyup="searchFunction()" placeholder="Filter using Reservation ID">
    <table class="rwd-table" id="hotelTable">
      <tbody>
        <tr>
          <th>Reservation id</th>
          <th>Customer name</th>
          <th>Email</th>
          <th>Arrival date</th>
          <th>Departure date</th>
          <th>Addon / Pay/ Check Out</th>
        </tr>
        <?php  foreach($data as $value){ 
            
            
switch ($value["status"]) {
    case "Reserved":
      $cbgColor = "background-color: #e3ffe0;";
      break;
    case "Checked-in":
        $cbgColor = "background-color: #dbe8ff;";
      break;
    case "Cancelled":
        $cbgColor = "background-color: #ffdbdb;";
      break;
    case "Checked-out":
        $cbgColor = "background-color: #fff8db;";
      break;  
    default:
       $cbgColor = "background-color: #dadada;";
  }
            ?>
        <tr style="<?php echo $cbgColor; ?> ">
          <td data-th="Reservation id">
            <?php echo $value["reservation_id"];  ?>
          </td>
          <td data-th="Customer name">
          <?php echo $value["customer_name"];  ?>
          </td>
          <td data-th="Email">
          <?php echo $value["email"];  ?>
          </td>
          <td data-th="Arrival date">
          <?php echo $value["arrival_date"];  ?>
          </td>
          <td data-th="Departure date">
          <?php echo $value["departure_date"];  ?>
          </td>

        
          <td data-th="Edit" style="width:150px !important;">
            <?php if($value["status"]=="Reserved" ||  $value["status"]=="Checked-in"){ ?>
          <form method="post" action="editReservation.php"    role="form" >
          <input type="hidden" name="id" value="<?php echo $value["reservation_id"];  ?>">
          
            <button type="submit" name="addon"  data-inline="true" class="icon-btn btn-succes">
              <span class="las la-plus"></span>
            </button>
            
            <button type="submit" name="pay" data-inline="true" class="icon-btn btn-main">
              <span class="las la-credit-card"></span>
            </button>

            <button type="submit" name="checkout" data-inline="true" class="icon-btn btn-danger">
              <span class="las la-check-circle"></span>
            </button>
        </form>
<?php }?>
       
          </td>
        </tr>
       <?php }?>
        
      </tbody>
    </table>

    <?php } ?>
  </main>
</div>

<script>
function searchFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchID");
  filter = input.value.toUpperCase();
  table = document.getElementById("hotelTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
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