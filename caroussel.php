<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="carousel-container">
    <div id="carrouselLivres" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $active = "active";
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="carousel-item '.$active.'">';
                    echo '<img src="'.$row['image'].'" class="d-block w-100" alt="'.$row['titre'].'">';
                    echo '<div class="carousel-caption d-none d-md-block">';
                    echo '<h5>'.$row['titre'].'</h5>';
                    echo '<p>Auteur : '.$row['auteur'].' | Sortie : '.$row['date_sortie'].'</p>';
                    echo '</div>';
                    echo '</div>';
                    $active = "";
                }
            } else {
                echo '<div class="carousel-item active"><div class="d-block w-100 text-center">Aucun livre disponible</div></div>';
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carrouselLivres" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carrouselLivres" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>
</div>

</body>
</html>

