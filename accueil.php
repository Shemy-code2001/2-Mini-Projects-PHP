<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
        nav {
            background-color: #333;
            padding: 10px;
            text-align: center;
            margin-bottom: 30px;
        }
        nav ul {
            list-style: none;
            display: flex;
            justify-content: space-between;
        }
        nav a {
            color: #fff;
            text-decoration: none;
        }
        nav a:hover {
            color: #ccc;
            background-color: #007bff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li>
                <a href="creer_etu.php">Créer Etudiant</a>
            </li>
            <li>
                <a href="accueil.php">Accueil</a>
            </li>
        </ul>
    </nav>
<?php
include("dbconne.php");
try {
    $req = $con->prepare("SELECT * FROM db_etu");
    $req->execute();
    $tab = $req->fetchAll(PDO::FETCH_ASSOC);
    if ($req->rowCount()==0){
        echo "aucun etudiant trouvé dans la base de données";
    }else {
    echo "<table border='1px'>
        <tr>
            <th>Id</th>
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
                    <button class='btn-modify'><a href='modifier2.php?idex=$ligne[id]'>Modifier</a></button>
                    <button class='btn-delete'><a href='supp2.php?idex=$ligne[id]'>Supprimer</a></button>
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