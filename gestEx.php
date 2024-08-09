<?php
    include("dbconne.php");
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        extract($_POST);
        $err=[];
        if(!isset($titre) || empty($titre)){
            $err["titre"] = "le titre est vide";

        }
        if (!isset($auteur) || empty($auteur)){
            $err["auteur"] = "le champs d'auteur est vide";
        }
        if(!isset($date) || empty($date)){
            $err["date"] = "la date est vide";
        }
        if(isset($env)){
            if (empty($err)) {
                try {
                    $req = $con->prepare("INSERT INTO exercice (titre, auteur, date) VALUES (?, ?, ?)");
                    $req->execute([$titre, $auteur, $date]);
                    echo "<script>alert('Message bien enregistré');</script>";
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
        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f9;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-modify {
            background-color: #28a745;
            color: #fff;
        }
        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-modify a, .btn-delete a {
            color: white;
            text-decoration: none;
        }

        .btn-modify, .btn-delete {
            border: none;
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            font-size: 1em;
            border-radius: 4px;
        }

        .btn-modify {
            background-color: #007bff;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-modify:hover {
            background-color: #0056b3;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .succ{
            background-color: greenyellow;
            color: #fff;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php if(isset($msg)) echo $msg;
    elseif(isset($_GET["msg"])) echo "<div class='succ'>".$_GET["msg"]."</div>"?>
    <?php if(isset($msg)) echo $msg;
    elseif(isset($_GET["msgm"])) echo "<div class='succ'>".$_GET["msgm"]."</div>"?>
<fieldset>
    <legend>Ajouter un exercice</legend>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
        <label for="titre">Titre de l'exercice</label>
        <?php if (isset($err["titre"])) { echo '<div class="error">' . $err["titre"] . '</div>'; } ?>
        <input type="text" name="titre" placeholder="entrez le titre.." >
        <br>
        <label for="auteur">Auteur de l'exercice</label>
        <?php if (isset($err["auteur"])) { echo '<div class="error">' . $err["auteur"] . '</div>'; } ?>
        <input type="text" name="auteur" placeholder="entrez l'auteur.." >
        <br>
        <label for="date">Date création</label>
        <?php if (isset($err["date"])) { echo '<div class="error">' . $err["date"] . '</div>'; } ?>
        <input type="date" name="date" placeholder="entrez la date de création">
        <br>
        <button type="submit" name="env">Envoyer</button>
    </form>
</fieldset>



    <?php

try {
    $req = $con->prepare("SELECT * FROM exercice");
    $req->execute();
    $tab = $req->fetchAll(PDO::FETCH_ASSOC);
    if ($req->rowCount()==0){
        echo "aucun exercice trouvé dans la base de données";
    }else {
    echo "<table border='1px'>
        <tr>
            <th>Id avis</th>
            <th>Date</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>";
        foreach($tab as $ligne){
            echo "<tr>";
            foreach($ligne as $v){
                echo "<td>$v</td>";
            }
            echo "<td class='action-buttons'>
                    <button class='btn-modify'><a href='modifier.php?idex=$ligne[id]'>Modifier</a></button>

                    <button class='btn-delete'><a href='supprimer.php?idex=$ligne[id]'>Supprimer</a></button>

                </td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    } catch(PDOException $e){
        echo 'erreur de selection :'.$e->getMessage();
    }




    ?>
</body>
</html>