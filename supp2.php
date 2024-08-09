<?php
if(isset($_GET["idex"])){
    extract($_GET);
    include("dbconne.php");
    try{
        $req = $con ->prepare("DELETE FROM db_etu WHERE id =?");
        $req ->execute([$idex]);
        header("location: accueil.php?msgSupp=Exercice bien supprimé");
        exit;

    }
    catch(PDOException $e){
        echo "Erreur de suppression: " . $e->getMessage();
    }
}



?>