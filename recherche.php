<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Recherche par auteur</title>
</head>
<body>
<div class="container mt-4">
    <!-- Barre de recherche -->
    <form method="GET" class="d-flex justify-content-center mb-4">
        <input class="form-control me-2" 
               type="search" 
               name="query" 
               placeholder="Rechercher un auteur" 
               style="max-width: 500px;"
               value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
        <button class="btn btn-dark" type="submit">Rechercher</button>
    </form>
<?php
// Connexion à la base de données
require_once('connexion.php');
?>
    <?php
    // On ne fait la recherche que si la barre n'est pas vide
    if (!empty($_GET['query'])) {
        // Préparation de la requête avec LIKE pour recherche partielle
        $q = "%" . $_GET['query'] . "%";

        // Requête SQL préparée pour éviter les injections SQL
        $sql = "SELECT livre.titre, livre.photo, auteur.nom, auteur.prenom 
                FROM livre 
                JOIN auteur ON livre.noauteur = auteur.noauteur 
                WHERE auteur.nom LIKE :q OR auteur.prenom LIKE :q";

        // Préparation et exécution de la requête
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':q', $q, PDO::PARAM_STR);
        $stmt->execute();
        
        // Récupération de tous les résultats
        $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Affichage des résultats
        if (count($livres) > 0) {
            echo "<h3 class='mb-3'>Résultats de recherche pour : " . htmlspecialchars($_GET['query']) . "</h3>";
            echo "<p class='text-muted'>" . count($livres) . " livre(s) trouvé(s)</p>";

            // Boucle pour afficher chaque livre trouvé
            foreach ($livres as $livre) {
                ?>
                <div class="livre-card">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <?php if (!empty($livre['covers'])): ?>
                                <img src="<?php echo htmlspecialchars($livre['covers']); ?>" 
                                     alt="Couverture du livre" 
                                     class="img-custom">
                            <?php else: ?>
                                <div class="img-custom d-flex align-items-center justify-content-center bg-secondary text-white">
                                    Pas d'image
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-10">
                            <h5><?php echo htmlspecialchars($livre['titre']); ?></h5>
                            <p class="text-muted mb-0">
                                Auteur : <?php echo htmlspecialchars($livre['prenom'] . ' ' . $livre['nom']); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            // Aucun résultat trouvé
            echo "<div class='alert alert-warning text-center' role='alert'>";
            echo "Aucun livre trouvé pour l'auteur : " . htmlspecialchars($_GET['query']);
            echo "</div>";
        }
    } 
    
    ?>
</div>
</body>
</html>