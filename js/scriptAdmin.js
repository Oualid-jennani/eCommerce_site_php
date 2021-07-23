var idCom;

var idC = null,idFC = null,idDS = null,idAD = null;
var AddC = false,AddFC = false,AddDS = false,AddAD = false;

//----------- Ajouter input ---------------------

var AjNomC = document.getElementById("AjNomC");

var AjCategorieFC = document.getElementById("AjCategorieFC");
var AjNomFC = document.getElementById("AjNomFC");

var AjFileInput = document.getElementById("AjFileInput");
var AjimageDs = document.getElementById("AjFT");
var AjCategorieDS = document.getElementById("AjCategorieDS");
var AjFCategorieDS = document.getElementById("AjFCategorieDS");
var AjNomDS = document.getElementById("AjNomDS");
var AjPrixDS = document.getElementById("AjPrixDS");
var AjEPrixDS = document.getElementById("AjEPrixDS");
var AjStarsDS = document.getElementById("AjStarsDS");
var AjDescriptionDS = document.getElementById("AjDescriptionDS");


var AjNomAD = document.getElementById("AjNomAD");
var AjPassAD = document.getElementById("AjPassAD");



//----------- Modifier input ---------------------

var MdNomC = document.getElementById("MdNomC");

var MdCategorieFC = document.getElementById("MdCategorieFC");
var MdNomFC = document.getElementById("MdNomFC");



var MdFileInput = document.getElementById("MdFileInput");
var MdimageDs = document.getElementById("MdFT");
var MdCategorieDS = document.getElementById("MdCategorieDS");
var MdFCategorieDS = document.getElementById("MdFCategorieDS");
var MdNomDS = document.getElementById("MdNomDS");
var MdPrixDS = document.getElementById("MdPrixDS");
var MdEPrixDS = document.getElementById("MdEPrixDS");
var MdStarsDS = document.getElementById("MdStarsDS");
var MdDescriptionDS = document.getElementById("MdDescriptionDS");


var MdNomAD = document.getElementById("MdNomAD");
var MdPassAD = document.getElementById("MdPassAD");

var changeImg = "change";
//----------- Afficher input ---------------------










function clear(){
    $('.AJT-MDF input[type="text"],.AJT-MDF input[type="number"],.AJT-MDF textarea').val('');
    MdimageDs.src= "images/icons/plus.png";
    AjimageDs.src= "images/icons/plus.png";
}



var AjLoadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('AjFT');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};


var MdLoadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('MdFT');
      output.src = reader.result;
      changeImg = "changed";
    };
    reader.readAsDataURL(event.target.files[0]);
};









