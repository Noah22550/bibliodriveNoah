<?php
require_once('config.php');

// Ajouter au panier
if (isset($_POST['ajouter'])) {
    $_SESSION['panier'][] = array(
        'titre' => $_POST['titre'],
        'auteur' => $_POST['auteur']
    );
}

// Supprimer du panier
if (isset($_GET['supprimer'])) {
    unset($_SESSION['panier'][$_GET['supprimer']]);
}

// Valider le panier
if (isset($_POST['valider'])) {
    $_SESSION['panier'] = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('entete.php'); 
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        echo "<h2>Votre Panier</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Titre du Livre</th>
                    <th>Auteur</th>
                    <th>Action</th>
                </tr>";
        
        foreach ($_SESSION['panier'] as $index => $item) {
            echo "<tr>
                    <td>{$item['titre']}</td>
                    <td>{$item['auteur']}</td>
                    <td><a href='panier.php?supprimer=$index'>Supprimer</a></td>
                  </tr>";
        }
        
        echo "</table>";
        echo "<form method='post'>";
        echo "<button type='submit' name='valider' class='btn btn-success'>Valider l'emprunt</button>";
        echo "</form>";
    } else {
        echo "<h2>Votre panier est vide.</h2>";
    }
    ?>
                <div class="col-sm-3">
                <?php
                    // Si l'utilisateur est connecté
                    if (isset($_SESSION["inscription_completee"])) {
                        echo "<h5>Bonjour<br/>" . $_SESSION['prenom'] . " " . $_SESSION['nom'] . "</h5>";
                        echo "<p>" . $_SESSION['adresse'] . "</p>";
                        echo "<p>" . $_SESSION['codepostal'] . " " . $_SESSION['ville'] . "</p>";
                        echo '<form method="post">
                                <div class="input-group-btn text-center">
                                    <button class="btn btn-danger" name="deco" type="submit">Déconnexion</button>
                                </div>
                            </form>';
                    } else {
                        // Sinon, afficher le formulaire de connexion
                        include('inscription.php');
                    }
                ?>
        </div>
</body>
</html>