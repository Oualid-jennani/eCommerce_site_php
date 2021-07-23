<?php

require "db.php";
session_start();


//deconexion
if(isset($_POST['dec'])){

    unset($_SESSION["IDAdmin"]);
	unset($_SESSION["Admin"]);

    header("location: administrateur.php");
}
else if($_SESSION['IDAdmin'] == null || $_SESSION['Admin'] == null ){
    header("location: administrateur.php");
}





















function CommandeClient($Statut){


    global $cn;

    $sql = "select distinct cm.idCM,cm.clientMessage,cm.dateCom,cm.confirmation from commandes cm
    inner join ligneCommande lnc on lnc.idCM = cm.idCM
    where cm.confirmation = $Statut order by cm.idCM desc";
  
    $run = mysqli_query($cn,$sql);

    while($raw=mysqli_fetch_array($run)){

        $disabledConfermation = "";$hidden = "";
        $btnConfermation = "class='firstConfermation'";
        if(!$raw[3]){$disabledConfermation = "disabled";}
        else if($raw[3]){$btnConfermation = "class='newConfermation'";}


        $InfoCommande = "";
        
        $sqlLigneCm = "select lnc.DSname,lnc.CTname,lnc.qte from ligneCommande lnc
        inner join commandes cm on lnc.idCM = cm.idCM and cm.idCM = ".$raw[0]."";

        $runLigne = mysqli_query($GLOBALS["cn"],$sqlLigneCm);

        while($rawLigneCm=mysqli_fetch_array($runLigne)){

            $InfoCommande .= "<tr><td>".$rawLigneCm[0]."</td><td>".$rawLigneCm[1]."</td><td>".$rawLigneCm[2]."</td></tr>";
            $NameMG = $rawLigneCm[0];

        }
        //--------------------------------------------------------------------------------------------------------------------
    
        $buttonConfirmation = "";

        if(!$Statut){
            $buttonConfirmation = "<td class='conferm'>
                <input type='button' $btnConfermation value='Confirmé' onclick='funConfermation(".$raw[0].");'>
            </td>";
        }
    

        $infoClient =str_replace('- ', '<br>', $raw[1]);

        echo "<tr><td>".$raw[0]."</td><td class='infoClient'>".$infoClient."</td><td class='columndetai'><label>Voir Detai ....</label><table><tr><th>Désignation</th><th>Catégorie</th><th>Quantité Demandé</th></tr>".$InfoCommande."</table></td><td>".$raw[2]."</td>
        ".$buttonConfirmation."</tr>";
    }
  }




















