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

$countDS = 0;

$titleCat = 'All Categories';
$cat = '';
if(isset($_GET["categorie"])){
	$cat = CheckPost($_GET["categorie"]);
	$titleCat = CheckPost($_GET["categorie"]);
}

if($cat == "All Categories"){
	$cat = '';
}


$search = '';
if(isset($_GET["search"])){
	$search ="and D.DSname like '%".CheckPost($_GET["search"])."%'";
}

function getItemsShopCat(){

	global $cn;
	global $cat;
	global $countDS;
	global $search;

	$rank = 0;
	if(isset($_GET["page"])){
		$n = CheckPost($_GET["page"]);
		$rank = ($n-1) * 20;
	}


	$sql = 'select * from (select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate,@rownum := @rownum + 1 AS rank from Designation d 
	inner join categorie c on c.idC = d.idC ,(SELECT @rownum := 0) r ORDER BY d.idDS DESC) D where D.rank > '.$rank.' '.$search.' limit 20;';

	if($cat != ''){
		$sql = 'select * from (select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate,@rownum := @rownum + 1 AS rank from Designation d 
		inner join categorie c on c.idC = d.idC ,(SELECT @rownum := 0) r where c.CTname = "'.$cat.'" ORDER BY d.idDS DESC) D where D.rank > '.$rank.' '.$search.' limit 20;';
	}

	$run = mysqli_query($cn,$sql);
	while($raw=mysqli_fetch_array($run)){
		$new = '';
		if($raw[8] <= 5)
		{
			$new = 'is_new';
		}
		$activeHeart = '';
		if (($key = array_search( CheckPost($raw[1]) , $_SESSION["ligneHeart"])) !== false) {
			$activeHeart = 'active';
		}

		echo '<div class="product_item '.$new .'">
			<div class="product_border"></div>
			<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="'.$raw[3].'" alt=""></div>
			<div class="product_content">
				<div class="product_price">'.$raw[4].' DH</div>
				<div class="product_name"><div><a href="product.php?DS='.$raw[1].'" tabindex="0">'.$raw[2].'</a></div></div>
			</div>

			<div class="product_fav '.$activeHeart.'">
				<input type="hidden" class="heart" value="'.$raw[1].'"/>
				<i class="fas fa-heart"></i>
			</div>

			<ul class="product_marks">
				<li class="product_mark product_new">new</li>
			</ul>
		</div>';

	}

}