$(document).ready(function(){
    //-------------------------------------------
    $('input').change(function(){
        $(this).removeClass('Eroor');
    })
    $('input').keyup(function(){
        $(this).removeClass('Eroor');
    })
    $('select').change(function(){
        $(this).removeClass('Eroor');
    })
    $('input[type=number]').change(function(){
        if($(this).val() < 1){$(this).val(1)}
    })
    //-------------------------------------------
    
    //----------Window Hider----------------
    var HeightHeder = $('.header').innerHeight();
    $('html').css({'padding-top':''+HeightHeder+'px'})
    
    var HeightFooter = $('.footer').innerHeight();
    $('html').css({'padding-bottom':''+HeightFooter+'px'})
    
    $(window).on('resize', function(){
        
        var HeightHeder = $('.header').innerHeight();
        $('html').css({'padding-top':''+HeightHeder+'px'})
        
        var HeightFooter = $('.footer').innerHeight();
        $('html').css({'padding-bottom':''+HeightFooter+'px'})
    });
    //---------------------------------------


















    //---------------Tout les table commande :recherche - toogle row ... ---------------
    
    $(".txtsearshCom").on("keyup", function() {
        
        $(".txtsearshCom").val($(this).val());
        if($(this).val()==""){
            $(".tableCommande table").hide(); 
            $(".tableCommande table:first").show(); 
            $(".tableCommande table:first").prev().hide();
        }else{
            $(".tableCommande table").show(); 
        }
        
        
        var searsh = $(this).val().toLowerCase();

        $(".tableCommande tbody tr").not($('.tableCommande table tr')).filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(searsh) > -1)
        });

        $(".tableCommande tr:first").show();
        
    });

    

    $(".clientInfo").click(function(){
    

        var s = $(this).html();
        s.replace(':', 'gg');

        $(this).html(s);

    })

    
    




    var tabletoogle = 0;

    $(".tableCommande table:first").show(); 
    $(".tableCommande table:first").prev().hide();
    
    $(".tableCommande >tbody tr ").not($('.tableCommande table tr')).click(function() {
        if(tabletoogle == 0 && !$(this).hasClass("active")){
            $(".tableCommande table").prev().show();
            $(".tableCommande table").hide();
            $(".tableCommande tr").removeClass('active');
            $(this).children("td").children("table").slideDown(200);
            $(this).children("td").children("table").prev().hide();
            $(this).addClass('active');
        }
    });
    
    
    
    $(".detai").click(function() {
        if(tabletoogle == 0){
            $(".tableCommande table").show();
            $(".tableCommande table").prev().hide();
            $(this).html('&#9084;');
            tabletoogle=1;
        }
        else{
            $(".tableCommande table").hide(); 
            $(".tableCommande table").prev().show();
            $(".tableCommande table:first").show(); 
            $(".tableCommande table:first").prev().hide();
            $(this).html('&#8623;');
            tabletoogle=0;
        }
    });
    //---------------------------------------------------








    $('#hideChefconfirm').click(function(){
        $('.dialog-Chefconfirm').fadeOut(300);
    });
    $('#ChefconfirmFalse').click(function(){
        $('.dialog-Chefconfirm').fadeOut(300);
    });
    $('#ChefconfirmTrue').click(function(){
        $.post('CodeValid.php',{postenumCommande:idCom,posteConfirm:"true"});
        $('.dialog-Chefconfirm').fadeOut(300);
    });
    
    $(".tableCommande tbody").not($('.tableCommande table tbody')).sortable();































    //-------Supprimer--------------------------------------------------------------

    $('.tableAdmin').on('click','.btnEdit,.btnDelete',function(){
        $('.btnEdit,.btnDelete').parent().parent('tr').removeClass('selected');
        $(this).parent().parent('tr').addClass('selected');
    });


    $('.tableAdmin > tbody').on('click','tr', function(){
        $('.tableAdmin tbody tr').removeClass('selected');
        $(this).addClass('selected');
    });


    $('#hideDelete').click(function(){
        $('.dialog-delete').fadeOut(300);
    });
    $('#DeleteFalse').click(function(){
        $('.dialog-delete').fadeOut(300);
    });

    $('#DeleteTrue').click(function(){
        
        if(idC != null){
            $.post('CodeValid.php',{table:"categorie",nomColumn:"idC",whereIdDelete:idC});
            $('.selected').hide();
        }else if (idFC != null){
            $.post('CodeValid.php',{table:"categorie",nomColumn:"idC",whereIdDelete:idFC});
            $('.selected').hide();
        }else if (idDS != null){
            $.post('CodeValid.php',{table:"Designation",nomColumn:"idDS",whereIdDelete:idDS},function(data){console.log(data);});
            $('.selected').hide();
        }else if (idAD != null){;
            $.post('CodeValid.php',{table:"admin",nomColumn:"idAD",whereIdDelete:idAD});
            $('.selected').hide();
        }
        
        $('.dialog-delete').fadeOut(300);
    });

    //-------Supprimer--------------------------------------------------------------



    //-------Ajouter--------------------------------------------------------------

    $('#AjouterCategorie').click(function(){
        $('#AjtC').fadeIn(300);
        AddCategorie();
    })
    $('#AjouterFCategorie').click(function(){
        $('#AjtFC').fadeIn(300);
        AddFCategorie();
    })
    $('#AjouterDesignation').click(function(){
        $('#AjtDS').fadeIn(300);
        AddDesignation();
    })
    $('#AjouterAdmin').click(function(){
        $('#AjtAD').fadeIn(300);
        AddAdmin();
    })

    $('.BtnAjt').click(function(){

        if(AddC == true){
            var testInp = true;

            if(AjNomC.value == ""){
                AjNomC.className += " Eroor";
                testInp = false;
            }

            if(testInp){
                $.post('CodeValid.php',{AjtCategorie:"true",AjNomC:AjNomC.value},function(){remplirTableCT();});
                $('.AJT-MDF').hide();
                clear();
            }

        }
        else if(AddFC == true){
            
            var testInp = true;
            
            if(AjCategorieFC.value == ""){
                AjCategorieFC.className += " Eroor";
                testInp = false;
            }
            if(AjNomFC.value == ""){
                AjNomFC.className += " Eroor";
                testInp = false;
            }
            

            if(testInp){
                $.post('CodeValid.php',{AjtFCategorie:"true",AjCategorieFC:AjCategorieFC.value,AjNomFC:AjNomFC.value},function(){remplirTableFCT();});
                $('.AJT-MDF').hide();
                clear();
            }
           
        }
        else if (AddDS == true){
            //------------------------------

            var testInp = true;
            
            if(AjCategorieDS.value == ""){
                AjCategorieDS.className += " Eroor";
                testInp = false;
            }
            if(AjFCategorieDS.value == ""){
                AjFCategorieDS.className += " Eroor";
                testInp = false;
            }
            if(AjNomDS.value == ""){
                AjNomDS.className += " Eroor";
                testInp = false;
            }
            if(AjPrixDS.value == "" || isNaN(AjPrixDS.value)){
                AjPrixDS.className += " Eroor";
                testInp = false;
            }
            if(AjEPrixDS.value == "" || isNaN(AjEPrixDS.value)){
                AjEPrixDS.className += " Eroor";
                testInp = false;
            }

            if(AjStarsDS.value == "" || isNaN(AjStarsDS.value)){
                AjStarsDS.className += " Eroor";
                testInp = false;
            }


            if(AjDescriptionDS.value == ""){
                AjDescriptionDS.className += " Eroor";
                testInp = false;
            }
            
            if(testInp){
                var data = new FormData();

                jQuery.each(jQuery('#AjFileInput')[0].files, function(i, file) {
                    data.append('image-'+i, file);
                });


                data.append('AjtDesignation',true);
                data.append('AjCategorieDS',AjFCategorieDS.value);
                data.append('AjNomDS',AjNomDS.value);
                data.append('AjPrixDS',AjPrixDS.value);
                data.append('AjEPrixDS',AjEPrixDS.value);
                data.append('AjStarsDS',AjStarsDS.value);
                data.append('AjDescriptionDS',AjDescriptionDS.value);


                
                $('.dialog-load').show();
                $.ajax({
                    url: "CodeValid.php",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    success: function (data) {
                        clear();
                        $('.AJT-MDF').hide();
                        remplirTableDS();
                        $('.dialog-load').hide();
     
                    }
                });           
            }
            
        }
        else if(AddAD == true){
            var testInp = true;
            
 
             if(AjNomAD.value == ""){
                 AjNomAD.className += " Eroor";
                 testInp = false;
             }
             if(AjPassAD.value == ""){
                 AjPassAD.className += " Eroor";
                 testInp = false;
             }
            
             if(testInp){
                 $.post('CodeValid.php',{AjtAdmin:"true",AjNomAD:AjNomAD.value,AjPassAD:AjPassAD.value},function(){remplirTableAD();});
                 $('.AJT-MDF').hide();
                 clear();
             }
            
        }

    });

    //-------Ajouter--------------------------------------------------------------
    
   
    
    //-------Modifier--------------------------------------------------------------

    $('.BtnMd').click(function(){
        if(idC != null){
            var testInp = true;

            if(MdNomC.value == ""){
                MdNomC.className += " Eroor";
                testInp = false;
            }

            if(testInp){
                $.post('CodeValid.php',{MdtCategorie:"true",MdNomC:MdNomC.value,idC:idC},function(){remplirTableCT();});
                $('.AJT-MDF').hide();
                clear();
            }

        }
        else if(idFC != null){
            
            var testInp = true;
            
            if(MdCategorieFC.value == ""){
                MdCategorieFC.className += " Eroor";
                testInp = false;
            }
            if(MdNomFC.value == ""){
                MdNomFC.className += " Eroor";
                testInp = false;
            }
            
           
            if(testInp){
                $.post('CodeValid.php',{MdtFCategorie:"true",MdNomFC:MdNomFC.value,MdCategorieFC:MdCategorieFC.value,idC:idFC},function(){remplirTableFCT();});
                $('.AJT-MDF').hide();
                clear();
            }
           
        }
        else if (idDS != null){
            //------------------------------

            var testInp = true;
            
            if(MdCategorieDS.value == ""){
                MdCategorieDS.className += " Eroor";
                testInp = false;
            }
            if(MdFCategorieDS.value == ""){
                MdFCategorieDS.className += " Eroor";
                testInp = false;
            }
            if(MdNomDS.value == ""){
                MdNomDS.className += " Eroor";
                testInp = false;
            }
            if(MdPrixDS.value == "" || isNaN(MdPrixDS.value)){
                MdPrixDS.className += " Eroor";
                testInp = false;
            }
            if(MdEPrixDS.value == "" || isNaN(MdEPrixDS.value)){
                MdEPrixDS.className += " Eroor";
                testInp = false;
            }

            if(MdStarsDS.value == "" || isNaN(MdStarsDS.value)){
                MdStarsDS.className += " Eroor";
                testInp = false;
            }

            if(MdDescriptionDS.value == ""){
                MdDescriptionDS.className += " Eroor";
                testInp = false;
            }
            
            if(testInp){

                var data = new FormData();

                jQuery.each(jQuery('#MdFileInput')[0].files, function(i, file) {
                    data.append('image-'+i, file);
                });

                
                data.append('changeImg',changeImg);

                data.append('MdtDesignation',true);
                data.append('MdCategorieDS',MdCategorieDS.value);
                data.append('MdFCategorieDS',MdFCategorieDS.value);
                data.append('MdNomDS',MdNomDS.value);
                data.append('MdPrixDS',MdPrixDS.value);
                data.append('MdEPrixDS',MdEPrixDS.value);
                data.append('MdStarsDS',MdStarsDS.value);
                data.append('MdDescriptionDS',MdDescriptionDS.value);
                data.append('idDS',idDS);


                $('.dialog-load').show();
                $.ajax({
                    url: "CodeValid.php",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    success: function (data) {
                        clear();
                        $('.AJT-MDF').hide();
                        remplirTableDS();
                        $('.dialog-load').hide();
                    }
                }); 
            }
            
        }
        else if(idAD != null){
            var testInp = true;
            
             if(MdNomAD.value == ""){
                 MdNomAD.className += " Eroor";
                 testInp = false;
             }
             if(MdPassAD.value == ""){
                 MdPassAD.className += " Eroor";
                 testInp = false;
             }
            
             if(testInp){
                 $.post('CodeValid.php',{MdtAdmin:"true",MdNomAD:MdNomAD.value,MdPassAD:MdPassAD.value,idAD:idAD},function(data){console.log(data);remplirTableAD();});
                 $('.AJT-MDF').hide();
                 clear();
                 console.log("hello");
             }
            
        }

    });
    
    //-------Modifier--------------------------------------------------------------
    

    

    //-------Recherche-------------------------------------------------------------

    $("#CTsearsh").on("keyup", function() {
    
        var searsh = $(this).val().toLowerCase();

        $("#rawCategorie tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(searsh) > -1)
        });
        
    });

        
    $("#FCTsearsh").on("keyup", function() {
    
        var searsh = $(this).val().toLowerCase();

        $("#rawFamileCategorie tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(searsh) > -1)
        });
        
    });
        
    $("#DSsearsh").on("keyup", function() {
    
        var searsh = $(this).val().toLowerCase();

        $("#rawDesignation tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(searsh) > -1)
        });
        
    });

    $("#ADsearsh").on("keyup", function() {
    
        var searsh = $(this).val().toLowerCase();

        $("#rawAdmin tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(searsh) > -1)
        });
        
    });
        
    //-------Recherche-------------------------------------------------------------


    //---------Annuler -------------------------------------------------------
    $('.AN').click(function(){
        $('.AJT-MDF').hide();
        clear();
    })




    $('#hideChefconfirm').click(function(){
        $('.dialog-Chefconfirm').fadeOut(300);
    });
    $('#ChefconfirmFalse').click(function(){
        $('.dialog-Chefconfirm').fadeOut(300);
    });
    $('#ChefconfirmTrue').click(function(){
        $.post('CodeValid.php',{postenumCommande:idCom,posteConfirm:"true"});
        $('.dialog-Chefconfirm').fadeOut(300);
    });

    

});



