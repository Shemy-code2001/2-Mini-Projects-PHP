<?php
    include("dbconne.php");
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        extract($_POST);
        $err=[];
        if(!isset($nom) || empty($nom)){
            $err["nom"] = "le nom est vide";

        }
        if (!isset($email) || empty($email)){
            $err["email"] = "le champs d'email est vide";
        }
        if (empty($err)) {
            if(isset($_GET["idex"])){
                extract($_GET);
                try {
                    $req = $con->prepare("UPDATE db_etu SET nom =?, email=? WHERE id=?");
                    $req->execute([$nom, $email, $idex]);
                    header("Location: accueil.php?msgm=Exercice bien modifier");
                    exit;
                } catch (PDOException $e) {
                    echo "Erreur d'insertion : " . $e->getMessage();
                }
            }
            
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }
        fieldset {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        legend {
            font-size: 1.5em;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php
    if(isset($_GET["idex"])){
        try{
            $req = $con->prepare("SELECT nom,email FROM db_etu WHERE id=?");
            $req ->execute([$_GET["idex"]]);
            $v = $req->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "Erreur d'extraction d'infos: " . $e->getMessage();
        }
    }
    ?>
<fieldset>
    <legend>Modifier Etudiant</legend>
    <form method="POST">
        <label for="nom">Nom</label>
        <?php if (isset($err["nom"])) { echo '<div class="error">' . $err["nom"] . '</div>'; } ?>
        <input type="text" name="nom" placeholder="entrez le nom.." value="<?= $v['nom']?>">
        <br>
        <label for="email">Email</label>
        <?php if (isset($err["email"])) { echo '<div class="error">' . $err["email"] . '</div>'; } ?>
        <input type="text" name="email" placeholder="entrez l'email.." value="<?= $v['email']?>">
        <br>
        <button type="submit" name="env">Modifier</button>
    </form>
</fieldset>



    
</body>
</html>