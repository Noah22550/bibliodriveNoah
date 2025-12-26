<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Mes Emprunts</title>
</head>
<body>
    <?php 
    require_once('config.php');
    
    // Vérifier que l'utilisateur est connecté
    if (!isset($_SESSION["inscription_completee"])) {
        header("Location: recherchelivres.php");
        exit;
    }
    
    // ========== RENDRE UN LIVRE ==========
    if (isset($_GET['rendre'])) {
        $nolivre = $_GET['rendre'];
        
        // Mettre à jour la date de retour
        $sql = "UPDATE emprunter 
                SET dateretour = NOW() 
                WHERE mel = :mel 
                AND nolivre = :nolivre 
                AND dateretour IS NULL";
        
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(":mel", $_SESSION['mel']);
        $stmt->bindValue(":nolivre", $nolivre);
        $stmt->execute();
        
        echo "<div class='container mt-4'>";
        echo "<div class='alert alert-success'>✅ Livre rendu avec succès !</div>";
        echo "</div>";
    }
    
    include('entete.php'); 
    ?>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-9">
                <h2>Mes emprunts en cours</h2>
                
                <?php
                // Récupérer les emprunts en cours (pas encore rendus)
                $sql = "SELECT livre.nolivre, livre.titre, auteur.nom, auteur.prenom, emprunter.dateemprunt 
                        FROM emprunter 
                        INNER JOIN livre ON emprunter.nolivre = livre.nolivre 
                        INNER JOIN auteur ON livre.noauteur = auteur.noauteur 
                        WHERE emprunter.mel = :mel 
                        AND emprunter.dateretour IS NULL
                        ORDER BY emprunter.dateemprunt DESC";
                
                $stmt = $connexion->prepare($sql);
                $stmt->bindValue(":mel", $_SESSION['mel']);
                $stmt->execute();
                
                $emprunts = $stmt->fetchAll(PDO::FETCH_OBJ);
                
                // Si l'utilisateur a des emprunts en cours
                if (count($emprunts) > 0) {
                    
                    echo "<table class='table table-striped'>";
                    echo "<tr>";
                    echo "<th>Titre</th>";
                    echo "<th>Auteur</th>";
                    echo "<th>Date d'emprunt</th>";
                    echo "<th></th>";
                    echo "</tr>";
                    
                    // Afficher chaque emprunt
                    foreach ($emprunts as $emprunt) {
                        echo "<tr>";
                        echo "<td>" . $emprunt->titre . "</td>";
                        echo "<td>" . $emprunt->prenom . " " . $emprunt->nom . "</td>";
                        echo "<td>" . date('d/m/Y', strtotime($emprunt->dateemprunt)) . "</td>";
                        echo "<td><a href='mesemprunts.php?rendre=" . $emprunt->nolivre . "' class='btn btn-warning btn-sm'>Rendre</a></td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                    
                } else {
                    // Aucun emprunt en cours
                    echo "<div class='alert alert-info'>Vous n'avez aucun emprunt en cours.</div>";
                }
                ?>
                
                <a href='recherchelivres.php' class='btn btn-primary mt-3'>Retour à la recherche</a>
            </div>
            
            <div class="col-sm-3">
                <?php
                // Afficher les informations de l'utilisateur
                if (isset($_SESSION["inscription_completee"])) {
                    echo "<h5>Bonjour<br/>" . $_SESSION['prenom'] . " " . $_SESSION['nom'] . "</h5>";
                    echo "<p>" . $_SESSION['adresse'] . "</p>";
                    echo "<p>" . $_SESSION['codepostal'] . " " . $_SESSION['ville'] . "</p>";
                    echo '<form method="post">
                            <div class="input-group-btn text-center">
                                <button class="btn btn-danger" name="deco" type="submit">Déconnexion</button>
                            </div>
                        </form>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>