function funConfermation(idCM){
    idCom = idCM;
    $('.dialog-Chefconfirm').fadeIn(400);
}








//-------Ajouter--------------------------------------------------------------


function AddCategorie(){
    AddC = true;
    AddFC = false;
    AddDS = false;
    AddAD = false;

    $('#AjtC').fadeIn(400);
}

function AddFCategorie(){
    AddC = false;
    AddFC = true;
    AddDS = false;
    AddAD = false;

    $.post('CodeValid.php',{remplireSelCT:"true"}, function(data){AjCategorieFC.innerHTML= data;});

    $('#AjtFC').fadeIn(400);
}

function AddDesignation(){
    AddC = false;
    AddFC = false;
    AddDS = true;
    AddAD = false;

    $.post('CodeValid.php',{remplireSelCT:"true"}, function(data){AjCategorieDS.innerHTML= data;changeFCT()});

    function changeFCT(){$.post('CodeValid.php',{remplireSelFCT:"true",whereVal:AjCategorieDS.value}, function(data){AjFCategorieDS.innerHTML= data;});}
    AjCategorieDS.onchange = function(){changeFCT();}
    
    $('#AjtDS').fadeIn(400);
}

function AddAdmin(){
    AddC = false;
    AddFC = false;
    AddDS = false;
    AddAD = true;

    $('#AjtAD').fadeIn(400);
}






