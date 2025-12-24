<?php
    require_once('config.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
    <title>Détail du livre - Bibliodrive</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('entete.php'); ?>
    
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-9">
                <?php 
                    if (isset($_GET['nolivre'])) {
                        $nolivre = $_GET['nolivre'];
                        
                        $sql = "SELECT livre.*, auteur.nom, auteur.prenom 
                                FROM livre 
                                INNER JOIN auteur ON livre.noauteur = auteur.noauteur 
                                WHERE livre.nolivre = :nolivre";
                        
                        $stmt = $connexion->prepare($sql);
                        $stmt->bindValue(":nolivre", $nolivre);
                        $stmt->execute();
                        
                        $livre = $stmt->fetch(PDO::FETCH_OBJ);
                        
                        if ($livre) {
                            echo "<div class='card'>";
                            echo "<div class='row g-0'>";
                            
                            // Colonne pour l'image
                            echo "<div class='col-md-4'>";
                            if ($livre->photo) {
                                echo "<img src='covers/$livre->photo' class='img-fluid rounded-start' alt='$livre->titre'>";
                            } else {
                                echo "<img src='covers/default.jpg' class='img-fluid rounded-start' alt='Pas de couverture'>";
                            }
                            echo "</div>";
                            
                            // Colonne pour les détails
                            echo "<div class='col-md-8'>";
                            echo "<div class='card-body'>";
                            echo "<h2 class='card-title'>$livre->titre</h2>";
                            echo "<h5 class='card-subtitle mb-2 text-muted'>$livre->nom $livre->prenom</h5>";
                            
                            if ($livre->detail) {
                                echo "<p class='card-text mt-3'>$livre->detail</p>";
                            }
                            if ($_SESSION && isset($_SESSION["inscription_completee"])) {
                                echo "<p class='card-text'><strong>Disponible pour emprunt</strong></p>";
                            } else {
                                echo "<p class='card-text'><em>Connectez-vous pour emprunter ce livre</em></p>";
                            }    
                            // BOUTON emprunter
                            echo "<div class='mt-4'>";
                            echo "<form method='post' action='panier.php'>";
                            echo "<input type='hidden' name='titre' value='$livre->titre'>";
                            echo "<input type='hidden' name='auteur' value='$livre->prenom $livre->nom'>";
                            echo "<button type='submit' name='ajouter' class='btn btn-primary'>📚 emprunter</button>";
                            echo "</form>";
                            echo "</div>";
                            
                            echo "</div>";
                            echo "</div>";
                            
                            echo "</div>";
                            echo "</div>";
                        } else {
                            echo "<div class='alert alert-warning'>Livre introuvable</div>";
                        }
                    } else {
                        echo "<div class='alert alert-warning'>Aucun livre sélectionné</div>";
                    }
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
</body>
</html>