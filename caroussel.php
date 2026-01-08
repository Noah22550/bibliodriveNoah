<?php
require_once('connexion.php');
$requete = $connexion->prepare("SELECT * FROM livre ORDER BY dateajout DESC LIMIT 3");
$requete->execute();
$livres = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2 class="text-center mb-3">Nos derniers ajouts</h2>
    <div id="carouselLivres" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach($livres as $i => $livre): ?>
                <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                    <img src="covers/<?= $livre['photo'] ?>" class="d-block mx-auto" style="max-height: 350px;" alt="<?= $livre['titre'] ?>">
                    <div class="carousel-caption"><h5><?= $livre['titre'] ?></h5></div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" data-bs-target="#carouselLivres" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
        <button class="carousel-control-next" data-bs-target="#carouselLivres" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
    </div>
</div>