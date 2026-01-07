<!DOCTYPE html>
<html lang="fr">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <meta charset="UTF-8">
        <title>Bibliodrive</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Bibliodrive</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="panier.php">Panier</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="emprunt.php">Mes emprunts</a>
                        </li>
                    </ul>
                    <form class="d-flex" action="recherchelivres.php" method="GET">
                        <input class="form-control me-2" type="text" placeholder="Entrer le nom de l'auteur" name="Auteur" required>
                        <button class="btn btn-light couleurVert" type="submit">Rechercher</button>
                    </form>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col text-end mt-3">
                    <img src="moulinssart2.jpg" class="rounded" alt="Château de Moulinsart" width="200" height="145">
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row">
                <!-- le carrousel -->
                <div class="col-sm-9">
                    <?php require_once('caroussel.php'); ?>
                </div>
                
                <!-- Colonne de droite : infos utilisateur -->
                <div class="col-sm-3">    
                    <?php if (isset($_SESSION["inscription_completee"])): ?>
                        <div class="card p-3 mt-3">
                            <h5>Bonjour</h5>
                            <h6><?= $_SESSION['prenom'] . " " . $_SESSION['nom'] ?></h6>
                            <p class="mb-1"><?= $_SESSION['adresse'] ?></p>
                            <p><?= $_SESSION['codepostal'] . " " . $_SESSION['ville'] ?></p>
                            <form method="post">
                                <button class="btn btn-danger w-100" name="deco" type="submit">Déconnexion</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <?php include('inscription.php'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div> 
    </body>
</html>