//-------Ajouter--------------------------------------------------------------



//-------Supprimer--------------------------------------------------------------
function DeleteCT(idc){
    idC = idc;
    idFC = null;
    idDS = null;
    idAD = null;

    $('.dialog-delete').fadeIn(400);
}

function DeleteFCT(idfc){
    idC = null;
    idFC = idfc;
    idDS = null;
    idAD = null;

    $('.dialog-delete').fadeIn(400);
}

function DeleteDS(idds){
    idC = null;
    idFC = null;
    idDS = idds;
    idAD = null;

    $('.dialog-delete').fadeIn(400);
}

function DeleteAD(idad){
    idC = null;
    idFC = null;
    idDS = null;
    idAD = idad;

    $('.dialog-delete').fadeIn(400);
}
//-------Supprimer--------------------------------------------------------------



//-------Modifier---------------------------------------------------------------
function EditCT(idc){
    idC = idc;
    idFC = null;
    idDS = null;
    idAD = null;


    $('#MdfC').fadeIn(400);
}

function EditFCT(idfc){
    idC = null;
    idFC = idfc;
    idDS = null;
    idAD = null;

    $.post('CodeValid.php',{remplireSelCT:"true"}, function(data){MdCategorieFC.innerHTML= data; SelectedMd_CT_FCT();});
    
    $('#MdfFC').fadeIn(400);
}

