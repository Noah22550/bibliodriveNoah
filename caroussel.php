<?php
require_once('connexion.php');

$requete = $connexion->prepare("SELECT * FROM livre ORDER BY dateajout DESC LIMIT 3");
$requete->execute();
$livres = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carrousel - Derniers Livres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Nos derniers ajouts</h2>
    
    <div id="carouselLivres" class="carousel slide" data-bs-ride="carousel">
        
        <!-- Indicateurs -->
        <div class="carousel-indicators">
            <?php foreach($livres as $i => $livre): ?>
                <button data-bs-target="#carouselLivres" data-bs-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></button>
            <?php endforeach; ?>
        </div>
        
        <!-- Images -->
        <div class="carousel-inner">
            <?php foreach($livres as $i => $livre): ?>
                <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                    <img src="covers/<?= $livre['photo'] ?>" class="d-block mx-auto" style="max-height: 450px; width: auto;" alt="<?= $livre['titre'] ?>">
                    <div class="carousel-caption bg-dark bg-opacity-50 rounded" style="bottom: 10px; left: 50%; transform: translateX(-50%); width: auto; padding: 10px 20px;">
                        <h5><?= $livre['titre'] ?></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Boutons -->
        <button class="carousel-control-prev" data-bs-target="#carouselLivres" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" data-bs-target="#carouselLivres" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

</body>
</html>