
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

if(!isset($_SESSION['ligneCommande'])){
	$_SESSION["ligneCommande"]=array();
}

if(!isset($_SESSION['ligneHeart'])){
	$_SESSION["ligneHeart"]=array();
}


//----------------------------------------------- Recently Viewed -----------------------------------------------
if(!isset($_SESSION['ligneViewed'])){
	$_SESSION["ligneViewed"]=array();
}

function addViewed(){
	global $cn;
	
	if (!in_array(CheckPost($_GET["DS"]), $_SESSION["ligneViewed"])){
		array_push($_SESSION["ligneViewed"], CheckPost($_GET["DS"]));
		//$_SESSION["ligneViewed"][] = CheckPost($_GET["DS"]);
		
		$sql = "select d.vues from Designation d where d.uuidDS = '".CheckPost($_GET["DS"])."'";
		$run = mysqli_query($cn,$sql);
		if($raw=mysqli_fetch_array($run)){
			$vues = $raw[0] + 1;
			$sql = "update Designation set vues = $vues where uuidDS = '".CheckPost($_GET["DS"])."'";
			mysqli_query($cn,$sql);
		}
	}
}

$styleViewed = '';
function showViewed(){

	global $styleViewed;
	global $cn;

	$ligneViewed = '';
	$existe = 0;
	foreach($_SESSION["ligneViewed"] as $key => $val){
		$ligneViewed .= '"'.$val.'"';
		if(end($_SESSION["ligneViewed"]) != $val){
			$ligneViewed .=',';
		}
		$existe ++;
	}
	if($existe == 0)$ligneViewed = '"vide"';

	$sql = 'select idDS,uuidDS,DSname,image,price,Oldprice,DATEDIFF(SYSDATE(),dateDS) as DifDate from Designation 
	where slider1 = false and slider2 = false and uuidDS in ('.$ligneViewed.');';

	if(isset($_GET["DS"])){
		$sql = 'select idDS,uuidDS,DSname,image,price,Oldprice,DATEDIFF(SYSDATE(),dateDS) as DifDate from Designation 
		where slider1 = false and slider2 = false and uuidDS in ('.$ligneViewed.') and uuidDS <> "'.CheckPost($_GET["DS"]).'"';
	}

	$countViewed = 0;
	$run = mysqli_query($cn,$sql);
	while($raw=mysqli_fetch_array($run)){

		$countViewed ++;

		//-------------------
		$price = '';
		if($raw[4] < $raw[5]){
			$price = '<span>'.$raw[5].' DH</span>'.$raw[4].' DH';
			
		}else if($raw[4] == $raw[5] || $raw[4] > $raw[5]){
			$price = $raw[4]." DH";
		}

		//-------------------
		$new = '';
		if($raw[6] <= 5)
		{
			$new = 'is_new';
		}
		
		//-------------------
		echo '<div class="owl-item">
			<div class="viewed_item '.$new.' discount d-flex flex-column align-items-center justify-content-center text-center">
				<div class="viewed_image"><img src="'.$raw[3].'" alt=""></div>
				<div class="viewed_content text-center">
					<div class="viewed_price">'.$price.'</div>
					<div class="viewed_name"><a href="product.php?DS='.$raw[1].'">'.$raw[2].'</a></div>
				</div>
				<ul class="item_marks">
					<li class="item_mark item_new">new</li>
				</ul>
			</div>
		</div>';
	}

	if($countViewed == 0){
		$styleViewed = '<script>document.getElementsByClassName("viewed")[0].style.display = "none";</script>';
	}

}
//----------------------------------------------- Recently Viewed -----------------------------------------------



