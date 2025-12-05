<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>BLIBLIODRIVE</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- barre de recherche -->
            <?php include('recherche.php') ?>
        </div>
    </div>
    <div class="row">
        <div class="col text-end">
            <img src="moulinssart2.jpg" class="rounded" alt="Cinque Terre" width="200" height="145">
        </div>
    </div>
    <div class="row">
        <div class="row">
            <!-- le carrousel -->
            <div class="col-sm-9">
                <?php include 'caroussel.php'; ?> 
                <!-- résultat de la recherche / pages d'admin (ajout d'un livre)-->
            </div>

            <!-- formulaire d'inscription à importer -->
            <div class="col-sm-3">
                <?php include 'inscription.php'; ?>
                formulaire de connexion / profil connecté (include)
            </div>
        </div>
    </div>
</body>
</html>