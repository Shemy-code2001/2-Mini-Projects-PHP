<?php
if(isset($_GET["idex"])){
    extract($_GET);
    include("dbconne.php");
    try{
        $req = $con ->prepare("DELETE FROM exercice WHERE id =?");
        $req ->execute([$idex]);
        header("location: gestEx.php?msg=Exercice bien supprimé");
        exit;

    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
}



?>