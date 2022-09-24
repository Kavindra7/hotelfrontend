<?php

error_reporting(~E_ALL );
session_start();
include 'config.php';

if(isset($_POST["remove"])){
    $id = $_POST["id"];
    $url = $projcet_URL."/admin"."/".$id;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
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
            <link rel='stylesheet' type='text/css' href='css/style.css'><body>
            <script src='js/sweetalert2.all.js'></script><script>swal({
        type: 'success',
        title: 'Success...',
        text: 'Admin removed successful.!'
        }).then(function() {
               
         window.location.href = 'viewAdmin.php';
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
               
         window.location.href = 'viewAdmin.php';
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
        <li><a href="checkin.php"  ><span class="las la-plus-square"></span><span>Check In</span></a></li>
        <?php  } ?>
        <li><a href="venues.php"  ><span class="las la-hotel"></span><span>Venues Details</span></a></li>
        <li><a href="reports.php" ><span class="las la-chart-bar"></span><span>Reports</span></a></li>
        <?php if($_SESSION['userRole']=="super-admin"){ ?><li><a href="viewAdmin.php" class="active" ><span class="las la-user"></span><span>View Admin</span></a></li><?php } ?>
       
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
        <h1>View Admin</h1>
      </div>
    </div>
    
  </header>
  <main>

  <a href="addadmin.php" class="btn btn-succes" style="width:180px;">
    <span class="las la-plus"></span>
    Add Admin
</a>

<?php

  $url = $projcet_URL."/admin";

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
    $data = $result["data"]["admins"];
?>
  
  <input type="text" id="emailSearch" onkeyup="searchFunction()" placeholder="Filter using email">
    <table class="rwd-table" id="adminTable">
      <tbody>
        <tr>
          <th>Email</th>
          <th>Role</th>
          <th>Remove</th>
        </tr>
        <?php  foreach($data as $value){ ?>
        <tr>
          <td data-th="Email">
            <?php echo $value["email"];  ?>
          </td>
          <td data-th="Role">
          <?php echo $value["role"];  ?>
          </td>
        
          <td data-th="Remove">
          <form method="post" action="<?php  $_PHP_SELF ?>"    role="form">
          <input type="hidden" name="id" value="<?php echo $value["admin_id"];  ?>">
            <button type="submit" name="remove" class="btn btn-danger">
              <span class="las la-trash"></span>
              Remove
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
  input = document.getElementById("emailSearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("adminTable");
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