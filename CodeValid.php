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




//---------edit Panier -------------------------
if(isset($_POST["deletkey"])){

    unset($_SESSION["ligneCommande"][$_POST["deletkey"]]);

}

else if(isset($_POST["editKey"]) && isset($_POST["valueqt"])){

    $Qt = 1;
	$Qt = CheckPost($_POST['valueqt']);
    if($Qt > 0 && $Qt <= 10 ){
        $_SESSION["ligneCommande"][$_POST["editKey"]]->quantite = $Qt ;
    }
    
}

else if(isset($_POST["countP"])){
    echo count($_SESSION["ligneCommande"]);
}
else if(isset($_POST["ShowPanier"])){

    $Listpanier = '';
    $count = 0;

    
    foreach($_SESSION["ligneCommande"] as $key => $val)
    {
        $sql = 'select idDS,uuidDS,DSname,image,price from Designation where  idDS = '.$val ->Designation.'';
        $req = mysqli_query($cn,$sql);
        if ($raw=mysqli_fetch_array($req)) {
            $Listpanier .= '<li>
                <img src="'.$raw[3].'">
                <div>
                    <label class="nameitems">'.$raw[2].'</label>
                    <label class="price">'.$raw[4].' dh</label>
                </div>
                <div>
                    <div class="action">
                        <input type="number" class="Pquantite" value="'.$val ->quantite.'" onchange="editqtP('.$key.',event)" min="0" max="10">
                        <input type="button" onclick="delpanier('.$key.')" class="deleteP" value="">
                    </div>
                    <label class="subotal"><span class="ST">'.($val ->quantite*$raw[4]).'</span> dh</label>
                </div>
            </li>';

            $count ++;
        }

    }

    if($count > 0){
        $Listpanier = '<ul id="listPanier">'.$Listpanier.'</ul>';
        $Listpanier .='<div class="checkoutP">
            <div>
                <button><a href="checkout.php">CHECKOUT</a></button>
            </div>
            <div>
                <button onclick="changeListP()">UPDATE CART <i class="fas fa-sync-alt"></i></button>
            </div>
        </div>';
    }
    else{
        $Listpanier = '<h5 id="videP">Vide !</h5>';
    }
    
    echo $Listpanier;
    
}



//---------edit Panier -------------------------



//-------------------------------------------------------- code Admin--------------------------------------------------------------------------

//------------------------Modifier----------------------------------

if(isset($_POST["ChangeSlider1"]) && isset($_POST["idDS"]) && isset($_POST["Val"])){ 
    if(CheckPost($_POST["idDS"]) != "")
    {
        $sql = 'update Designation set slider2 = '.CheckPost($_POST["Val"]).' where idDS = '.CheckPost($_POST["idDS"]).';';
        mysqli_query($cn,$sql);
    }
}


if(isset($_POST["ChangeSlider2"]) && isset($_POST["idDS"])){
    
    if(CheckPost($_POST["idDS"]) != "")
    {
        $sql = 'update Designation set slider1 = false where idDS <> -1;';
        mysqli_query($cn,$sql);

        $sql = 'update Designation set slider1 = true where idDS = '.CheckPost($_POST["idDS"]).';';
        mysqli_query($cn,$sql);
    }

}



//--------------------remplir les tables et select-------------------------

if(isset($_POST["AfficherCT"]) ){

    $sql = "select idC,CTname,activation from categorie c where idFC is null";
  
    $run = mysqli_query($cn,$sql);
    while($raw=mysqli_fetch_array($run)){

    $action = "<input type='button' class='btnEdit' onclick='EditCT(".$raw[0].")' title='Modifier'/>
    <input type='button' class='btnDelete' onclick='DeleteCT(".$raw[0].")' title='Suprimer'/>";

    if($raw[2] == true) $action = "<div class = 'action-vide'>...</div>";

    echo "<tr>
    <td>".$raw[1]."</td>
        <td>
            $action
        </td>
    </tr>";
    }
}

else if(isset($_POST["remplireSelCT"])){
    $sql = "select idC,CTname from categorie c where idFC is null";
  
    $run = mysqli_query($cn,$sql);
    while($raw=mysqli_fetch_array($run)){
      echo "<option value='".$raw[0]."'>".$raw[1]."</option>";
    }
}
else if(isset($_POST["AfficherFCT"]) && isset($_POST["whereVal"])){
    $sql = "select idC,CTname from categorie where idFC = ".CheckPost($_POST["whereVal"])."";
  
    $run = mysqli_query($cn,$sql);
    while($raw=mysqli_fetch_array($run)){
        echo "<tr><td>".$raw[1]."</td><td><input type='button' class='btnEdit' onclick='EditFCT(".$raw[0].")' title='Modifier'/><input type='button' class='btnDelete' onclick='DeleteFCT(".$raw[0].")' title='Suprimer'/></td></tr>";
    }
}


