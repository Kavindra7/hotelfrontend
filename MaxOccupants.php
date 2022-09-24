<?php
if(isset($_GET['data'])){

 $split = preg_split ("/\,/", $_GET['data']); 
 $maxOccupantsCount = $split[1]+1;

   echo '<label for="occupants">No of Occupants</label>
        <select class="form-control" name="occupants" onchange="showBtn()" id="occupants" aria-label="Default select example">';
        for ($x = 1; $x < 100; $x++) {
            if ($x ==  $maxOccupantsCount) {
              break;
            }
         echo  '<option value="'.$x.'"  > '.$x.'</option>';
         }
       echo '</select>';


}

?>