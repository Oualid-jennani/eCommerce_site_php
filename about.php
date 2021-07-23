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

	



$title = "About Store";

$content = "This store is your new portal for online shopping in an easy and simple way.
We provide you with various high quality products to choose the best from them at a competitive price that you will not find anywhere else. Shopping with us is fun and safe. We provide you with all the facilities you need, whether in choosing the product, in the payment process, or in the shipping process.";

if(isset($_GET["reg"])){
	
	if(CheckPost($_GET["reg"]) == "pm"){
		$title = "Payment Methods";
		$content = "Paiement when recieving : <br>
		Advance payment: 200 dirhams, cash on delivery <br>
		After contacting the support team and confirming the request, the customer must pay a deposit of 200 dirhams to reserve the product.";
	}

	if(CheckPost($_GET["reg"]) == "sh"){
		$title = "Shipping and handling";
		$content = "After confirming your purchase, we will ship and send the product via our shipping officer or other delivery services (Amana Express, Steam ...)";
	}

	if(CheckPost($_GET["reg"]) == "help"){
		$title = "Help";
		$content = "";
	}

}

	


    


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>About Store</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Planet shop project">
<link rel="icon" type="image/png" href="images/icons/logo.png"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="styles/Style_header.css">
<link rel="stylesheet" type="text/css" href="styles/about_styles.css">
<link rel="stylesheet" type="text/css" href="styles/about_responsive.css">
<link rel="stylesheet" type="text/css" href="styles/Style_footer.css">

</head>

<body>

<div class="super_container">
	
	<!---Star Header--->
	<?php include('Header.php'); ?>
    <!---end Header--->

	<!-- Single Blog Post -->

	<div class="single_post">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="single_post_title"><?php echo $title; ?></div>

					<div class="single_post_text">
						<p><?php echo $content; ?></p>

						<div class="single_post_quote text-center">
							<div class="quote_image"><img src="images/quote.png" alt=""></div>
							<div class="quote_text">You should never waste time inventing things that people will not buy.</div>
							<div class="quote_name">Thomas Edison</div>
						</div>
					</div>

					<br><br><br><br><br><br><br><br><br>

					<div class="single_post_title">When will the order arrive?</div>
					<div class="single_post_text">
						<p>It depends on the shipping company that has been selected and responsible for the delivery, we provide a group of those responsible for shipping in a group of major cities, and it usually takes from 1 to 3 days for the order to be confirmed</p>
					</div>
					

					<div class="single_post_title">Is there a delivery outside the country?</div>
					<div class="single_post_text">
						<p>
							Currently, contracted shipping companies deliver within the country and a group of cities specified on the delivery page. All cities that the shipping company's representative arrive are displayed.
							You can request delivery outside the country from the store team via WhatsApp to collect information on product weight and pricing for international shipping agents who are not currently registered in the store.
						</p>
					</div>

					<div class="single_post_title">If there is a manufacturer defect in the product?</div>
					<div class="single_post_text">
						<p>You must return and read the return policy to know the conditions for return and exchange, and in the event of a manufacturing defect, it has been agreed to return, the shipping value of the company is calculated, as well as the recharge for the customer. The value of the product is not calculated on the customer according to the return policy.</p>
					</div>

					<div class="single_post_title">I want to order large quantities, is there a discount?</div>
					<div class="single_post_text">
						<p>The store provides a delivery service for large quantities in case of ordering and there is a discount of 10-20% on some products. You can directly contact us through the Contact Us page and inquire about the quantities and the discount</p>
					</div>



				</div>
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

<script src="js/scriptAll.js"></script>
<script src="js/about_custom.js"></script>
</body>

</html>