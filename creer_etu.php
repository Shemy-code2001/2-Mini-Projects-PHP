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
        if(isset($env)){
            if (empty($err)) {
                try {
                    $req = $con->prepare("INSERT INTO db_etu (nom, email) VALUES (?, ?)");
                    $req->execute([$nom, $email]);
                    echo "<script>alert('Message bien enregistré');</script>";
                    header("Location: accueil.php");
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
<fieldset>
<?php if(isset($msg)) echo $msg;
    elseif(isset($_GET["msgSupp"])) echo "<div class='succ'>".$_GET["msgSupp"]."</div>"?>
    <legend>Creer Etudiant</legend>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
        <label for="nom">Nom</label>
        <?php if (isset($err["nom"])) { echo '<div class="error">' . $err["nom"] . '</div>'; } ?>
        <input type="text" name="nom" placeholder="entrez le nom.." value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>">
        <br>
        <label for="email">Email</label>
        <?php if (isset($err["email"])) { echo '<div class="error">' . $err["email"] . '</div>'; } ?>
        <input type="text" name="email" placeholder="entrez l'email.." value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
        <br>
        <button type="submit" name="env">Envoyer</button>
    </form>
</fieldset>



    
</body>
</html>