?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin PlanetShop</title>
        <link rel="icon" type="image/png" href="images/icons/logo.png"/>
        
        <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="styles/AdminStyle.css">
        

        <link rel="stylesheet" href="styles/jquery-ui.min.css">





    </head>
    <body>

        <div class="header">
            <div class = "container">
                <div class="infoHeader">
                    <div class="infoApp">

                        <ul>
                            <li><span class="iconApp"></span></li>
                            <li><span class="nameApp">Admin PlanetShop</span></li>
                        </ul>

                    </div>

                    <div class="infoProfil">

                        <ul>
                            <li>
                                <form method="post">
                                    <input type="submit" class="dec" name="dec" value="">
                                </form>
                            </li>

                            <li><span class="name">Admin : <?php echo $_SESSION['Admin'] ; ?></span></li>


                        </ul>

                    </div>
                </div>
            </div>
 
        </div>
            
        

        <!------------------------------------------------------------------------------------------------------------>

        <div class="main">

            <div class="top-menu">
                <div class="tab1 container">
                    <button class="tablinks1 active" onclick="openTab1(event, 'tab1_1')">Controle Des Demmandes</button>
                    <button class="tablinks1" onclick="openTab1(event, 'tab1_2')">Super Gestion</button>
                </div>
            </div>
            


            <div class="container tabcontent1" id="tab1_1">

                <div class="tab2">
                    <button class="tablinks2 active" onclick="openTab2(event, 'tab1_1_1')">Liste de Demandes</button>
                    <button class="tablinks2" onclick="openTab2(event, 'tab1_1_2')">Historique</button>
                </div>

                <div class="tabcontent2" id="tab1_1_1">
        
                    <div class="searsh">
                        <input class="txtsearshCom" id="txtsearshCom1" type="text" placeholder="Search...">
                    </div>
                        
                    <table class="tableCommande">

                        <thead>
                            <tr>
                            <th>N° commande</th><th>Client</th><th>Les détail<button class="detai" id="detai">↯</button></th><th>Date Commande</th><th>Confirmation</th>
                            </tr>
                        </thead>


                        <?php CommandeClient(0); ?>
                
                    </table>

                </div>



                <div class="tabcontent2" id="tab1_1_2">

                <div class="searsh">
                        <input class="txtsearshCom" id="txtsearshCom2" type="text" placeholder="Search...">
                    </div>
                        
                    <table class="tableCommande">

                        <thead>
                            <tr>
                            <th>N° commande</th><th>Client</th><th>Les détail<button class="detai" id="detai">↯</button></th><th>Date Commande</th>
                            </tr>
                        </thead>


                        <?php CommandeClient(1); ?>
                
                    </table>

                </div>

            </div>

            <div class="container tabcontent1" id="tab1_2">
            <div class="menu tab3">
                <ul>
                <li class="tablinks3 active" onclick="openTab3(event, 'tab1_2_1')"> Contrôle Des Categories</li>
                <li class="tablinks3" onclick="openTab3(event, 'tab1_2_2')"> Contrôle Des Familles Categories</li>
                <li class="tablinks3" onclick="openTab3(event, 'tab1_2_3')"> Contrôle Des Designations</li>
                <li class="tablinks3" onclick="openTab3(event, 'tab1_2_4')"> Contrôle Des Admin</li>
                </ul>
            </div>

            <div class="contain">

                <!--------------------------------------------------------------------------------------------->
                <div class="tabcontent3" id="tab1_2_1"> 

                    <div class="Action"><input class="txtsearsh" id="CTsearsh" type="text" placeholder="Search..."><input type='button' id='AjouterCategorie' value='Ajouter Categorie' /></div>
                    
                    <div class='divTable'>
                        <table id='tabCategorie' class='tableAdmin'>
                            <thead>
                                <tr>
                                    <th>Nom Categorie</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody id='rawCategorie'></tbody>
                        
                        </table>
                    </div>
                </div>
                <!--------------------------------------------------------------------------------------------->
                <div class="tabcontent3" id="tab1_2_2"> 

                    <div class='divSel'>
                        <select id='selCategorie1' class='selAdmin'></select>
                    </div>

                    <div class="Action"><input class="txtsearsh" id="FCTsearsh" type="text" placeholder="Search..."><input type='button' id='AjouterFCategorie' value='Ajouter Famile Categorie' /></div>
                    
                    <div class='divTable'>
                        <table id='tabFCategorie' class='tableAdmin'>
                            <thead>
                                <tr>
                                    <th>Nom Famile Categorie</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody id='rawFamileCategorie'></tbody>
                        
                        </table>
                    </div>
                </div>  
                <!--------------------------------------------------------------------------------------------->
                <div class="tabcontent3" id="tab1_2_3">
                
                <div class='divSel'>
                        <select id='selCategorie2' class='selAdmin'></select>
                        <select id='selFCategorie' class='selAdmin'></select>
                </div>
                
                <div class="Action"><input class="txtsearsh" id="DSsearsh" type="text" placeholder="Search..."><input type='button' id='AjouterDesignation' value='Ajouter Designation' /></div>

                <div class='divTable'>
                    <table id='tabDesignation' class='tableAdmin'>
                        <thead>
                        <tr>
                            <th>Nom Designation</th><th>Description</th><th>Price</th><th>Ancien prix</th><th>Stars</th><th>Vues</th><th>Action</th>
                        </tr>
                        </thead>
                        <tbody id='rawDesignation'></tbody>
                    </table>
                </div>

                </div>
                <!--------------------------------------------------------------------------------------------->
                <div class="tabcontent3" id="tab1_2_4"> 

                    <div class="Action"><input class="txtsearsh" id="ADsearsh" type="text" placeholder="Search..."><input type='button' id='AjouterAdmin' value='Ajouter Admin' /></div>

                    <div class='divTable'>
                        <table id='tabAdmin' class='tableAdmin'>
                            <thead>
                                <tr>
                                    <th>Nom</th><th>Mot de Passe</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody id='rawAdmin'></tbody>
                        </table>
                    </div>

                </div>
                
                <!--------------------------------------------------------------------------------------------->



            </div>



            </div>
        
    </div>




        <!----------------------------------Dialog delete------------------------------------->

        <div class="dialog-delete">
            <div class="dialog-container">
                <div class="hideDelete"><button id="hideDelete">&#215;</button></div>
                
                <h4>Voulez-vous vraiment supprimer ces enregistrements ?</h4>
                <div class="DeleteBtn">
                    <button id="DeleteTrue">Oui</button>
                    <button id="DeleteFalse">Non</button>
                </div>
            </div>
        </div>
        <!----------------------------------------------------------------------->




        <div class="dialog-Chefconfirm">
            <div class="dialog-container">
                <div class="hideChefconfirm"><button id="hideChefconfirm">&#215;</button></div>
                
                <h4>Voulez-vous vraiment Confirmer ?</h4>
                <div class="btnChefconfirm">
                    <button id="ChefconfirmTrue">Oui</button>
                    <button id="ChefconfirmFalse">Non</button>
                </div>
            </div>
        </div>


        <div class="dialog-load">
            <div class="load-content">
                <div class="load-progress">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                    </div>
                </div>
            </div>
        </div>

        







        <!-------------------------------------------------------------------->
        <div class="AJT-MDF" id='AjtC'>
            
            <fieldset class="">
                <legend class="LGBack">Ajouter Nouveau Categorie</legend>
                
                <div>
                    <div>
                        <label>Nom Categorie :</label>
                    </div>
                    <div>
                        <input class="AjNomC" id="AjNomC" type="text">
                    </div>
                </div>

                <div class='LGaction'>
                    <input type="button" class='OK BtnAjt' value="OK"/>
                    <input type="button" class='AN' value="Cancel"/>
                </div>

            </fieldset>
            
        </div>

        <!-------------------------------------------------------------------->
        <div class="AJT-MDF" id='AjtFC'>
            
            <fieldset class="">
                <legend class="LGBack">Ajouter Famile Categorie</legend>
                
                <div>
                  <div>
                    <label>Categorie</label>
                  </div>
                  <div>
                      <select id='AjCategorieFC'></select>
                  </div>                      
                </div>
                

                <div>
                    <div>
                        <label>Nom Famile Categorie  :</label>
                    </div>
                    <div>
                        <input class="AjNomFC" id="AjNomFC" type="text">
                    </div>
                </div>

                <div class='LGaction'>
                    <input type="button" class='OK BtnAjt' value="OK"/>
                    <input type="button" class='AN' value="Cancel"/>
                </div>

            </fieldset>
            
        </div>

        <!-------------------------------------------------------------------->
        <div class="AJT-MDF" id='AjtDS'>
        <form id="f1" name="f1" method="post" action='' autocomplete="off" enctype="multipart/form-data">
            <fieldset class="">
                <legend class="LGBack">Ajouter Nouveau Designation</legend>

                <div>
                    <div>
                        <label>Image</label>
                    </div>
                    <div style='text-align: center'>
                        <div>
                            <input type="file" id="AjFileInput" accept="image/*" onchange="AjLoadFile(event)" hidden/>
                            
                            <div id="div-photo1" class='div-photo'>
                                <img id="AjFT" src="images/icons/plus.png" width="100px" height="100px"onclick="document.getElementById('AjFileInput').click()">
                            </div>
                        </div>
                    </div>
                </div>

               

                <div>
                  <div>
                    <label>Categorie</label>
                  </div>
                  <div>
                      <select id='AjCategorieDS'></select>
                  </div>                      
                </div>

                <div>
                    <div>
                    <label>Famile Categorie</label>
                    </div>
                    <div>
                          <select id='AjFCategorieDS'></select>
                    </div>                      
                </div>
                

                <div>
                    <div>
                        <label>Nom Designation</label>
                    </div>
                    <div>
                        <input class="AjNomDS" id="AjNomDS" type="text">
                    </div>
                </div>

                <div>
                    <div>
                        <label>Description</label>
                    </div>
                    <div>
                        <textarea class="AjDescriptionDS" id="AjDescriptionDS"></textarea>
                    </div>
                </div>

                <div>
                    <div>
                        <label>Prix</label>
                    </div>
                    <div>
                        <input class="AjPrixDS" id="AjPrixDS" type="number">
                    </div>
                </div>

                <div>
                    <div>
                        <label>Ancien prix</label>
                    </div>
                    <div>
                        <input class="AjEPrixDS" id="AjEPrixDS" type="number">
                    </div>
                </div>

                <div>
                    <div>
                        <label>Stars</label>
                    </div>
                    <div>
                        <input class="AjStarsDS" id="AjStarsDS" type="number" max="5" min="0">
                    </div>
                </div>


                <div class='LGaction'>
                    <input type="button" name='ajtDS' class='OK BtnAjt' value="OK"/>
                    <input type="button" class='AN' value="Cancel"/>
                </div>

            </fieldset>
        </form>
        </div>
