<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddinformation";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Requête pour récupérer les 3 derniers livres
$sql = "SELECT * FROM livres ORDER BY date_sortie DESC LIMIT 3";
$result = $conn->query($sql);
?>

<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrousel Bibliothèque</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 1rem;
            border-radius: 10px;
        }
        .carousel-item img {
            max-height: 500px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h2 class="text-center mb-4">Dernières sorties de la bibliothèque</h2>
    <div id="carrouselLivres" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $active = "active"; // pour le premier élément
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="carousel-item '.$active.'">';
                    echo '<img src="'.$row['image'].'" class="d-block w-100" alt="'.$row['titre'].'">';
                    echo '<div class="carousel-caption d-none d-md-block">';
                    echo '<h5>'.$row['titre'].'</h5>';
                    echo '<p>Auteur : '.$row['auteur'].' | Sortie : '.$row['date_sortie'].'</p>';
                    echo '</div>';
                    echo '</div>';
                    $active = ""; // après le premier élément
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

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