function EditDS(idds){
    idC = null;
    idFC = null;
    idDS = idds;
    idAD = null;

    $.post('CodeValid.php',{getImage:"true",idDS:idDS}, function(data){
        if(data != "images/Images_Designation/dist_test.png"){MdimageDs.src= data;}
    });

    $.post('CodeValid.php',{remplireSelCT:"true"}, function(data){MdCategorieDS.innerHTML= data; SelectedMd_CT_DS(); changeFCT();});

    function changeFCT(){$.post('CodeValid.php',{remplireSelFCT:"true",whereVal:MdCategorieDS.value}, function(data){MdFCategorieDS.innerHTML= data; SelectedMd_FCT_DS(); });}
    MdCategorieDS.onchange = function(){changeFCT();}

    $('#MdfDS').fadeIn(400);
}

function EditAD(idad){
    idC = null; 
    idFC = null;
    idDS = null;
    idAD = idad;

    $('#MdfAD').fadeIn(400);
}


//-------function show detai row mdifier in select ----------------------
//--------CT--------

function SelectedMd_CT_FCT(){
    for (var i = 0; i < MdCategorieFC.length; i++) {
 
         if(MdCategorieFC.options[i].value == selCategorie1.value){
            MdCategorieFC.options[i].selected = true;
            break;
         }
     }
 }
 //--------CT--------

function SelectedMd_CT_DS(){
    for (var i = 0; i < MdCategorieDS.length; i++) {
 
         if(MdCategorieDS.options[i].value == selCategorie2.value){
            MdCategorieDS.options[i].selected = true;
            break;
         }
     }
 }

 function SelectedMd_FCT_DS(){
    for (var i = 0; i < MdFCategorieDS.length; i++) {
 
         if(MdFCategorieDS.options[i].value == selFCategorie.value){
            MdFCategorieDS.options[i].selected = true;
            break;
         }
     }
 }

 

 
//-------function show detai row mdifier in input ----------------------




var rawCategorieMd = document.getElementById("rawCategorie");
var rawFamileCategorieMd = document.getElementById("rawFamileCategorie");
var rawDesignationMd = document.getElementById("rawDesignation");
var rawAdminMd = document.getElementById("rawAdmin");