<!----------------------------------------------------------------------->

            <div class="AJT-MDF" id='AjtAD'>
                
                <fieldset class="">
                    <legend class="LGBack">Ajouter Nouveau Administrateur</legend>
                
                    <div>
                        <div>
                            <label>Nom :</label>
                        </div>
                        <div>
                            <input class="AjNomAD" id="AjNomAD" type="text">
                        </div>                      
                    </div>

                    <div>
                        <div>
                            <label>Mot De pass :</label>
                        </div>
                        <div>
                            <input class="AjPassAD" id="AjPassAD" type="text">
                        </div>                      
                    </div>
                    

                    <div class='LGaction'>
                        <input type="button" class='OK BtnAjt' value="OK"/>
                        <input type="button" class='AN' value="Cancel"/>
                    </div>

                </fieldset>
                
            </div>

<!----------------------------------------------------------------------->


























 <!-------------------------------------------------------------------->
            <div class="AJT-MDF" id='MdfC'>
            
                <fieldset class="">
                    <legend class="LGBack">Modifier Categorie</legend>
                    <div>
                        <div>
                            <label>Nom Categorie</label>
                        </div>
                        <div>
                            <input class="MdNomC" id="MdNomC" type="text">
                        </div>
                    </div>
    
                    <div class='LGaction'>
                        <input type="button" class='OK BtnMd' value="OK"/>
                        <input type="button" class='AN' value="Cancel"/>
                    </div>
    
                </fieldset>
            </div>

 <!-------------------------------------------------------------------->
            <div class="AJT-MDF" id='MdfFC'>
                <fieldset class="">
                    <legend class="LGBack">Modifier Famile Categorie</legend>

                    <div>
                      <div>
                        <label>Categorie</label>
                      </div>
                      <div>
                          <select id='MdCategorieFC'></select>
                      </div>                      
                    </div>

                    <div>
                        <div>
                            <label>Nom Famile Categorie</label>
                        </div>
                        <div>
                            <input class="MdNomFC" id="MdNomFC" type="text">
                        </div>
                    </div>

                    <div class='LGaction'>
                        <input type="button" class='OK BtnMd' value="OK"/>
                        <input type="button" class='AN' value="Cancel"/>
                    </div>

                </fieldset>
            </div>

