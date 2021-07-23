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



if(isset($_POST['DS'])){

	$idDS = -1;
	$Qt = 1;
	$break = false;

	if(isset($_POST['Qt'])){
		$Qt = CheckPost($_POST['Qt']);
		if($Qt < 0 || $Qt > 10 ){$break == true;}
	}
	

	
	$sql = 'select idDS from Designation where uuidDS = "'.CheckPost($_POST["DS"]).'"';
	$run = mysqli_query($cn,$sql);
	if($raw=mysqli_fetch_array($run)){$idDS = $raw[0];}
	if($idDS == -1){$break == true;}


	foreach($_SESSION["ligneCommande"] as $key => $val)
	{
		if($val->Designation == $idDS){
			$break = true;
			break;
		}
	}

	if($break == false){
		if(count($_SESSION["ligneCommande"]) < 20){

			$ligne = new ligneCommande($idDS,$Qt);
			array_push($_SESSION["ligneCommande"], $ligne);
		}
	}
}

function getItemsCart(){

	global $cn;

	foreach($_SESSION["ligneCommande"] as $key => $val)
    { 
	
		$sql = 'select idDS,uuidDS,DSname,image,price from Designation where  idDS = '.$val ->Designation.'';
		$req = mysqli_query($cn,$sql);
		
		while($raw=mysqli_fetch_array($req)) {

			echo '<div class="cart_items" id="'.$key.'">
				<ul class="cart_list">
					<li class="cart_item clearfix">
						<div class="cart_item_image"><img src="'.$raw[3].'" alt=""></div>
						<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
							<div class="cart_item_name cart_info_col">
								<div class="cart_item_title">Name</div>
								<div class="cart_item_text">'.$raw[2].'</div>
							</div>

							<div class="cart_item_quantity cart_info_col">
								<div class="cart_item_title">Quantity</div>
								<div class="cart_item_text">

									<div class="product_quantity clearfix">
										<div class="def-number-input number-input safari_only">
											<button onclick="this.parentNode.querySelector('.'\'input[type=number]\''.').stepDown();this.parentNode.querySelector('.'\'input[type=number]\''.').click();" class="minus"></button>
											<input class="quantity" min="1" max="10" name="quantity" value="'.$val ->quantite.'" type="number" onclick="editqtP('.$key.',event);changeListP();" onchange="editqtP('.$key.',event);changeListP();">
											<button onclick="this.parentNode.querySelector('.'\'input[type=number]\''.').stepUp();this.parentNode.querySelector('.'\'input[type=number]\''.').click();" class="plus"></button>
										</div>
									</div>

								</div>
							</div>
							<div class="cart_item_price cart_info_col">
								<div class="cart_item_title">Price</div>
								<div class="cart_item_text">'.$raw[4].' DH</div>
							</div>
							<div class="cart_item_total cart_info_col">
								<div class="cart_item_title">Total</div>
								<div class="cart_item_text ST-2">'.($val ->quantite*$raw[4]).' DH</div>
							</div>
							<div class="cart_item_total cart_info_col">
								<div class="cart_item_title">Remove</div>
								<div class="cart_item_text">
									<button type="button" class="close" aria-label="Close" onclick="delpanier('.$key.')">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>';

		}

    }

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Cart</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="This store is your new portal for online shopping in an easy and simple way.
We provide you with various high quality products to choose the best from them at a competitive price that you will not find anywhere else.">
<link rel="icon" type="image/png" href="images/icons/logo.png"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="styles/Style_header.css">
<link rel="stylesheet" type="text/css" href="styles/cart_styles.css">
<link rel="stylesheet" type="text/css" href="styles/cart_responsive.css">
<link rel="stylesheet" type="text/css" href="styles/Style_footer.css">

</head>

<body>

<div class="super_container">
	
	<!---Star Header--->
	<?php include('Header.php'); ?>
    <!---end Header--->

	<!-- Cart -->

	<div class="cart_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="cart_container">
						<div class="cart_title">Shopping Cart</div>
						<?php getItemsCart(); ?>
						<!-- Order Total -->
						<div class="order_total">
							<div class="order_total_content text-md-right">
								<div class="order_total_title">Order Total:</div>
								<div class="order_total_amount"><span id="order_total">0</span> DH</div>
							</div>
						</div>

						<div class="cart_buttons">
							<button type="button" class="button cart_button_clear"><a href="shop.php">Continue Shopping</a></button>
							<button type="button" class="button cart_button_checkout"><a href="checkout.php">CHECKOUT</a></button>
						</div>
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
<script src="js/cart_custom.js"></script>
</body>

</html>