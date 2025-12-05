<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Recherche par auteur</title>
</head>
<body>
<div class="container mt-4">
    <form method="GET" class="d-flex justify-content-center mb-4">
        <input class="form-control me-2" type="search" name="query" placeholder="Rechercher un auteur" style="max-width: 500px;">
        <button class="btn btn-dark" type="submit">Rechercher</button>
    </form>

<?php
require_once('connexion.php'); // fichier de connexion

// On ne fait la recherche que si la barre n'est pas vide
if (!empty($_GET['query'])) {
    $q = "%" . $_GET['query'] . "%";

    $sql = "SELECT livre.titre, livre.photo, auteur.nom, auteur.prenom 
            FROM livre 
            JOIN auteur ON livre.noauteur = auteur.noauteur 
            WHERE auteur.nom LIKE :q OR auteur.prenom LIKE :q";

    $stmt = $connexion->prepare($sql);
    $stmt->execute([':q' => $q]);
    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($livres) {
        echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
        foreach ($livres as $l) {
            echo '<div class="col">';
            echo '<div class="card h-100">';
            if ($l['photo']) echo '<img src="covers/'.$l['photo'].'" class="card-img-top" alt="'.htmlspecialchars($l['titre']).'">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.htmlspecialchars($l['titre']).'</h5>';
            echo '<p class="card-text">'.htmlspecialchars($l['prenom'].' '.$l['nom']).'</p>';
            echo '</div></div></div>';
        }
        echo '</div>';
    } else {
        echo '<p class="text-center">Aucun livre trouvé pour cet auteur.</p>';
    }
}
?>
</div>
</body>
</html>