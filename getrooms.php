<?php

if(isset($_GET['hotelid'])){

    include 'Admin/config.php';
    $url =$projcet_URL."/venues/rooms/".$_GET['hotelid'];
    
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
        $data = $result["data"]["rooms"];

        echo '<label for="room">Select Hotel</label>
        <select class="form-control" name="room" onchange="showOccupants(this.value)"  id="room" aria-label="Default select example">
        <option value=""> Please select room type </option>
        ';
         
        foreach($data as $value){
         echo  '<option value="'.$value["room_type_id"].','.$value["max_no_of_occupants"].','.$value["base_fee"].'"> '.$value["room_type"].'  ('.$value["base_fee"].')</option>';
         }
       echo '</select>';


    }

}

?>