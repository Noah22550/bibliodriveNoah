
<!DOCTYPE html>
<html lang="fr">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>Recherche de livre dans la bibliodrive</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <?php
                    include('entete.php');
                    require_once('connexion.php');
                    
                    // Vérifie si une recherche a été effectuée
                    if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                        $search = trim($_GET['search']);

                        try {
                            // Préparation de la requête pour rechercher les auteurs
                            $stmt = $connexion->prepare("SELECT DISTINCT auteur.noauteur, auteur.nom, auteur.prenom 
                                                          FROM auteur 
                                                          WHERE auteur.nom LIKE :search 
                                                          OR auteur.prenom LIKE :search 
                                                          ORDER BY auteur.nom, auteur.prenom");
                            $searchTerm = '%' . $search . '%';
                            $stmt->bindValue(":search", $searchTerm);
                            $stmt->setFetchMode(PDO::FETCH_OBJ);
                            $stmt->execute();

                            $auteurs = $stmt->fetchAll();

                            if (count($auteurs) > 0) {
                                echo "<h2>Résultats de recherche pour : " . htmlspecialchars($search) . "</h2>";
                                echo "<p class='text-muted'>" . count($auteurs) . " auteur(s) trouvé(s)</p>";

                                foreach ($auteurs as $auteur) {
                                    echo "<div class='card mb-3'>";
                                    echo "<div class='card-body'>";
                                    echo "<h5 class='card-title'>" . htmlspecialchars($auteur->nom) . " " . htmlspecialchars($auteur->prenom) . "</h5>";
                                    
                                    // Récupérer les livres de cet auteur
                                    $stmtLivres = $connexion->prepare("SELECT nolivre, titre FROM livre 
                                                                        WHERE noauteur = :noauteur 
                                                                        ORDER BY titre");
                                    $stmtLivres->bindValue(":noauteur", $auteur->noauteur);
                                    $stmtLivres->setFetchMode(PDO::FETCH_OBJ);
                                    $stmtLivres->execute();
                                    
                                    $livres = $stmtLivres->fetchAll();
                                    
                                    if (count($livres) > 0) {
                                        echo "<p class='card-text'><strong>Livres :</strong></p>";
                                        echo "<ul class='list-group list-group-flush'>";
                                        foreach ($livres as $livre) {
                                            echo "<li class='list-group-item'>";
                                            echo "<a href='detail_livre.php?nolivre=" . $livre->nolivre . "'>" . htmlspecialchars($livre->titre) . "</a>";
                                            echo "</li>";
                                        }
                                        echo "</ul>";
                                    } else {
                                        echo "<p class='text-muted'>Aucun livre disponible pour cet auteur.</p>";
                                    }
                                    
                                    echo "</div>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<div class='alert alert-warning' role='alert'>";
                                echo "Aucun auteur trouvé pour : <strong>" . htmlspecialchars($search) . "</strong>";
                                echo "</div>";
                            }

                        } catch (PDOException $e) {
                            echo "<div class='alert alert-danger' role='alert'>";
                            echo "Erreur lors de la recherche : " . $e->getMessage();
                            echo "</div>";
                        }
                        
                    } elseif (isset($_GET['auteur'])) {
                        // Code original pour afficher les livres d'un auteur spécifique
                        $auteur = $_GET['auteur'];

                        $stmt = $connexion->prepare("SELECT nolivre, titre FROM livre 
                                                      INNER JOIN auteur ON livre.noauteur = auteur.noauteur 
                                                      WHERE auteur.nom = :nom 
                                                      ORDER BY titre");
                        $stmt->bindValue(":nom", $auteur);
                        $stmt->setFetchMode(PDO::FETCH_OBJ);
                        $stmt->execute();

                        echo "<h1>Livres de l'auteur : " . htmlspecialchars($auteur) . "</h1>";

                        while ($livre = $stmt->fetch()) {
                            echo "<p><a href='detail_livre.php?nolivre=" . $livre->nolivre . "'>" . htmlspecialchars($livre->titre) . "</a></p>";
                        }
                        
                    } else {
                        echo "<div class='alert alert-info' role='alert'>";
                        echo "Utilisez la barre de recherche pour trouver un auteur et ses livres.";
                        echo "</div>";
                    }
                ?>
            </div>
            <div class="col-sm-3">
                <?php  
                    require_once('inscription.php');
                ?>
            </div>
        </div>
    </div>
</body>
</html>