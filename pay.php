<?php


if(isset($_POST["submit"])){
  include 'Admin/config.php';
  $name = $_POST["name"];
  $cardNum = $_POST["cardNum"];
  $validYear = $_POST["validYear"];

  $cardData =',"credit_card_details": {
    "credit_card_number": "'.$cardNum.'",
    "credit_card_expiry_date": "'.$validYear.'",
    "card_holder_name": "'.$name.'"
    }
  }';

  $passData = substr(base64_decode(urldecode($_GET["data"])), 0, -1);
  $data = $passData.$cardData;
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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Your Bill</title>
    <link rel="icon" type="image/x-icon" href="images/fav.png">
</head>

<style>
    /* google fonts */
@import url("https://fonts.googleapis.com/css?family=Arimo|Roboto");
@import url("https://fonts.googleapis.com/css?family=Roboto+Condensed");
@import url("https://fonts.googleapis.com/css?family=Roboto:300");
@import url("https://fonts.googleapis.com/css?family=Roboto:300");
@import url("https://fonts.googleapis.com/css?family=Roboto+Condensed:300");
* {
  margin: 0;
  padding: 0;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  font-family: "Roboto", sans-serif;
}

.gridContainer {
  position: absolute;
  left: 50%;
	top: 50%;
	transform: translate(-50%,-50%);
  height: 420px;
  width: 670px;
  min-width: 0;
  min-height: 0;
  background: whitesmoke;
  -webkit-box-shadow: 0px 10px 200px 1px #c2c2c2;
  box-shadow: 0px 10px 200px 1px #c2c2c2;
  display: grid;
  grid-template: auto 1fr/repeat(4, 1fr);
  grid-template-areas: "link link link link"
 "card card form form";
}

.gridContainer .topLinks {
  grid-area: link;
  list-style-type: none;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  -webkit-box-shadow: 0px 1.5px 1px #eaeaea;
  box-shadow: 0px 1.5px 1px #eaeaea;
}

.gridContainer .topLinks li {
  display: block;
  padding: 14px 0px;
  text-transform: uppercase;
  font-size: .58rem;
  justify-self: center;
  letter-spacing: .7px;
  font-weight: 600;
  color: #acc8d5;
}

.gridContainer .topLinks li:last-child {
  color: #c1c1c1;
}

.gridContainer .topLinks li:nth-child(3) {
  position: relative;
  color: #4092b5;
}

.gridContainer .topLinks li:nth-child(3):after {
  position: absolute;
  content: " ";
  bottom: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: #4092b5;
  border-radius: 2px;
}

