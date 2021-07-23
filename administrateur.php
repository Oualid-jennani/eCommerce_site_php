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


if(isset($_SESSION['IDAdmin']) && isset($_SESSION['Admin'])){
    header("location: Admin.php");
}


if(isset($_POST['signIn'])){

	$AdminName=CheckPost($_POST['AdminName']);
	$psw=CheckPost($_POST['psw']);

	$sql = "select * from `admin` where `Adname` = '$AdminName' and `Adpass`='$psw'";
	$run = mysqli_query($cn,$sql);
	
	if($rows=mysqli_fetch_array($run)){

		$_SESSION['IDAdmin']=$rows[0];
		$_SESSION['Admin']=$rows[1];
		header("location: Admin.php");
	}
}

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="welcom to my web site">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="images/icons/logo.png"/>
        <title>Admin Planetshop</title>
        <link rel="stylesheet" type="text/css" href="styles/LoginAdminStile.css">
    </head>
    <body>
        

        <div class="mainLogin">

            <div class="login">

                <div class="login-panel">
                    <div class='title'>
                        <label class='LBlogin' >Panel Control</label>
                    </div>
                    <form method="post" autocomplete="off">
                        <div class="con-in">
                            <input type="text" placeholder="Nom" name="AdminName" class="AdminName" required>
                        </div>

                        <div class="con-in">
                            <input type="password" placeholder="Mot de passe" name="psw" id="psw" class="psw"required>
                        </div>
                        <div class="con-in">
                            <label class="check">Afficher le mot de passe
                                <input type="checkbox"  id="checkPsw">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div>  
                            <input type="submit" value="se connecter" name="signIn">
                        </div>
                    </form>
                </div>
            </div> 

        </div>
       
    </body>


<script src="js/scriptAdminIndex.js"></script>

</html>