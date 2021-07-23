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
  header("location: index.php");
}else if(count($_SESSION["ligneCommande"]) == 0){
  header("location: index.php");
}



$infoSend = "";


if(isset($_POST["send"])){


  if(isset($_POST["name"]) && isset($_POST["phone"]) && isset($_POST["address"])){

    $envoi = false;
    $infoSend = "";
    
  
    $name = CheckPost($_POST["name"]);
    $phone = CheckPost($_POST["phone"]);
    $address = CheckPost($_POST["address"]);
    $email = '';$city = '';$country = '';$notes = '';


    
  
    if(isset($_POST["email"]) && CheckPost($_POST["email"]) != ""){
      $email = "- Email : ".CheckPost($_POST["email"]);
    }
  
    if(isset($_POST["city"]) && CheckPost($_POST["city"]) != ""){
      $city = "- City : ".CheckPost($_POST["city"]);
    }
  
    if(isset($_POST["country"]) && CheckPost($_POST["country"]) != ""){
      $country = "- Country : ".CheckPost($_POST["country"]);
    }
  
    if(isset($_POST["email"]) && CheckPost($_POST["notes"]) != ""){
      $notes = "- Notes : ".CheckPost($_POST["notes"]);
      $envoi = true;
    }
  
  $message = "- Nom Complet : $name
- Tel : $phone
- Address : $address
$email
$city
$country
$notes";
    
    $test = true;
    if($name == ""){
      $infoSend .= '<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Danger!</strong> Invalid Name.
      </div>';
      $test = false;
      
    }
    if($phone == ""){
      $infoSend .= '<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Danger!</strong> Invalid Namber Phone.
      </div>';
      $test = false;
    }
    if($address == ""){
      $infoSend .= '<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Danger!</strong> Invalid Address.
      </div>';
      $test = false;
    }

    if($test == true){

      $sql= "insert into commandes(dateCom,clientMessage) values('".date("Y-m-d")."','$message');";
      $req = mysqli_query($cn,$sql);
      
      $idCmClient =0;
      $sql="select idCM from commandes where clientMessage  = '$message' order by idCM desc limit 1";
      $req = mysqli_query($cn,$sql);
      
      if($raw=mysqli_fetch_array($req)) {
        $idCm=$raw[0];
        
        foreach($_SESSION["ligneCommande"] as $val)
        { 
          $sql = 'select d.DSname,c.CTname,d.Descript from Designation d 
          inner join categorie c on c.idC = d.idC where d.idDS = '.$val ->Designation.';';
          $req = mysqli_query($cn,$sql);

          if($raw=mysqli_fetch_array($req)){
            $sql_line="insert into ligneCommande(idCM,DSname,CTname,qte) values(".$idCm.",'".$raw[0]."','".$raw[1]."',".$val ->quantite.");";
            $req = mysqli_query($cn,$sql_line);
          }

        }
      }

      $_SESSION["ligneCommande"]=array();

      $infoSend .= '<div class="alert alert-success alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success!</strong> sent succesfully.
        </div>';

    }
    
    $message.="Message from PlanetShop
".$message;
  
    if($envoi == true){
      $subject="PlanetShop contact";
      $destinataire="Planetshop2020@gmail.com";
      $headers = "From:" . $email;
  
      if(mail($destinataire,$subject,$message,$headers))
      {
        
      }
      else{

        $infoSend .= '
        <div class="alert alert-info">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Info!</strong> The request has been sent, but your email is wrong. It was not sent.
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
<link rel="stylesheet" type="text/css" href="styles/checkout_custom.css">
<link rel="stylesheet" type="text/css" href="styles/responsive.css">
<link rel="stylesheet" type="text/css" href="styles/Style_footer.css">

</head>

<body>
<div class="super_container">
	
	<!---Star Header--->
	<?php include('Header.php'); ?>
    <!---end Header--->

	<!-- Cart -->


<div class="container checkout">

  <?php echo $infoSend; ?>

      <div class="row"> 
        <div class="col-md-7 order-md-1 mx-auto mt-5 mb-5">
          <form action="checkout.php" method="post">
            <div class="row">

                <div class="col-12">
                    <h2 class="checkout-title">Billing Details</h2>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Type your name" pattern="[A-Za-z0-9 ]{3,32}" required="Invalid First name">
                        </div>

                        <div class="col-sm-6">
                          <label>Email address (optional)</label>
                          <input type="email" name="email" class="form-control" placeholder="Type your email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"> 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>Phone</label>
                            <input type="tel" name="phone" class="form-control" placeholder="Type your phone" pattern="(05|06|07)[0-9]{8}" required="Invalid Phone">
                        </div>
                    </div>

                    <div>
                      <label>Address</label>
                      <input type="text" name="address" class="form-control" placeholder="Type your address" required="Invalid Addres">
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <label>Country (optional)</label>
                        <input type="text" name="country" class="form-control">
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>Town / City (optional)</label>
                            <input type="text" name="city" class="form-control">
                        </div>
                    </div>
                    
                    
                    <div>
                      <label>Order notes (optional)</label>
                      <textarea class="form-control" name="notes" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                    </div>

                    
                </div>
                

            </div>

            <hr class="mb-4 mt-5">
            <button class="btn btn-primary btn-lg btn-block mb-5" name="send" type="submit">Send Command</button>
          </form>

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
<script src="js/checkout_custom.js"></script>
</body>

</html>
