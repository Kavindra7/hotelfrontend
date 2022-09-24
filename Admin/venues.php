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
      <li><a href="viewReservation.php"  ><span class="las la-calendar"></span><span>Reservation</span></a></li>
        <li><a href="checkin.php"  ><span class="las la-plus-square"></span><span>Check In</span></a></li>
        <?php  } ?>
        <li><a href="venues.php" class="active" ><span class="las la-hotel"></span><span>Venues Details</span></a></li>
        <li><a href="reports.php" ><span class="las la-chart-bar"></span><span>Reports</span></a></li>
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
        <h1>View Venues</h1>
      </div>
    </div>
    
  </header>
  <main>

  <a href="addvenues.php" class="btn btn-succes" style="width:180px;">
    <span class="las la-plus"></span>
    Add Venues
</a>

<?php

  $url = $projcet_URL."/venues";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_GET, true);
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
  
  <input type="text" id="searchID" onkeyup="searchFunction()" placeholder="Filter using Hotel Name">
    <table class="rwd-table" id="hotelTable">
      <tbody>
        <tr>
          <th>Name</th>
          <th>Address</th>
          <th>City</th>
          <th>Contact Number</th>
          <th>Edit</th>
        </tr>
        <?php  foreach($data as $value){ ?>
        <tr>
          <td data-th="Name">
            <?php echo $value["venue_name"];  ?>
          </td>
          <td data-th="Address">
          <?php echo $value["venue_address"];  ?>
          </td>
          <td data-th="City">
          <?php echo $value["venue_city"];  ?>
          </td>
          <td data-th="Contact Number">
          <?php echo $value["venue_contact_number"];  ?>
          </td>
        

        
          <td data-th="Edit">
          <form method="post" action="editvenue.php"    role="form">
          <input type="hidden" name="id" value="<?php echo $value["venue_id"];  ?>">
          <input type="hidden" name="venue_name" value="<?php echo $value["venue_name"];  ?>">
          <input type="hidden" name="venue_address" value="<?php echo $value["venue_address"];  ?>">
          <input type="hidden" name="venue_city" value="<?php echo $value["venue_city"];  ?>">
          <input type="hidden" name="venue_contact_number" value="<?php echo $value["venue_contact_number"];  ?>">
            <button type="submit" name="edit" class="btn btn-main">
              <span class="las la-edit"></span>
              Edit
            </button>
        </form>
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