<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrousel - Derniers Livres</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers la feuille de style CSS externe -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
// 1. PARAMÈTRES DE CONNEXION À LA BASE DE DONNÉES
$host = '127.0.0.1';              // Adresse du serveur MySQL (localhost)
$dbname = 'bibliodrive';           // Nom de la base de données
$username = 'root';                //  nom d'utilisateur MySQL
$password = '';                    

// 2. CONNEXION À LA BASE DE DONNÉES
try {
    // Création de l'objet PDO pour se connecter à MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Active le mode d'erreur pour voir les problèmes de connexion
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 3. REQUÊTE SQL : Récupère les 3 derniers livres ajoutés
    $query = "SELECT l.nolivre, l.titre, l.photo, l.detail, l.anneeparution, 
                     a.nom, a.prenom
              FROM livre l
              INNER JOIN auteur a ON l.noauteur = a.noauteur
              ORDER BY l.dateajout DESC
              LIMIT 3";
    
    // 4. EXÉCUTION DE LA REQUÊTE
    $stmt = $pdo->query($query);
    
    // 5. RÉCUPÉRATION DES RÉSULTATS dans un tableau
    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // En cas d'erreur, affiche le message et arrête le script
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<div class="container mt-2">
    <h2 class="text-center mb-3">Nos derniers ajouts</h2>
    
    <!-- Conteneur principal du carrousel -->
    <div id="carouselLivres" class="carousel slide">
        
        <!-- INDICATEURS (les petits points en bas) -->
        <div class="carousel-indicators">
            <?php 
            // Boucle pour créer un indicateur par livre
            foreach($livres as $index => $livre): 
            ?>
                <button type="button" 
                        data-bs-target="#carouselLivres" 
                        data-bs-slide-to="<?= $index ?>" 
                        class="<?= $index === 0 ? 'active' : '' ?>" 
                        aria-label="Slide <?= $index + 1 ?>">
                </button>
            <?php endforeach; ?>
        </div>
        
        <!-- SLIDES (les images qui défilent) -->
        <div class="carousel-inner">
            <?php 
            // Boucle pour créer une slide par livre
            foreach($livres as $index => $livre): 
            ?>
                <!-- Chaque slide : la première (index 0) a la classe "active" -->
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    
                    <!-- Image du livre -->
                    <img src="covers/<?= htmlspecialchars($livre['photo']) ?>" 
                         class="d-block w-100" 
                         alt="<?= htmlspecialchars($livre['titre']) ?>">
                    
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- BOUTONS DE NAVIGATION (flèches gauche/droite) -->
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
