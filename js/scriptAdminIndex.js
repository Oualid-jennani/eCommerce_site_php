var checkPsw = document.getElementById("checkPsw");
var psw = document.getElementById("psw");

checkPsw.onchange = function(){
    
    if(checkPsw.checked){
        psw.setAttribute("type", "text");
        
    }else{
        
        psw.setAttribute("type", "password");
    }
}