function NavItemsCat(){

	global $cn;
	global $cat;
	global $countDS;
	global $search;

	$NbPage = 0;
	$page_prev = '';
	$page_next = '';
	$str_Nav = '';
	$linkCat = $cat;
	$linkSearch = '';

	

	$sql = 'select count(*)as countItems from (select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate,@rownum := @rownum + 1 AS rank from Designation d 
	inner join categorie c on c.idC = d.idC ,(SELECT @rownum := 0) r ORDER BY d.idDS DESC) D where D.rank > 0 '.$search.' limit 20;';

	if($cat != ''){
		$sql = 'select count(*)as countItems from (select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate,@rownum := @rownum + 1 AS rank from Designation d 
		inner join categorie c on c.idC = d.idC ,(SELECT @rownum := 0) r where c.CTname = "'.$cat.'" ORDER BY d.idDS DESC) D where D.rank > 0 '.$search.' limit 20;';
	}


	$run = mysqli_query($cn,$sql);
	if($raw=mysqli_fetch_array($run)){
		//-----------------------------------------------------------------------------------------------
		$countDS = $raw[0];
		$NbPage = (int)(($raw[0]/20) + 1);

		if($NbPage > 1){

			$n = 1;
			if(isset($_GET["page"])){$n = $_GET["page"];}

			if(isset($_GET["search"])){$linkSearch = 'search='.CheckPost($_GET["search"]).'&';}

			//--------nav ul page list
			$str_Nav .= '<ul class="page_nav d-flex flex-row">';
			for($i = 1 ; $i <= $NbPage ; $i++){
				//-----star loop----
				$linkCat = $cat;

				if($i == $n){
					$str_Nav .=  '<li class = "active">'.$i.'</li>';
				}
				else {
					if($i == 1){
						if($linkCat != '' || isset($_GET["categorie"]))$linkCat = '?'.$linkSearch.'categorie='.CheckPost($_GET["categorie"]);
						$str_Nav .=  '<li><a href="Shop.php'.$linkCat.'">'.$i.'</a></li>';
					}
					else {
						if($linkCat != '' || isset($_GET["categorie"]))$linkCat = $linkSearch.'categorie='.CheckPost($_GET["categorie"]).'&';
						$str_Nav .=  '<li><a href="Shop.php?'.$linkCat.'page='.$i.'">'.$i.'</a></li>';
					}	
				}
				//-----end loop----
			}
			$str_Nav .=  '</ul>';


			//--------nav page prev
			$linkCat = $cat;
			if($n > 1){
				if($n == 2){
					if($linkCat != '' || isset($_GET["categorie"]))$linkCat = '?'.$linkSearch.'categorie='.CheckPost($_GET["categorie"]);
					$page_prev = '<div class="page_prev d-flex flex-column align-items-center justify-content-center"><a href="Shop.php'.$linkCat.'"><i class="fas fa-chevron-left"></i></a></div>';
				}
				else{
					if($linkCat != '' && isset($_GET["categorie"]))$linkCat = $linkSearch.'categorie='.CheckPost($_GET["categorie"]).'&';
					$page_prev = '<div class="page_prev d-flex flex-column align-items-center justify-content-center"><a href="Shop.php?'.$linkCat.'page='.($n-1).'"><i class="fas fa-chevron-left"></i></a></div>';
				}
			}

			//--------nav page next
			$linkCat = $cat;
			if($n < $NbPage){
				if($linkCat != '' || isset($_GET["categorie"]))$linkCat = $linkSearch.'categorie='.CheckPost($_GET["categorie"]).'&';
				$page_next = '<div class="page_next d-flex flex-column align-items-center justify-content-center"><a href = "Shop.php?'.$linkCat.'page='.($n+1).'"><i class="fas fa-chevron-right"></i></a></div>';
			}
		}
		//-----------------------------------------------------------------------------------------------
	}
	echo $page_prev.$str_Nav.$page_next;
}




















//---------------------------------------------------------------------------------------------------------------------------------------------------------
$wich = '';
if(isset($_GET["Wishlist"])){
	$wich = CheckPost($_GET["Wishlist"]);
	$titleCat = "Wishlist";
}



function getItemsShopWich(){

	global $cn;
	global $cat;
	global $wich;
	global $countDS;

	$rank = 0;
	if(isset($_GET["page"])){
		$n = $_GET["page"];

		$rank = ($n-1) * 20;
	}


	$sql = 'select * from (select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate,@rownum := @rownum + 1 AS rank from Designation d 
	inner join categorie c on c.idC = d.idC ,(SELECT @rownum := 0) r ORDER BY d.idDS DESC) D where D.rank > '.$rank.' limit 20;';

	if($wich != ''){
		$ligneHeart = '';
		$existe = 0;

		foreach($_SESSION["ligneHeart"] as $key => $val){
			$ligneHeart .= '"'.$val.'"';
			if(end($_SESSION["ligneHeart"]) != $val){
				$ligneHeart .=',';
			}
			$existe ++;
		}
		if($existe == 0)$ligneHeart = '"vide"';


		$sql = 'select * from (select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate,@rownum := @rownum + 1 AS rank from Designation d 
		inner join categorie c on c.idC = d.idC ,(SELECT @rownum := 0) r where d.uuidDS in ('.$ligneHeart.') ORDER BY d.idDS DESC) D where D.rank > '.$rank.' limit 20;';
	}

	$run = mysqli_query($cn,$sql);
	while($raw=mysqli_fetch_array($run)){
		$new = '';
		if($raw[8] <= 5)
		{
			$new = 'is_new';
		}
		$activeHeart = '';
		if (($key = array_search( CheckPost($raw[1]) , $_SESSION["ligneHeart"])) !== false) {
			$activeHeart = 'active';
		}

		echo '<div class="product_item '.$new .'">
			<div class="product_border"></div>
			<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="'.$raw[3].'" alt=""></div>
			<div class="product_content">
				<div class="product_price">'.$raw[4].' DH</div>
				<div class="product_name"><div><a href="product.php?DS='.$raw[1].'" tabindex="0">'.$raw[2].'</a></div></div>
			</div>

			<div class="product_fav '.$activeHeart.'">
				<input type="hidden" class="heart" value="'.$raw[1].'"/>
				<i class="fas fa-heart"></i>
			</div>

			<ul class="product_marks">
				<li class="product_mark product_new">new</li>
			</ul>
		</div>';

	}

}

