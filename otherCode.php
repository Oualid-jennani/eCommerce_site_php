<?php



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
	foreach($_SESSION["ligneViewed"] as $key => $val){
		$ligneViewed .= '"'.$val.'"';

		if(end($_SESSION["ligneViewed"]) != $val){
			$ligneViewed .=',';
		}
	}

	$sql = "select idDS,uuidDS,DSname,image,price,Oldprice,DATEDIFF(SYSDATE(),dateDS) as DifDate from Designation 
	where slider1 = false and slider2 = false and uuidDS in ($ligneViewed);";

	if(isset($_GET["DS"])){
		$sql = "select idDS,uuidDS,DSname,image,price,Oldprice,DATEDIFF(SYSDATE(),dateDS) as DifDate from Designation 
		where slider1 = false and slider2 = false and uuidDS in ($ligneViewed) and uuidDS <> '".CheckPost($_GET["DS"])."'";
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