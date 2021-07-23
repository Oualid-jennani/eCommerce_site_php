<?php
require "db.php";
require "Classes.php";

session_start();


function CheckPost($var){
    $var=trim($var);
    $var=strip_tags($var);
    $var=stripslashes($var);
    if(empty($var)) return false;
    else return $var;
}


if(!isset($_SESSION['ligneHeart'])){
	$_SESSION["ligneHeart"]=array();
}

if(!isset($_SESSION['ligneCommande'])){
	$_SESSION["ligneCommande"]=array();
}


$infoSend = "";

if(isset($_POST["send"])){


  if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["message"])){

    $envoi = true;
    $infoSend = "";
    
  
	$name = CheckPost($_POST["name"]);
	$email = CheckPost($_POST["email"]);
	$phone = CheckPost($_POST["phone"]);
	$message = CheckPost($_POST["message"]);
    
 
    

  $messageText = "Message from a customer to you from PlanetShop
Nom Complet : $name
Email : $email
Phone : $phone
Message : $message";
    


    $test = true;
    if($name == ""){
		$infoSend .= '<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Danger!</strong> Invalid Name.
		</div>';
		$envoi = false;
    }
    if($email == ""){
		$infoSend .= '<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Danger!</strong> Invalid Email.
		</div>';
		$envoi = false;
    }
    if($phone == ""){
		$infoSend .= '<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Danger!</strong> Invalid namber Phone.
		</div>';
		$envoi = false;
	}
	if($message == ""){
		$infoSend .= '<div class="alert alert-danger">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <strong>Danger!</strong> Invalid Message.
		</div>';
		$envoi = false;
	}


    

  
    if($envoi == true){
		$subject="PlanetShop contact";
		$destinataire="Planetshop2020@gmail.com";
		$headers = "From:" . $email;

		$infoSend .= '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success!</strong> sent succesfully.
		</div>';

		if(mail($destinataire,$subject,$messageText,$headers))
		{
			
		}
		else{

			$infoSend .= '
			<div class="alert alert-info">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Info!</strong>your email is wrong. It was not sent.
			</div>';

		}
	  
		
    }
    
    
  }


  


}




error_reporting(0);

?>



<!DOCTYPE html>
<html lang="en">
<head>
<title>Contact</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="This store is your new portal for online shopping in an easy and simple way.
We provide you with various high quality products to choose the best from them at a competitive price that you will not find anywhere else.">
<link rel="icon" type="image/png" href="images/icons/logo.png"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="styles/Style_header.css">
<link rel="stylesheet" type="text/css" href="styles/contact_styles.css">
<link rel="stylesheet" type="text/css" href="styles/contact_responsive.css">
<link rel="stylesheet" type="text/css" href="styles/Style_footer.css">

</head>

<body>

<div class="super_container">
	

	<!---Star Header--->
	<?php include('Header.php'); ?>
    <!---end Header--->
	<div class="container"><?php echo $infoSend; ?></div>
	<!-- Contact Info -->

	<div class="contact_info">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="contact_info_container d-flex flex-lg-row flex-column justify-content-between align-items-between">

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="images/contact_1.png" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Phone</div>
								<div class="contact_info_text">+212 672 831 364</div>
							</div>
						</div>

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="images/contact_2.png" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Email</div>
								<div class="contact_info_text">Planetshop2020@gmail.com</div>
							</div>
						</div>

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="images/contact_3.png" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Address</div>
								<div class="contact_info_text">Souk Mellilia N 183 Oujda 60000</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Contact Form -->

	<div class="contact_form">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="contact_form_container">
						<div class="contact_form_title">Get in Touch</div>

						<form action="contact.php" method="post" id="contact_form">
							<div class="contact_form_inputs d-flex flex-md-row flex-column justify-content-between align-items-between">
								<input type="text" id="contact_form_name" name="name" class="contact_form_name input_field" placeholder="Your name" required="required" pattern="[A-Za-z0-9 ]{3,32}" data-error="Name is required.">
								<input type="text" id="contact_form_email" name="email"  class="contact_form_email input_field" placeholder="Your email" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error="Email is required.">
								<input type="text" id="contact_form_phone" name="phone" class="contact_form_phone input_field" placeholder="Your phone number" required="required" pattern="(05|06|07)[0-9]{8}">
							</div>
							<div class="contact_form_text">
								<textarea id="contact_form_message" name="message" class="text_field contact_form_message" name="message" rows="4" placeholder="Message" required="required" data-error="Please, write us a message."></textarea>
							</div>
							<div class="contact_form_button">
								<button type="submit" name="send" class="button contact_submit_button">Send Message</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="panel"></div>
	</div>

	<!-- Map -->

	<div class="contact_map">
		<div id="google_map" class="google_map">
			<div class="map_container">
				<div id="map"></div>
			</div>
		</div>
	</div>

	
	<!---Star footer--->
	<?php include('Footer.php'); ?>
    <!---end footer--->


<script src="js/jquery-3.3.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/greensock/TweenMax.min.js"></script>
<script src="plugins/greensock/TimelineMax.min.js"></script>
<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="plugins/greensock/animation.gsap.min.js"></script>
<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>

<script src="js/scriptAll.js"></script>
<script src="js/contact_custom.js"></script>
</body>

</html>