else if(isset($_POST["remplireSelFCT"]) && isset($_POST["whereVal"])){
    $sql = "select idC,CTname from categorie where idFC = ".CheckPost($_POST["whereVal"])."";

    $test = 0;

    $run = mysqli_query($cn,$sql);
    while($raw=mysqli_fetch_array($run)){
        echo "<option value='".$raw[0]."'>".$raw[1]."</option>";
        $test ++;
    }

    if($test == 0){
        echo "<option value='".CheckPost($_POST["whereVal"])."'></option>";
    }
    
}

else if(isset($_POST["AfficherDS"]) && isset($_POST["whereVal"])){


    $sql = "select d.idDS,d.DSname,d.Descript,d.price,d.Oldprice,d.stars,d.slider1,d.slider2,c.CTname,d.vues from Designation d 
    inner join categorie c on d.idC = c.idC where c.idC = ".CheckPost($_POST["whereVal"])."";
  
    $run = mysqli_query($cn,$sql);
    while($raw=mysqli_fetch_array($run)){

        $sliders = '';

        if($raw[8] == "Sliders"){
            $checked1 = "checked";
            if($raw[6] == false){$checked1 = "";};
    
            $slider2 = "false";$checked2 = "checked";
            if($raw[7] == false){$slider2 = "true";$checked2 = "";};

            $sliders = "<input type='checkbox' class='checkDS' value='$slider2' onclick='funSlider1(event,".$raw[0].")' $checked2>
            <input type='radio' class='radioDS' name='optradio' value='' onclick='funSlider2(".$raw[0].")' $checked1>";
        }
        

        echo "<tr>
        <td>".$raw[1]."</td>
        <td class='txtDesc'><textarea disabled>".$raw[2]."</textarea></td>
        <td>".$raw[3]."</td>
        <td>".$raw[4]."</td>
        <td>".$raw[5]."</td>
        <td>".$raw[9]."</td>

        <td>
            <div class='div-action'>$sliders
            <input type='button' class='btnEdit' onclick='EditDS(".$raw[0].")' title='Modifier'/>
            <input type='button' class='btnDelete' onclick='DeleteDS(".$raw[0].")' title='Suprimer'/>
            </div>
        </td>

        </tr>";
    }
}

else if(isset($_POST["AfficherAD"]) ){

    $sql = "select idAD,ADname,Adpass from admin";
  
    $run = mysqli_query($cn,$sql);
    while($raw=mysqli_fetch_array($run)){
      echo "<tr>
      <td>".$raw[1]."</td>
      <td>".$raw[2]."</td>
      <td><input type='button' class='btnEdit' onclick='EditAD(".$raw[0].")' title='Modifier'/><input type='button' class='btnDelete' onclick='DeleteAD(".$raw[0].")' title='Suprimer'/></td>
      </tr>";
    }
}

//------------------------Modifier----------------------------------
else if(isset($_POST["MdtCategorie"]) && isset($_POST["MdNomC"]) && isset($_POST["idC"]) ){
    

    if(CheckPost($_POST["MdNomC"]) != "" && CheckPost($_POST["idC"]) != "")
    {
        $sql = 'update categorie set CTname = "'.CheckPost($_POST["MdNomC"]).'" where idC = '.CheckPost($_POST["idC"]).'';
        $run = mysqli_query($cn,$sql);
    }
    else echo "Les informations sont incomplètes ou erronées";


}

else if(isset($_POST["MdtFCategorie"]) && isset($_POST["MdNomFC"]) && isset($_POST["MdCategorieFC"]) && isset($_POST["idC"]) ){
    

    if(CheckPost($_POST["MdNomFC"]) != "" && CheckPost($_POST["MdCategorieFC"]) != "")
    {
        $sql = 'update categorie set CTname = "'.CheckPost($_POST["MdNomFC"]).'",idFC = '.CheckPost($_POST["MdCategorieFC"]).' where idC = '.CheckPost($_POST["idC"]).'';
        $run = mysqli_query($cn,$sql);
    }
    else echo "Les informations sont incomplètes ou erronées";

}