function selectValueMd(){

    for(var i = 0 ;i  < rawCategorieMd.rows.length; i++){
        rawCategorieMd.rows[i].onclick = function(){
            MdNomC.value = this.cells[0].innerHTML;
        }
    }

    for(var i = 0 ;i  < rawFamileCategorieMd.rows.length; i++){
        rawFamileCategorieMd.rows[i].onclick = function(){
            MdNomFC.value = this.cells[0].innerHTML;
        }
    }
    
    for(var i = 0 ;i  < rawDesignationMd.rows.length; i++){
        rawDesignationMd.rows[i].onclick = function(){
            MdNomDS.value = this.cells[0].innerHTML;
            MdDescriptionDS.value = this.cells[1].textContent;
            MdPrixDS.value = this.cells[2].innerHTML;
            MdEPrixDS.value = this.cells[3].innerHTML;
            MdStarsDS.value = this.cells[4].innerHTML;
        }
    }
    

    for(var i = 0 ;i  < rawAdminMd.rows.length; i++){
        rawAdminMd.rows[i].onclick = function(){
            MdNomAD.value = this.cells[0].innerHTML;
            MdPassAD.value = this.cells[1].innerHTML;
        }
    }
} 
//-------function show detai row mdifier in input ----------------------


//-------Modifier---------------------------------------------------------------






//-------Afficher----------------------------------------------------------------

var rawCategorie = document.getElementById("rawCategorie");
var rawFamileCategorie = document.getElementById("rawFamileCategorie");
var rawDesignation = document.getElementById("rawDesignation");
var rawAdmin = document.getElementById("rawAdmin");

var selCategorie1 = document.getElementById("selCategorie1");
var selCategorie2 = document.getElementById("selCategorie2");
var selFCategorie = document.getElementById("selFCategorie");



function remplirTableCT(){
    $.post('CodeValid.php',{AfficherCT:true}, function(data){rawCategorie.innerHTML= data; selectValueMd();});
}


//--execute
remplirTableCT();
//-------------------------

function remplirTableFCT(){$.post('CodeValid.php',{AfficherFCT:true,whereVal:selCategorie1.value}, function(data){rawFamileCategorie.innerHTML= data; selectValueMd();});}

function remplirSelCT1(){$.post('CodeValid.php',{remplireSelCT:true}, function(data){selCategorie1.innerHTML = data;remplirTableFCT();});}
selCategorie1.onchange = function(){remplirTableFCT();}

//--execute
remplirSelCT1();
//-------------------------
function remplirSelCT2(){$.post('CodeValid.php',{remplireSelCT:true}, function(data){selCategorie2.innerHTML = data;remplirSelFCT();});}
selCategorie2.onchange = function(){remplirSelFCT();}

function remplirSelFCT(){$.post('CodeValid.php',{remplireSelFCT:true,whereVal:selCategorie2.value}, function(data){selFCategorie.innerHTML = data;remplirTableDS();});}
selFCategorie.onchange = function(){remplirTableDS();}


function remplirTableDS(){$.post('CodeValid.php',{AfficherDS:true,whereVal:selFCategorie.value}, function(data){rawDesignation.innerHTML= data; selectValueMd();});}

//--execute
remplirSelCT2();
//-------------------------
function remplirTableAD(){$.post('CodeValid.php',{AfficherAD:true}, function(data){rawAdmin.innerHTML= data; selectValueMd();});}

//--execute
remplirTableAD();
//-------Afficher----------------------------------------------------------------









function funSlider1(evt,idDS){
    $.post('CodeValid.php',{ChangeSlider1:true,idDS:idDS,Val:evt.target.value},function(data){
        if(evt.target.value == "true")evt.target.value = "false";
        else evt.target.value = "true";
    });
}

function funSlider2(idDS){
    $.post('CodeValid.php',{ChangeSlider2:true,idDS:idDS});
}
























document.getElementById("tab1_1").style.display = "block";

function openTab1(evt, TabeName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent1");
    for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks1");
    for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(TabeName).style.display = "block";
    evt.currentTarget.className += " active";
}





document.getElementById("tab1_1_1").style.display = "block";

function openTab2(evt, TabeName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent2");
    for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks2");
    for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(TabeName).style.display = "block";
    evt.currentTarget.className += " active";
}


document.getElementById("tab1_2_1").style.display = "block";

function openTab3(evt, TabeName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent3");
    for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks3");
    for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(TabeName).style.display = "block";
    evt.currentTarget.className += " active";
}


