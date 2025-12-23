<?php
    require_once('config.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
    <title>Recherche de livres - Bibliodrive</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('entete.php'); ?>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-9">
                <?php
                    $search = isset($_GET['Auteur']) ? trim($_GET['Auteur']) : '';
                    
                    $sql = "SELECT livre.nolivre, livre.titre, auteur.nom, auteur.prenom 
                            FROM livre 
                            INNER JOIN auteur ON livre.noauteur = auteur.noauteur";
                    
                    if ($search) {
                        $sql .= " WHERE auteur.nom LIKE :search OR auteur.prenom LIKE :search";
                        echo "<h2>Résultats pour : $search</h2>";
                    } else {
                        echo "<h2>Tous les livres</h2>";
                    }
                    
                    $sql .= " ORDER BY livre.titre";
                    
                    $stmt = $connexion->prepare($sql);
                    
                    if ($search) {
                        $stmt->bindValue(":search", "%$search%");
                    }
                    
                    $stmt->execute();
                    
                    echo "<ul class='list-group'>";
                    while ($livre = $stmt->fetch(PDO::FETCH_OBJ)) {
                        echo "<a href='detaillivre.php?nolivre=$livre->nolivre' class='list-group-item list-group-item-action'>";
                        echo "<h5>$livre->titre</h5>";
                        echo "<small class='text-muted'>$livre->nom $livre->prenom</small>";
                        echo "</a>";
                    }
                    echo "</ul>";
                ?>
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