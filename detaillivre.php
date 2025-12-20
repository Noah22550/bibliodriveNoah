<?php
session_start();
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
                    require_once('connexion.php');
                    
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
                <?php include('inscription.php'); ?>
            </div>
        </div>
    </div>
</body>
</html>