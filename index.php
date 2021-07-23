
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


//----------------------------------------------- Recently Viewed -----------------------------------------------
if(!isset($_SESSION['ligneViewed'])){
	$_SESSION["ligneViewed"]=array();
}


function addViewed(){
	if (!in_array(CheckPost($_GET["DS"]), $_SESSION["ligneViewed"])){
		array_push($_SESSION["ligneViewed"], CheckPost($_GET["DS"]));
		//$_SESSION["ligneViewed"][] = CheckPost($_GET["DS"]);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>PlaneteShop</title>
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
<link rel="stylesheet" type="text/css" href="plugins/slick-1.8.0/slick.css">


<link rel="stylesheet" type="text/css" href="styles/Style_header_main.css">
<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="styles/responsive.css">
<link rel="stylesheet" type="text/css" href="styles/Style_footer.css">


</head>

<body>

<div class="super_container">
	
	<!---Star Header--->
	<?php include('Header.php'); ?>
    <!---end Header--->


	
	<!-- Banner -->

	<div class="banner">
		<div class="banner_background" style="background-image:url(images/banner_background.jpg)"></div>
		<div class="container fill_height">
			<div class="row fill_height">
				
				<?php

				$sql = 'select idDS,uuidDS,DSname,image,price,Oldprice from Designation where slider1 = true;';
				$run = mysqli_query($cn,$sql);
				if($raw=mysqli_fetch_array($run)){

					$price = '';

					if($raw[4] < $raw[5]){
						$price = '<span>'.$raw[5].' DH</span>'.$raw[4].' DH';
						
					}else if($raw[4] == $raw[5] || $raw[4] > $raw[5]){
						$price = $raw[4]." DH";
					}
					echo '<div class="banner_product_image"><img src="'.$raw[3].'" alt=""></div>
					<div class="col-lg-5 offset-lg-4 fill_height">
						<div class="banner_content">
							<h1 class="banner_text">new era of smartphones and laptops</h1>
							<div class="banner_price">'.$price.'</div>
							<div class="banner_product_name">'.$raw[2].'</div>
							<div class="button banner_button"><a href="product.php?DS='.$raw[1].'">Shop Now</a></div>
						</div>
					</div>';
				}

				?>

			</div>
		</div>
	</div>

	<!-- Characteristics -->

	<div class="characteristics">
		<div class="container">
			<div class="row">

				<!-- Char. Item -->
				<div class="col-lg-3 col-md-6 char_col">
					
					<div class="char_item d-flex flex-row align-items-center justify-content-start">
						<div class="char_icon"><img src="images/char_1.png" alt=""></div>
						<div class="char_content">
							<div class="char_title">Free Delivery</div>
							<div class="char_subtitle">from 0DH</div>
						</div>
					</div>
				</div>

				<!-- Char. Item -->
				<div class="col-lg-3 col-md-6 char_col">
					
					<div class="char_item d-flex flex-row align-items-center justify-content-start">
						<div class="char_icon"><img src="images/char_2.png" alt=""></div>
						<div class="char_content">
							<div class="char_title">Guarantae</div>
							<div class="char_subtitle">100%</div>
						</div>
					</div>
				</div>

				<!-- Char. Item -->
				<div class="col-lg-3 col-md-6 char_col">
					
					<div class="char_item d-flex flex-row align-items-center justify-content-start">
						<div class="char_icon"><img src="images/char_3.png" alt=""></div>
						<div class="char_content">
							<div class="char_title">Paiement when<br>recieving</div>
						</div>
					</div>
				</div>

				<!-- Char. Item -->
				<div class="col-lg-3 col-md-6 char_col">
					
					<div class="char_item d-flex flex-row align-items-center justify-content-start">
						<div class="char_icon"><img src="images/char_4.png" alt=""></div>
						<div class="char_content">
							<div class="char_title">PREMIUM PRODUCTS</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- Hot New Arrivals -->

	<div class="new_arrivals">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="tabbed_container">
						<div class="tabs clearfix tabs-right">
							<div class="new_arrivals_title">Hot New Arrivals</div>
							<ul class="clearfix">
								<li class="active">Computers & Laptops</li>
								<li>Smartphones & Tablets</li>
							</ul>
							<div class="tabs_line"><span></span></div>
						</div>
						<div class="row">
							<div class="col-lg-9" style="z-index:1;">

								<!-- Product Panel -->
								<div class="product_panel panel active">
									<div class="arrivals_slider slider">

										<!-- Slider Items -->

										<?php

										$sql = 'select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate from Designation d 
										inner join categorie c on c.idC = d.idC where c.CTname = "Computers and Laptops" and d.slider1 = false and d.slider2 = false  ORDER BY d.idDS DESC LIMIT 20;';

										

										$run = mysqli_query($cn,$sql);

										while($raw=mysqli_fetch_array($run)){

											$new = '';
											if($raw[8] <= 5)
											{
												$new = '<li class="product_mark product_new">new</li>';
											}

											$activeHeart = '';
											if (($key = array_search( CheckPost($raw[1]) , $_SESSION["ligneHeart"])) !== false) {
												$activeHeart = 'active';
											}

											echo '<div class="arrivals_slider_item">
											<div class="border_active"></div>
											<div class="product_item is_new d-flex flex-column align-items-center justify-content-center text-center">
												<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="'.$raw[3].'" alt=""></div>
												<div class="product_content">
													<div class="product_price">'.$raw[4].' DH</div>
													<div class="product_name"><div><a href="product.php?DS='.$raw[1].'">'.$raw[2].'</a></div></div>
													<div class="product_extras">
														<form action="cart.php" method="POST">
															<button class="product_cart_button">Add to Cart</button>
															<input type="hidden" name="DS" value="'.$raw[1].'"/>
														</form>
													</div>
												</div>
	
												<div class="product_fav '.$activeHeart.'">
													<input type="hidden" class="heart" value="'.$raw[1].'"/>
													<i class="fas fa-heart"></i>
												</div>

												<ul class="product_marks">'.$new.'</ul>
											</div>
										</div>';
										}

										?>

									</div>


									<div class="arrivals_slider_dots_cover"></div>
								</div>

								<!-- Product Panel -->
								<div class="product_panel panel">
									<div class="arrivals_slider slider">
										<!-- Slider Items -->
										<?php

										$sql = 'select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate  from Designation d 
										inner join categorie c on c.idC = d.idC where c.CTname = "Smartphones and Tablets" and d.slider1 = false and d.slider2 = false  ORDER BY d.idDS DESC LIMIT 20;';

										$run = mysqli_query($cn,$sql);

										while($raw=mysqli_fetch_array($run)){

											$new = '';
											if($raw[8] <= 5)
											{
												$new = '<li class="product_mark product_new">new</li>';
											}

											$activeHeart = '';
											if (($key = array_search( CheckPost($raw[1]) , $_SESSION["ligneHeart"])) !== false) {
												$activeHeart = 'active';
											}

											echo '<div class="arrivals_slider_item">
											<div class="border_active"></div>
											<div class="product_item is_new d-flex flex-column align-items-center justify-content-center text-center">
												<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="'.$raw[3].'" alt=""></div>
												<div class="product_content">
													<div class="product_price">'.$raw[4].' DH</div>
													<div class="product_name"><div><a href="product.php?DS='.$raw[1].'">'.$raw[2].'</a></div></div>
													<div class="product_extras">
														<form action="cart.php" method="POST">
															<button class="product_cart_button">Add to Cart</button>
															<input type="hidden" name="DS" value="'.$raw[1].'"/>
														</form>
													</div>
												</div>
												<div class="product_fav '.$activeHeart.'">
													<input type="hidden" class="heart" value="'.$raw[1].'"/>
													<i class="fas fa-heart"></i>
												</div>
												<ul class="product_marks">'.$new.'</ul>
											</div>
										</div>';
										}

										?>

										
									</div>
									<div class="arrivals_slider_dots_cover"></div>
								</div>

							</div>

							<div class="col-lg-3">
								<div class="arrivals_single clearfix">
									<div class="d-flex flex-column align-items-center justify-content-center">


									<?php

										$sql = 'select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate from Designation d 
										inner join categorie c on c.idC = d.idC where (c.CTname = "Computers and Laptops" or c.CTname = "Smartphones and Tablets") and d.slider1 = false and d.slider2 = false ORDER BY d.idDS DESC LIMIT 1;';

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


											$new = '';
											if($raw[8] <= 5)
											{
												$new = '<li class="arrivals_single_mark product_mark product_new">new</li>';
											}

											$activeHeart = '';
											if (($key = array_search( CheckPost($raw[1]) , $_SESSION["ligneHeart"])) !== false) {
												$activeHeart = 'active';
											}

											
											
											echo '<div class="arrivals_single_image"><img src="'.$raw[3].'" alt=""></div>
											<div class="arrivals_single_content">
												<div class="arrivals_single_category"><a href="#">'.$raw[7].'</a></div>
												<div class="arrivals_single_name_container clearfix">
													<div class="arrivals_single_name"><a href="product.php?DS='.$raw[1].'">'.$raw[2].'</a></div>
													<div class="arrivals_single_price text-right">'.$raw[4].' DH</div>
												</div>
												<div class="">'.$stars.'</div>
												<form action="cart.php" method="POST">
													<button class="arrivals_single_button">Add to Cart</button>
													<input type="hidden" name="DS" value="'.$raw[1].'"/>
												</form>


											</div>
											<div class="arrivals_single_fav product_fav '.$activeHeart.'">
												<input type="hidden" class="heart" value="'.$raw[1].'"/>
												<i class="fas fa-heart"></i>
											</div>
											<ul class="arrivals_single_marks product_marks">'.$new.'</ul>';

										}

									?>


										



									</div>
								</div>
							</div>

						</div>
								
					</div>
				</div>
			</div>
		</div>		
	</div>
    
	<!-- Banner -->

	<div class="banner_2">
		<div class="banner_2_background" style="background-image:url(images/banner_2_background.jpg)"></div>
		<div class="banner_2_container">
			<div class="banner_2_dots"></div>
			<!-- Banner 2 Slider -->

			<div class="owl-carousel owl-theme banner_2_slider">

				<!-- Banner 2 Slider Item -->

				<?php

										$sql = 'select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,d.Descript from Designation d 
										inner join categorie c on c.idC = d.idC where d.slider2 = true ORDER BY d.idDS DESC LIMIT 6;';

										$run = mysqli_query($cn,$sql);

										while($raw=mysqli_fetch_array($run)){

											$stars = "";

											for($i = 1 ; $i <=5 ; $i++){
												if($i <= $raw[6]){
													$stars .= '<i class="fas fa-star fa-sm text-primary"></i>';
												}
												else{
													$stars .= '<i class="fas fa-star fa-sm"></i>';
												}
											}
											

											echo '<div class="owl-item">
											<div class="banner_2_item">
												<div class="container fill_height">
													<div class="row fill_height">
														<div class="col-lg-4 col-md-6 fill_height">
															<div class="banner_2_content">
																<div class="banner_2_title">'.$raw[2].'</div>
																<div class="banner_2_text">'.$raw[8].'</div>
																<div class="">'.$stars.'</div>
																<div class="button banner_2_button"><a href="product.php?DS='.$raw[1].'">Explore</a></div>
															</div>
															
														</div>
														<div class="col-lg-8 col-md-6 fill_height">
															<div class="banner_2_image_container">
																<div class="banner_2_image"><img src="'.$raw[3].'" alt=""></div>
															</div>
														</div>
													</div>
												</div>			
											</div>
										</div>';

										}
	
									?>







			</div>
		</div>
	</div>


	<!-- Popular Categories -->

	<div class="popular_categories">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<div class="popular_categories_content">
						<div class="popular_categories_title">Popular Categories</div>
						<div class="popular_categories_slider_nav">
							<div class="popular_categories_prev popular_categories_nav"><i class="fas fa-angle-left ml-auto"></i></div>
							<div class="popular_categories_next popular_categories_nav"><i class="fas fa-angle-right ml-auto"></i></div>
						</div>
						<div class="popular_categories_link"><a href="#">full catalog</a></div>
					</div>
				</div>
				
				<!-- Popular Categories Slider -->

				<div class="col-lg-9">
					<div class="popular_categories_slider_container">
						<div class="owl-carousel owl-theme popular_categories_slider">

							<!-- Popular Categories Item -->
							<div class="owl-item">
								<div class="popular_category d-flex flex-column align-items-center justify-content-center">
									<div class="popular_category_image"><img src="images/popular_1.png" alt=""></div>
									<div class="popular_category_text">Smartphones & Tablets</div>
								</div>
							</div>

							<!-- Popular Categories Item -->
							<div class="owl-item">
								<div class="popular_category d-flex flex-column align-items-center justify-content-center">
									<div class="popular_category_image"><img src="images/popular_2.png" alt=""></div>
									<div class="popular_category_text">Computers & Laptops</div>
								</div>
							</div>

							<!-- Popular Categories Item -->
							<div class="owl-item">
								<div class="popular_category d-flex flex-column align-items-center justify-content-center">
									<div class="popular_category_image"><img src="images/popular_3.png" alt=""></div>
									<div class="popular_category_text">Gadgets</div>
								</div>
							</div>

							<!-- Popular Categories Item -->
							<div class="owl-item">
								<div class="popular_category d-flex flex-column align-items-center justify-content-center">
									<div class="popular_category_image"><img src="images/popular_4.png" alt=""></div>
									<div class="popular_category_text">Video Games & Consoles</div>
								</div>
							</div>

							<!-- Popular Categories Item -->
							<div class="owl-item">
								<div class="popular_category d-flex flex-column align-items-center justify-content-center">
									<div class="popular_category_image"><img src="images/popular_5.png" alt=""></div>
									<div class="popular_category_text">Accessories</div>
								</div>
							</div>

						</div>
					</div>
				</div>
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
<script src="plugins/slick-1.8.0/slick.js"></script>
<script src="plugins/easing/easing.js"></script>

<script src="js/scriptAll.js"></script>
<script src="js/custom.js"></script>

<?php echo $styleViewed;?>


</body>
</html>