.creditCard {
  grid-area: card;
  width: 260px;
  height: 161px;
  min-width: 0;
  min-height: 0;
  color: #fff;
  background: -webkit-gradient(linear, left top, right top, color-stop(60%, #4092b5), color-stop(90%, #3580aa));
  background: -webkit-linear-gradient(left, #4092b5 60%, #3580aa 90%);
  background: -o-linear-gradient(left, #4092b5 60%, #3580aa 90%);
  background: linear-gradient(to right, #4092b5 60%, #3580aa 90%);
  margin-top: 82px;
  border-radius: 8px;
  justify-self: right;
  align-self: start;
  display: grid;
  justify-items: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  grid-template: repeat(4, 1fr)/19px repeat(4, 1fr) 19px;
  grid-template-areas: ". . . visa visa ."
 ". chip . visa visa . "
 ". no no no no ."
 ". name name name year .";
}

.creditCard .creditCatd > * {
  overflow: hidden;
}

.creditCard .visaLogo {
  grid-area: visa;
  overflow: hidden;
  justify-self: right;
}

.creditCard .visaLogo svg {
  height: 42px;
}

.creditCard .chipLogo {
  grid-area: chip;
  overflow: hidden;
  width: 38px;
  height: 30px;
  justify-self: left;
  margin-top: 10px;
}

.creditCard ul {
  grid-area: no;
  list-style-type: none;
  justify-self: stretch;
  display: grid;
  grid-template: 1fr/repeat(1, 1fr);
}

.creditCard ul li {
  display: inline-block;
  font-size: 18px;
  letter-spacing: 2px;
  text-align: left;
  font-family: "Roboto", sans-serif;
  font-weight: 100;
  text-shadow: 0px 0px 2px rgba(0, 0, 0, 0.6);
  word-spacing: 3.7px;
}

.creditCard .name {
  grid-area: name;
  justify-self: left;
  font-family: "Roboto Condensed", sans-serif;
  font-size: 12.8px;
  font-weight: lighter;
  text-transform: uppercase;
  letter-spacing: 1.3px;
  padding-bottom: 5px;
  font-weight: 300;
  text-shadow: 0px 0px 2px rgba(0, 0, 0, 0.6);
}

.creditCard .year {
  grid-area: year;
  justify-self: right;
  font-size: 14px;
  font-weight: lighter;
  font-family: "Roboto Condensed", sans-serif;
  text-transform: uppercase;
  letter-spacing: 2.4px;
  padding-bottom: 5px;
  font-weight: 300;
  text-shadow: 0px 0px 2px rgba(0, 0, 0, 0.6);
}

.previousStep {
  position: absolute;
  bottom: 70px;
  height: 20px;
  width: 110px;
  color: #4092b5;
  left: 65px;
  cursor: pointer;
}

.previousStep p {
  margin-top: -16px;
  margin-left: 40px;
  font-size: 10px;
  text-shadow: 0px 0px 0px rgba(0, 0, 0, 0.1);
  font-family: "Roboto", sans-serif;
  font-weight: 600;
  letter-spacing: .5px;
  cursor: pointer;
}

.previousStep .arrow {
  height: 20px;
  width: 30px;
}

.previousStep .arrow svg {
  height: 100%;
  width: 100%;
  -webkit-transform: rotate(180deg);
  -ms-transform: rotate(180deg);
  transform: rotate(180deg);
  fill: #3580aa;
}

form {
  margin: 0;
  padding: 0;
  grid-area: form;
  overflow: visible;
  width: 200px;
  min-height: 0;
  min-width: 0;
  display: grid;
  justify-self: center;
  grid-template: 45px repeat(5, 1fr) 55px/repeat(2, 1fr);
  grid-template-areas: ". ."
 "fheading fheading"
 "fname fname"
 "fcno fcno"
 "fyear fcvv"
 "btn btn"
 ". .";
}

form input {
  position: relative;
  margin-top: -12px;
  border: 0;
  border-bottom: 1px solid #ddd;
  height: 38px;
  padding: 7px 0 0 0;
  font-size: 15px;
  background: none;
  width: 100%;
  outline: none;
  color: #000;
}

form input:focus {
  border-bottom: 1.5px solid #9ad0dd;
}

form input:focus + h6 {
  color: red;
}

h6 {
  grid-area: fheading;
  font-size: 20px;
}

.inputCon {
  min-width: 0;
  min-height: 0;
  position: relative;
  color: #c1c1c1;
}

.inputCon:after {
  position: absolute;
  content: attr(data-top);
  top: -16px;
  left: 0;
  height: 10px;
  font-size: 10.4px;
  letter-spacing: .5px;
}

#name {
  grid-area: fname;
}

#cardNum {
  grid-area: fcno;
}

#validYear {
  grid-area: fyear;
  margin-right: 13px;
}

#cvv {
  grid-area: fcvv;
  margin-left: 13px;
}

button {
  margin-top: 10px;
  grid-area: btn;
  height: 36px;
  width: 198px;
  background: -webkit-gradient(linear, left top, right top, color-stop(60%, #3580aa), color-stop(90%, #4092b5));
  background: -webkit-linear-gradient(left, #3580aa 60%, #4092b5 90%);
  background: -o-linear-gradient(left, #3580aa 60%, #4092b5 90%);
  background: linear-gradient(to right, #3580aa 60%, #4092b5 90%);
  border-radius: 5px;
  border: none !important;
  text-transform: uppercase;
  letter-spacing: .5px;
  font-size: 13.5px;
  color: #acccdd;
  cursor: pointer;
  -webkit-transition: all 1s ease-out;
  -o-transition: all 1s ease-out;
  transition: all 1s ease-out;
}

button:focus {
  outline: none;
}

button span {
  margin-left: 3px;
  font-weight: bold;
  letter-spacing: .5px;
  color: #fff;
}

</style>
<body>
<div class="gridContainer">
      
      <div class="creditCard">
        <div class="visaLogo">
          <svg class="visa" enable-background="new 0 0 291.764 291.764" version="1.1" viewbox="5 70 290 200" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
            <path class="svgcolor" d="m119.26 100.23l-14.643 91.122h23.405l14.634-91.122h-23.396zm70.598 37.118c-8.179-4.039-13.193-6.765-13.193-10.896 0.1-3.756 4.24-7.604 13.485-7.604 7.604-0.191 13.193 1.596 17.433 3.374l2.124 0.948 3.182-19.065c-4.623-1.787-11.953-3.756-21.007-3.756-23.113 0-39.388 12.017-39.489 29.204-0.191 12.683 11.652 19.721 20.515 23.943 9.054 4.331 12.136 7.139 12.136 10.987-0.1 5.908-7.321 8.634-14.059 8.634-9.336 0-14.351-1.404-21.964-4.696l-3.082-1.404-3.273 19.813c5.498 2.444 15.609 4.595 26.104 4.705 24.563 0 40.546-11.835 40.747-30.152 0.08-10.048-6.165-17.744-19.659-24.035zm83.034-36.836h-18.108c-5.58 0-9.82 1.605-12.236 7.331l-34.766 83.509h24.563l6.765-18.08h27.481l3.51 18.153h21.664l-18.873-90.913zm-26.97 54.514c0.474 0.046 9.428-29.514 9.428-29.514l7.13 29.514h-16.558zm-160.86-54.796l-22.931 61.909-2.498-12.209c-4.24-14.087-17.533-29.395-32.368-36.999l20.998 78.33h24.764l36.799-91.021h-24.764v-0.01z" fill="#A9CBDC"></path>
            <path class="svgtipcolor" d="m51.916 111.98c-1.787-6.948-7.486-11.634-15.226-11.734h-36.316l-0.374 1.686c28.329 6.984 52.107 28.474 59.821 48.688l-7.905-38.64z" fill="#DDEAF1"></path>
          </svg>
        </div>
        <div class="chipLogo">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 230 384.4 300.4" width="38" height="70">
						<path d="M377.2 266.8c0 27.2-22.4 49.6-49.6 49.6H56.4c-27.2 0-49.6-22.4-49.6-49.6V107.6C6.8 80.4 29.2 58 56.4 58H328c27.2 0 49.6 22.4 49.6 49.6v159.2h-.4z" data-original="#FFD66E" data-old_color="#00FF0C" fill="rgb(237,237,237)"/>
						<path d="M327.6 51.2H56.4C25.2 51.2 0 76.8 0 107.6v158.8c0 31.2 25.2 56.8 56.4 56.8H328c31.2 0 56.4-25.2 56.4-56.4V107.6c-.4-30.8-25.6-56.4-56.8-56.4zm-104 86.8c.4 1.2.4 2 .8 2.4 0 0 0 .4.4.4.4.8.8 1.2 1.6 1.6 14 10.8 22.4 27.2 22.4 44.8s-8 34-22.4 44.8l-.4.4-1.2 1.2c0 .4-.4.4-.4.8-.4.4-.4.8-.8 1.6v74h-62.8v-73.2-.8c0-.8-.4-1.2-.4-1.6 0 0 0-.4-.4-.4-.4-.8-.8-1.2-1.6-1.6-14-10.8-22.4-27.2-22.4-44.8s8-34 22.4-44.8l1.6-1.6s0-.4.4-.4c.4-.4.4-1.2.4-1.6V64.8h62.8v72.4c-.4 0 0 .4 0 .8zm147.2 77.6H255.6c4-8.8 6-18.4 6-28.4 0-9.6-2-18.8-5.6-27.2h114.4v55.6h.4zM13.2 160H128c-3.6 8.4-5.6 17.6-5.6 27.2 0 10 2 19.6 6 28.4H13.2V160zm43.2-95.2h90.8V134c-4.4 4-8.4 8-12 12.8h-122V108c0-24 19.2-43.2 43.2-43.2zm-43.2 202v-37.6H136c3.2 4 6.8 8 10.8 11.6V310H56.4c-24-.4-43.2-19.6-43.2-43.2zm314.4 42.8h-90.8v-69.2c4-3.6 7.6-7.2 10.8-11.6h122.8v37.6c.4 24-18.8 43.2-42.8 43.2zm43.2-162.8h-122c-3.2-4.8-7.2-8.8-12-12.8V64.8h90.8c23.6 0 42.8 19.2 42.8 42.8v39.2h.4z" data-original="#005F75" class="active-path" data-old_color="#005F75" fill="rgba(0,0,0,.4)"/>
				  </svg>
        </div>
        <ul class="ccList">
          <li> </li>
        </ul>
        <h4 class="name"> </h4>
        <h4 class="year">   </h4>
      </div>
      <div class="div previousStep"> 
        
      </div>
      <form method="post" action="<?php  $_PHP_SELF ?>" id="paymentForm">
      <h6>Payment Details</h6>
        <div class="inputCon" id="name" data-top="Name on Card" required>
          <input type="text" name="name"  placeholder="Test User" />
        </div>
        <div class="inputCon"  id="cardNum" data-top="Card Number" title = "type in the card number without spaces">
          <input type="text" name="cardNum"  placeholder="0000 0000 0000 0000" required />
        </div>
        <div class="inputCon"  id="validYear" data-top="Valid Through" >
          <input type="text" name="validYear" placeholder="MM/YY" />
        </div>
        <div class="inputCon" id="cvv" data-top="CVV">
          <input type="text" placeholder="000" required/>
        </div>
 
        <button  name="submit" type="submit" >pay amount</button>
      </form>
    </div>
    <script src='js/sweetalert2.all.js'></script>
    <script>
  
window.addEventListener("load", () => {
    // forms
    let inputs = document.querySelectorAll("input");
    let ccList = document.querySelectorAll(".ccList li");
    let name = document.querySelector(".name");
    let year = document.querySelector(".year");
    let inputCon = document.querySelectorAll(".inputCon");
    let btn = document.querySelector('button');
    //credit card
    let cName = document.querySelector(".name");
    let cList = document.querySelector(".creditCard ul li");
		let cYear = document.querySelector(".creditCard .year");
    let length = inputs.length;
    let regExp =[/^[A-Za-z\'\s\.\,]+$/,/^4[0-9]{12}(?:[0-9]{3})?$/,/^[0-9]{3,4}$/];
    //focusing the text->function
    let fieldColor = (i) => {
        for (j=0; j<inputCon.length; j++){
            if( i == j) {
                inputCon[i].style.color = "rgb(64,146,181)";
            }
            else {
                inputCon[j].style.color = "rgb(193,193,193)";
            }
        }
    }
   let checkInput = (i) => {
       // Name
       if( i == 0) {
            if (inputs[0].value.match(regExp[0])) {
                cName.innerText = inputs[0].value;
                inputCon[0].style.color = "rgb(64,146,181)";
                inputs[0].style.borderBottomColor = "rgb(64,146,181)";
            }
            else if (inputs[0].value == "" || !inputs[0].value.match(regExp[0] )) {
                cName.innerText = "";
                inputs[0].style.borderBottomColor = "red";
            }
       }

       //CCard NUmber
       if ( i == 1) {
            if(inputs[1].value == "") {
                inputs[1].style.borderBottomColor = "red";
							  cList.innerText = " ";
            }
            else{
                let cNumber = inputs[1].value;
                    cNumber = cNumber.replace(/\s/g, "");
                    if(Number(cNumber)) {
                        cNumber = cNumber.match(/.{1,4}/g);
                        cNumber = cNumber.join(" ");
                        inputs[1].value = cNumber;
                        if(cNumber.length <= 0 ) {
                            cList.innerText = "";
                        }
                        else if (cNumber.length > 19) {
                            cList.innerText = cNumber.substring(0,20);
						    inputs[1].style.borderBottomColor = "red";
                            
                        }
                        else {
                            cList.innerText = cNumber;
						    inputs[1].style.borderBottomColor = "rgb(64,146,181)";
                        }
                    }
                    else  {
                 	    inputs[1].style.borderBottomColor = "red";
                    }
            }
       }
       // card Date
       else if ( i == 2) {
           let dateValue = inputs[2].value;
				   let d = dateValue.replace(/\s/g, "");
           inputs[2].style.borderBottomColor = "rgb(64,146,181)";
           cYear.innerText = inputs[2].value;
          
       }
		 
		 if(i == 3) {
			 let cV = inputs[i].value;
			 if(Number(cV) && cV.match(regExp[2])) {
				 inputs[i].style.borderBottomColor = "rgb(64,146,181)";
			 }
			 else{
				 inputs[3].style.borderBottomColor = "red";
			 }
		 }
    }
    //setting value initially in the card to that of placeholder
    cName.innerText = inputs[0].getAttribute('placeholder');
    cList.innerText = inputs[1].getAttribute('placeholder');
    cYear.innerText = inputs[2].getAttribute('placeholder') //Adding Event Listeners
    for (i = 0; i < inputCon.length; i++){
        inputs[i].addEventListener('click', fieldColor.bind(this, i));
        inputs[i].addEventListener('input', checkInput.bind(this,i));
    }
   
});

    

    </script>
</body>
</html>