else if(isset($_POST["MdtDesignation"]) && isset($_POST["changeImg"]) && isset($_POST["MdCategorieDS"]) && isset($_POST["MdFCategorieDS"]) && isset($_POST["MdNomDS"]) && isset($_POST["MdPrixDS"]) && isset($_POST["MdEPrixDS"]) && isset($_POST["MdStarsDS"]) && isset($_POST["MdDescriptionDS"])  && isset($_POST["idDS"]) ){
    
    if(CheckPost($_POST['changeImg']) != "" && CheckPost($_POST['MdFCategorieDS']) != "" && CheckPost($_POST['MdNomDS']) != "" && CheckPost($_POST['MdPrixDS']) != "" && CheckPost($_POST['MdEPrixDS']) != "" && CheckPost($_POST['MdStarsDS']) != "" && CheckPost($_POST['MdDescriptionDS']) != "" && CheckPost($_POST['idDS']) != ""){
        $oldUrl = "";
        $sql = "select image from Designation where idDS = ".CheckPost($_POST['idDS'])." ";
        $run = mysqli_query($cn,$sql);
        if($raw=mysqli_fetch_array($run)){$oldUrl = $raw[0];}
        
        $changeImg = CheckPost($_POST['changeImg']);

        $url = $oldUrl;
        $sqlImage = "";

        if($changeImg == "changed"){

            $myfile = $_FILES['image-0'];

            if($myfile['tmp_name'] != ""){
                $url = "images/Images_Designation/".date('d-M-Y-h-i-s')."-".$myfile['name'];
                $sqlImage = 'image = "'.$url.'",';
                copy($myfile['tmp_name'], $url);
            }
        }


        

        $sql = 'update Designation set DSname= "'.CheckPost($_POST['MdNomDS']).'",'.$sqlImage.'
        Descript = "'.CheckPost($_POST['MdDescriptionDS']).'",
        price = '.CheckPost($_POST['MdPrixDS']).',
        Oldprice = '.CheckPost($_POST['MdEPrixDS']).',
        idC = '.CheckPost($_POST['MdFCategorieDS']).',
        stars = '.CheckPost($_POST['MdStarsDS']).'
        where idDS = '.CheckPost($_POST["idDS"]).';';




        if(mysqli_query($cn,$sql))
        {
            if (file_exists($oldUrl) && $oldUrl != $url )
            {
                unlink($oldUrl);
            }
        }
    }
    else echo "Les informations sont incomplètes ou erronées";
    

}



else if(isset($_POST["MdtAdmin"]) && isset($_POST["idAD"]) && isset($_POST["MdNomAD"]) && isset($_POST["MdPassAD"]) ){

    if(CheckPost($_POST["MdNomAD"]) != "" && CheckPost($_POST["MdPassAD"]) != "")
    {
        $sql = 'update admin set ADname = "'.CheckPost($_POST["MdNomAD"]).'" , Adpass = "'.CheckPost($_POST["MdPassAD"]).'" where idAd = '.CheckPost($_POST["idAD"]).'';
        $run = mysqli_query($cn,$sql);
    }
    else echo "Les informations sont incomplètes ou erronées";
}



else if(isset($_POST["getImage"]) && isset($_POST["idDS"])){

    $sql = "select image from Designation where idDS = ".CheckPost($_POST['idDS'])." ";
  
    $run = mysqli_query($cn,$sql);
    if($raw=mysqli_fetch_array($run)){
        echo $raw[0];
    }
}

//------------------------Modifier----------------------------------
 

//------------------------supprimer---------------------------------
else if(isset($_POST["table"]) && isset($_POST["nomColumn"]) && isset($_POST["whereIdDelete"])){

    if(CheckPost($_POST["nomColumn"]) == "idDS"){

        $oldUrl = "";

        $sql = "select image from Designation where idDS = ".CheckPost($_POST['whereIdDelete'])." ";
        $run = mysqli_query($cn,$sql);
        if($raw=mysqli_fetch_array($run)){$oldUrl = $raw[0];}
        
        if($oldUrl != "images/Images_Designation/dist_test.png"){

            if (file_exists($oldUrl))
            {
                unlink($oldUrl);
            }
            
        }
    }



    $sql= "delete from ".CheckPost($_POST["table"])." where `".CheckPost($_POST["nomColumn"])."` = ".CheckPost($_POST["whereIdDelete"])."";

    $req = mysqli_query($cn,$sql);


}
//------------------------Ajouter----------------------------------
else if(isset($_POST["AjtCategorie"]) && isset($_POST["AjNomC"])){

    if(CheckPost($_POST["AjNomC"]) != ""){
        $sql = 'insert into categorie(uuidCT,CTname) values (UUID(),"'.CheckPost($_POST["AjNomC"]).'")';
        $run = mysqli_query($cn,$sql);
    }

    
}
else if(isset($_POST["AjtFCategorie"]) && isset($_POST["AjNomFC"]) && isset($_POST["AjCategorieFC"])){

    if(CheckPost($_POST["AjNomFC"]) != "" && CheckPost($_POST["AjCategorieFC"]) != ""){
        $sql = 'insert into categorie(uuidCT,CTname,idFC) values (UUID(),"'.CheckPost($_POST["AjNomFC"]).'",'.CheckPost($_POST["AjCategorieFC"]).')';
        mysqli_query($cn,$sql);
    }

    
}