function NavItemsWich(){

	global $cn;
	global $wich;
	global $countDS;
	
	$NbPage = 0;
	$page_prev = '';
	$page_next = '';
	$str_Nav = '';
	$linkWich = $wich;

	$sql = 'select count(*)as countItems from (select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate,@rownum := @rownum + 1 AS rank from Designation d 
	inner join categorie c on c.idC = d.idC ,(SELECT @rownum := 0) r ORDER BY d.idDS DESC) D limit 20;';

	if($wich != ''){
		$ligneHeart = '';
		$existe = 0;

		foreach($_SESSION["ligneHeart"] as $key => $val){
			$ligneHeart .= '"'.$val.'"';
			if(end($_SESSION["ligneHeart"]) != $val){
				$ligneHeart .=',';
			}
			$existe ++;
		}
		if($existe == 0)$ligneHeart = '"vide"';

		$sql = 'select count(*)as countItems from (select d.idDS,d.uuidDS,d.DSname,d.image,d.price,d.Oldprice,d.stars,c.CTname,DATEDIFF(SYSDATE(),d.dateDS) as DifDate,@rownum := @rownum + 1 AS rank from Designation d 
		inner join categorie c on c.idC = d.idC ,(SELECT @rownum := 0) r where d.uuidDS in ('.$ligneHeart.') ORDER BY d.idDS DESC) D limit 20;';
	}


	$run = mysqli_query($cn,$sql);
	if($raw=mysqli_fetch_array($run)){
		//-----------------------------------------------------------------------------------------------
		$countDS = $raw[0];
		$NbPage = (int)(($raw[0]/20) + 1);

		if($NbPage > 1){

			$n = 1;
			if(isset($_GET["page"])){$n = $_GET["page"];}

			//--------nav ul page list
			$str_Nav .= '<ul class="page_nav d-flex flex-row">';
			for($i = 1 ; $i <= $NbPage ; $i++){
				//-----star loop----
				$linkWich = $wich;

				if($i == $n){
					$str_Nav .=  '<li class = "active">'.$i.'</li>';
				}
				else {
					if($i == 1){

						if($linkWich =! '')$linkWich = "?Wishlist=show";
						$str_Nav .=  '<li><a href="Shop.php'.$linkWich.'">'.$i.'</a></li>';
					}
					else {
						if($linkWich =! '')$linkWich = "Wishlist=show&";
						$str_Nav .=  '<li><a href="Shop.php?'.$linkWich.'page='.$i.'">'.$i.'</a></li>';
					}	
				}
				//-----end loop----
			}
			$str_Nav .=  '</ul>';


			//--------nav page prev
			$linkWich = $wich;
			if($n > 1){
				if($n == 2){
					if($linkWich =! '')$linkWich = "?Wishlist=show";
					$page_prev = '<div class="page_prev d-flex flex-column align-items-center justify-content-center"><a href="Shop.php'.$linkWich.'"><i class="fas fa-chevron-left"></i></a></div>';
				}
				else{
					if($linkWich =! '')$linkWich = "?Wishlist=show&";

					$page_prev = '<div class="page_prev d-flex flex-column align-items-center justify-content-center"><a href="Shop.php?'.$linkWich.'page='.($n-1).'"><i class="fas fa-chevron-left"></i></a></div>';
				}
			}

			//--------nav page next
			$linkWich = $wich;
			if($n < $NbPage){
				if($linkWich =! '')$linkWich = "Wishlist=show&";
				$page_next = '<div class="page_next d-flex flex-column align-items-center justify-content-center"><a href = "Shop.php?'.$linkWich.'page='.($n+1).'"><i class="fas fa-chevron-right"></i></a></div>';
			}
		}
		//-----------------------------------------------------------------------------------------------
	}
	echo $page_prev.$str_Nav.$page_next;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------
















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
<title>Shop</title>
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
<link rel="stylesheet" type="text/css" href="plugins/jquery-ui-1.12.1.custom/jquery-ui.css">

