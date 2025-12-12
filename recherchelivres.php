<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recherchelivre</title>
</head>
<body>
    <?php
        include 'entete.php';
        require_once 'connexion.php';
    ?>
    <?php
    $stmt = $connexion->prepare("SELECT photo FROM livre ORDER BY RAND() LIMIT 3");
    $stmt->bindValue(":photo", $photo);
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();
    echo '<div id="demo" class="carousel slide" data-bs-ride="carousel">';
    echo '<div class="carousel-inner">';
    $x = 0;
    while ($enregistement = $stmt->fetch()) {
        if ($x == 0) {
            echo '<div class="carousel-item active"><img src="covers/'.$enregistement->photo.'" alt="photo carousel" class="d-block mx-auto" style="width:25%"></div>';
            $x = 1;
        } else {
            echo '<div class="carousel-item"><img src="covers/'.$enregistement->photo.'" alt="photo carousel" class="d-block mx-auto" style="width:25%"></div>';
        }
    }
    echo '</div>';  // Fermeture du carousel-inner
    echo '<button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">';
    echo '<span class="carousel-control-prev-icon"></span>';
    echo '</button>';
    echo '<button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">';
    echo '<span class="carousel-control-next-icon"></span>';
    echo '</button>';
    echo '</div>';
    ?>

</body>
</html>