function getProduct(){

	global $cn;

	if(isset($_GET["DS"])){

		$sql = 'select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,d.Descript from Designation d 
		inner join categorie c on c.idC = d.idC where d.uuidDS = "'.CheckPost($_GET["DS"]).'";';

		$run = mysqli_query($cn,$sql);
	
		if($raw=mysqli_fetch_array($run)){
		
			$stars = "";
		
			for($i = 1 ; $i <=5 ; $i++){
				if($i <= $raw[6]){
					$stars .= '<i class="fas fa-star fa-sm text-primary"></i>';
				}
				else{
					$stars .= '<i class="fas fa-star fa-sm"></i>';
				}
			}
		
		
			$activeHeart = '';
			if (($key = array_search( CheckPost($raw[1]) , $_SESSION["ligneHeart"])) !== false) {
				$activeHeart = 'active';
			}
		
			
			
			echo '<!-- Selected Image -->
			<div class="col-lg-5 order-lg-2 order-1">
				<div class="image_selected"><img src="'.$raw[3].'" alt="">
				<div class="hover"><button class="popup-img" data-link="'.$raw[3].'" data-title=""></button></div>
				</div>
			</div>

			<!-- Description -->
			<div class="col-lg-5 order-3">
				<div class="product_description">
					<div class="product_category">'.$raw[7].'</div>
					<div class="product_name">'.$raw[2].'</div>
					<div class="">'.$stars.'</div>
					<div class="product_text"><p><textarea disabled id="txtproduct">'.$raw[8].'</textarea></p></div>
					<div class="order_info d-flex flex-row">
						<form action="cart.php" method="POST">
							<div class="clearfix" style="z-index: 1000;">

								<!-- Product Quantity -->
								<div class="product_quantity clearfix">
									<span>Quantity: </span>
									<input id="quantity_input" name="Qt" type="text" pattern="[0-9]*" value="1">
									<div class="quantity_buttons">
										<div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
										<div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
									</div>
								</div>

							</div>

							<div class="product_price">'.$raw[4].' DH</div>
							<div class="button_container">

								
								<input type="submit" class="button cart_button" value="Add to Cart"/>
								<input type="hidden" name="DS" value="'.$raw[1].'"/>

								<div class="arrivals_single_fav product_fav '.$activeHeart.'">
									<input type="hidden" class="heart" value="'.$raw[1].'"/>
									<i class="fas fa-heart"></i>
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>';


			addViewed();
		}
		

	}
	

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Single Product</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="This store is your new portal for online shopping in an easy and simple way.
We provide you with various high quality products to choose the best from them at a competitive price that you will not find anywhere else.">
<link rel="icon" type="image/png" href="images/icons/logo.png"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">

<link rel="stylesheet" type="text/css" href="styles/Style_header.css">
<link rel="stylesheet" type="text/css" href="styles/product_styles.css">
<link rel="stylesheet" type="text/css" href="styles/product_responsive.css">
<link rel="stylesheet" type="text/css" href="styles/Style_footer.css">

</head>

<body>

<div class="super_container">
	
	<!---Star Header--->
	<?php include('Header.php'); ?>
    <!---end Header--->

	<!-- Single Product -->
    
    <div class="pr-img">
		<div class="pr-content">
			<div class="img-content">
				<div class="img-close">
					<button title="Close (Esc)" type="button" class="btn-img-close">×</button>
				</div>
				<div class="img-responsive">
					<img class="p-img w-100" src="">
				</div>
			</div>
		</div>
	</div>


	<div class="single_product">
		<div class="container">
			<div class="row">

				<?php getProduct(); ?>

			</div>
		</div>
	</div>

	<!-- Recently Viewed -->

	<div class="viewed">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="viewed_title_container">
						<h3 class="viewed_title">Recently Viewed</h3>
						<div class="viewed_nav_container">
							<div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
							<div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
						</div>
					</div>

					<div class="viewed_slider_container">
						
						<!-- Recently Viewed Slider -->

						<div class="owl-carousel owl-theme viewed_slider">
							
							<!-- Recently Viewed Item -->
							<?php showViewed(); ?>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Brands -->

	<div class="brands">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="brands_slider_container">
						
						<!-- Brands Slider -->

						<div class="owl-carousel owl-theme brands_slider">
							
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_1.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_2.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_3.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_4.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_5.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_6.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_7.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_8.jpg" alt=""></div></div>

						</div>
						
						<!-- Brands Slider Navigation -->
						<div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>
						<div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>

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
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>

<script src="js/scriptAll.js"></script>
<script src="js/product_custom.js"></script>

<?php echo $styleViewed;?>

</body>

</html>