<!-------------------------------------------------------------------->
            
            <div class="AJT-MDF" id='MdfDS'>
            <form id="f2" name="f2" method="post" action='' autocomplete="off" enctype="multipart/form-data">
            <fieldset class="">
                    <legend class="LGBack">Modifier Designation</legend>
                <div>
                    <div>
                        <label>Image</label>
                    </div>
                    <div style='text-align: center'>
                        <div>
                            <input type="file" id="MdFileInput" accept="image/*" onchange="MdLoadFile(event)" hidden/>
                            
                            <div id="" class='div-photo'>
                                <img id="MdFT" src="images/icons/plus.png" width="100px" height="100px"onclick="document.getElementById('MdFileInput').click()">
                            </div>
                        </div>
                    </div>
                </div>


                    <div>
                      <div>
                        <label>Categorie</label>
                      </div>
                      <div>
                          <select id='MdCategorieDS'></select>
                      </div>                      
                    </div>


                    <div>
                      <div>
                        <label>Famile Categorie</label>
                      </div>
                      <div>
                          <select id='MdFCategorieDS'></select>
                      </div>                      
                    </div>
    
    
                    <div>
                        <div>
                            <label>Nom Designation</label>
                        </div>
                        <div>
                            <input class="MdNomDS" id="MdNomDS" type="text">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label>Description</label>
                        </div>
                        <div>
                            <textarea class="MdDescriptionDS" id="MdDescriptionDS"></textarea>
                        </div>
                    </div>
    
                    <div>
                        <div>
                            <label>Prix</label>
                        </div>
                        <div>
                            <input class="MdPrixDS" id="MdPrixDS" type="number">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label>Ancien prix</label>
                        </div>
                        <div>
                            <input class="MdEPrixDS" id="MdEPrixDS" type="number">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label>Stars (max 5)</label>
                        </div>
                        <div>
                            <input class="MdStarsDS" id="MdStarsDS" type="number" max="5" min="0">
                        </div>
                    </div>
                        
    
                    <div class='LGaction'>
                        <input type="button" class='OK BtnMd' value="OK"/>
                        <input type="button" class='AN' value="Cancel"/>
                    </div>
    
                </fieldset>
</form>
                
            </div>
<!----------------------------------------------------------------------->

            <div class="AJT-MDF" id='MdfAD'>
                
                <fieldset class="">
                    <legend class="LGBack">Modifier Administrateur</legend>
                    <div>
                        <div>
                            <label>Nom :</label>
                        </div>
                        <div>
                            <input class="MdNomAD" id="MdNomAD" type="text">
                        </div>                      
                    </div>

                    <div>
                        <div>
                            <label>Mot De pass :</label>
                        </div>
                        <div>
                            <input class="MdPassAD" id="MdPassAD" type="text">
                        </div>                      
                    </div>
                    
                
                    <div class='LGaction'>
                        <input type="button" class='OK BtnMd' value="OK"/>
                        <input type="button" class='AN' value="Cancel"/>
                    </div>

                </fieldset>
                
            </div>

              









        <div class="footer">
          <p>Copyright &copy; 2020 &reg;</p>
        </div>



    </body>
    

    
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="styles/bootstrap4/bootstrap.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/scriptAdmin.js"></script>





    <!--

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/scriptChef.js"></script>

    -->
    
</html>