<link rel="stylesheet" type="text/css" href="styles/Style_header.css">
<link rel="stylesheet" type="text/css" href="styles/shop_styles.css">
<link rel="stylesheet" type="text/css" href="styles/shop_responsive.css">
<link rel="stylesheet" type="text/css" href="styles/Style_footer.css">

</head>

<body>

<div class="super_container">
	
	<!---Star Header--->
	<?php include('Header.php'); ?>
    <!---end Header--->
	
	<!-- Home -->

	<div class="home">

		<div class="home_content d-flex flex-column align-items-center justify-content-center">
			<h2 class="home_title"><?php echo $titleCat;?></h2>
		</div>
	</div>

	<!-- Shop -->

	<div class="shop">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">

					<!-- Shop Sidebar -->
					<div class="shop_sidebar">
						<div class="sidebar_section">
							<div class="sidebar_title">Categories</div>
							<ul class="sidebar_categories">

								<?php

								$sql = 'select c1.idC,c1.CTname from categorie c1 where idFC is null and c1.CTname <> "Sliders"';
								$run = mysqli_query($cn,$sql);
								while($raw=mysqli_fetch_array($run)){
									echo '<li><a href="shop.php?categorie='.$raw[1].'">'.$raw[1].'</a></li>';
								}


								?>
											
							</ul>
						</div>
						<div class="sidebar_section filter_by_section">
							<div class="sidebar_title">Filter By</div>
							<div class="sidebar_subtitle">Price</div>
							<div class="filter_price">
								<div id="slider-range" class="slider_range"></div>
								<p>Range: </p>
								<p><input type="text" id="amount" class="amount" readonly style="border:0; font-weight:bold;"></p>
							</div>
						</div>
						<!--
						<div class="sidebar_section">
							<div class="sidebar_subtitle brands_subtitle">Brands</div>
							<ul class="brands_list">
								<li class="brand"><a href="#">Apple</a></li>
								<li class="brand"><a href="#">Beoplay</a></li>
								<li class="brand"><a href="#">Google</a></li>
								<li class="brand"><a href="#">Meizu</a></li>
								<li class="brand"><a href="#">OnePlus</a></li>
								<li class="brand"><a href="#">Samsung</a></li>
								<li class="brand"><a href="#">Sony</a></li>
								<li class="brand"><a href="#">Xiaomi</a></li>
							</ul>
						</div>
						-->
					</div>

				</div>

				<div class="col-lg-9">
					
					<!-- Shop Content -->

					<div class="shop_content">
						<div class="shop_bar clearfix">
							<div class="shop_product_count"><span id="countDS">0</span> products found</div>
							<div class="shop_sorting">
								<span>Sort by:</span>
								<ul>
									<li>
										<span class="sorting_text">highest rated<i class="fas fa-chevron-down"></span></i>
										<ul>
											<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "original-order" }'>highest rated</li>
											<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "name" }'>name</li>
											<li class="shop_sorting_button"data-isotope-option='{ "sortBy": "price" }'>price</li>
										</ul>
									</li>
								</ul>
							</div>
						</div>

						<div class="product_grid">
							<div class="product_grid_border"></div>

							<!-- Product Item -->
							<?php

							if(isset($_GET["Wishlist"])){
								getItemsShopWich();
							}
							else{
								getItemsShopCat();
							}
							
							
							
							
							?>

						</div>

						<!-- Shop Page Navigation -->

						<div class="shop_page_nav d-flex flex-row">
							<?php
							if(isset($_GET["Wishlist"])){
								NavItemsWich();
							}
							else{
								NavItemsCat();
							}
							
							
							?>
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
<script src="plugins/easing/easing.js"></script>
<script src="plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="plugins/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>

<script src="js/scriptAll.js"></script>
<script src="js/shop_custom.js"></script>

<script>document.getElementById("countDS").textContent = "<?php echo $countDS;?>";</script>

<?php echo $styleViewed;?>

</body>

</html>