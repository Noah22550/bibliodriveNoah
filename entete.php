<?php
    require_once('config.php');
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Bibliodrive</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="panier.php">panier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="emprunt.php">mes emprunt</a>
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