else if(isset($_POST["AjtDesignation"]) && isset($_POST["AjCategorieDS"]) && isset($_POST["AjNomDS"]) && isset($_POST["AjPrixDS"]) && isset($_POST["AjEPrixDS"]) && isset($_POST["AjStarsDS"]) && isset($_POST["AjDescriptionDS"])){
    
    if(CheckPost($_POST['AjCategorieDS']) != "" && CheckPost($_POST['AjNomDS']) != "" && CheckPost($_POST['AjPrixDS']) != "" && CheckPost($_POST['AjEPrixDS']) != "" && CheckPost($_POST['AjStarsDS']) != "" && CheckPost($_POST['AjDescriptionDS']) != "")
    {
        $myfile = $_FILES['image-0'];
        $url = "";
    
        if($myfile['tmp_name'] == ""){
            $url = "images/Images_Designation/dist_test.png";
        }
        else{
            $url = "images/Images_Designation/".date('d-M-Y-h-i-s')."-".$myfile['name'];
        }
        
        $sql = 'insert into Designation(uuidDS,DSname,image,Descript,price,Oldprice,stars,idC) values 
        (UUID(),"'.CheckPost($_POST['AjNomDS']).'","'.$url.'","'.CheckPost($_POST['AjDescriptionDS']).'",'.CheckPost($_POST['AjPrixDS']).','.CheckPost($_POST['AjEPrixDS']).','.CheckPost($_POST['AjStarsDS']).','.CheckPost($_POST['AjCategorieDS']).');';

        if(mysqli_query($cn,$sql)){
            if($myfile['tmp_name'] != ""){
                copy($myfile['tmp_name'], $url);
            }
        }
        
    }
    
}

else if(isset($_POST["AjtAdmin"])){

    if(CheckPost($_POST["AjNomAD"]) != "" && CheckPost($_POST["AjPassAD"]) != ""){
        $sql = 'insert into admin(Adname,Adpass) values ("'.CheckPost($_POST["AjNomAD"]).'","'.CheckPost($_POST["AjPassAD"]).'")';
        mysqli_query($cn,$sql);
    }
}


//-----------------------------------------------

else if(isset($_POST["AddHeart"]) && isset($_POST["val"])){

    if (!in_array(CheckPost($_POST["val"]), $_SESSION["ligneHeart"])) {
        array_push($_SESSION["ligneHeart"], CheckPost($_POST["val"]));
    }

    

    //$_SESSION["ligneCommande"][] = CheckPost($_POST["val"])
}


else if(isset($_POST["DeleteHeart"]) && isset($_POST["val"])){
    if (in_array(CheckPost($_POST["val"]), $_SESSION["ligneHeart"])) {

        $key = array_search(CheckPost($_POST["val"]) , $_SESSION["ligneHeart"]);
        unset($_SESSION["ligneHeart"][$key]);
    }
}

/*
else if(isset($_POST["DeleteHeart"]) && isset($_POST["val"])){
    if (($key = array_search( CheckPost($_POST["val"]) , $_SESSION["ligneHeart"])) !== false) {
        unset($_SESSION["ligneHeart"][$key]);
    }
}
*/


//-----------------------------------------------

else if(isset($_POST["countHeart"])){
    echo count($_SESSION["ligneHeart"]);
}

else if(isset($_POST["posteConfirm"]) && isset($_POST["postenumCommande"])){
    $sql= "update `commandes` set confirmation = ".CheckPost($_POST["posteConfirm"])." where idCM =".CheckPost($_POST["postenumCommande"])."";
    $req = mysqli_query($cn,$sql);
}