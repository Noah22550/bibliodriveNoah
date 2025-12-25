<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Mon Panier</title>
</head>
<body>
    <?php 
    require_once('config.php');
    
    // Ajouter un livre au panier
    if (isset($_GET['emprunter'])) {
        $_SESSION['panier'][] = $_GET['emprunter'];
    }

    // Supprimer un livre du panier
    if (isset($_GET['supprimer'])) {
        unset($_SESSION['panier'][$_GET['supprimer']]);
    }

    // Vider le panier
    if (isset($_GET['valider'])) {
        unset($_SESSION['panier']);
    }
    
    include('entete.php'); 
    ?>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-9">
                <h2>Mon Panier</h2>
                
                <?php
                if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
                    
                    echo "<table class='table'>";
                    echo "<tr><th>Titre</th><th>Auteur</th><th></th></tr>";
                    
                    foreach ($_SESSION['panier'] as $index => $nolivre) {
                        
                        $stmt = $connexion->prepare("SELECT livre.titre, auteur.nom, auteur.prenom 
                                                      FROM livre 
                                                      INNER JOIN auteur ON livre.noauteur = auteur.noauteur 
                                                      WHERE livre.nolivre = :nolivre");
                        $stmt->bindValue(":nolivre", $nolivre);
                        $stmt->execute();
                        $livre = $stmt->fetch(PDO::FETCH_OBJ);
                        
                        echo "<tr>";
                        echo "<td>$livre->titre</td>";
                        echo "<td>$livre->nom $livre->prenom</td>";
                        echo "<td><a href='panier.php?supprimer=$index' class='btn btn-danger btn-sm'>Supprimer</a></td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                    echo "<a href='panier.php?valider=1' class='btn btn-success'>Valider</a>";
                    
                } else {
                    echo "<p>Panier vide</p>";
                }
                ?>
                
                <a href='recherchelivres.php' class='btn btn-primary mt-3'>Retour</a>
            </div>
            
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
        </div>
    </div>
</body>
</html>