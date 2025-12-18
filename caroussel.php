<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrousel - Derniers Livres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
require_once('connexion.php');
// RÉCUPÉRATION DES LIVRES DEPUIS LA BASE DE DONNÉES
try {
    $requete = $connexion->prepare("SELECT * FROM livre ORDER BY dateajout DESC LIMIT 3");
    $requete->execute();
    $livres = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    // Vérifier si on a des livres
    if (empty($livres)) {
        echo '<div class="container mt-5"><div class="alert alert-warning">Aucun livre trouvé dans la base de données.</div></div>';
        die();
    }
} catch (Exception $e) {
    echo '<div class="container mt-5"><div class="alert alert-danger">Erreur : ' . $e->getMessage() . '</div></div>';
    die();
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Nos derniers ajouts</h2>
    
    <!-- Conteneur principal du carrousel -->
    <div id="carouselLivres" class="carousel slide" data-bs-ride="carousel">
        
        <!-- INDICATEURS (les petits points en bas) -->
        <div class="carousel-indicators">
            <?php foreach($livres as $index => $livre): ?>
                <button type="button" 
                        data-bs-target="#carouselLivres" 
                        data-bs-slide-to="<?= $index ?>" 
                        class="<?= $index === 0 ? 'active' : '' ?>" 
                        aria-current="<?= $index === 0 ? 'true' : 'false' ?>"
                        aria-label="Slide <?= $index + 1 ?>">
                </button>
            <?php endforeach; ?>
        </div>
        <!-- SLIDES (les images qui défilent) -->
        <div class="carousel-inner">
            <?php foreach($livres as $index => $livre): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    
                    <!-- Image du livre -->
                    <img src="covers/<?= htmlspecialchars($livre['photo']) ?>" 
                         class="d-block mx-auto" 
                         style="max-height: 500px; width: auto;"
                         alt="<?= htmlspecialchars($livre['titre']) ?>">
                    
                    <!-- Légende sous l'image -->
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                        <h5><?= htmlspecialchars($livre['titre']) ?></h5>
                        <?php if(isset($livre['auteur'])): ?>
                            <p><?= htmlspecialchars($livre['auteur']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- BOUTONS DE NAVIGATION -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselLivres" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselLivres" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
        
    </div>
</div>
</body>
</html>