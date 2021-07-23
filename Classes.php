<?php 
class ligneCommande {
    public $Designation;
    public $quantite;

    public static $ligneC = array();

    function __construct($Designation,$quantite){
        $this->Designation = $Designation;
        $this->quantite = $quantite;
    }
}

?>