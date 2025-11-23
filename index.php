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
      <!--barre de recherche !-->
			<div class="col-sm-9">
          <div class="container mt-4">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Rechercher un livre qui vous plaît">
              <button class="btn btn-outline-secondary" type="button"placeholder="Rechercher">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </div>
			</div>
      <!--photo de moulinssart !-->
			<div class="col-sm-3">
				<img src="moulinssart2.jpg" class="rounded" alt="Cinque Terre" width="300" height="245" >
			</div>
		</div>
		<div class="row">
      <!--le carrousel !-->
		   <div class="col-sm-9">
                <div id="monCarrousel" class="carousel slide" data-bs-ride="carousel" style="max-width: 260px;"style="max-height: 180px;">

          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="covers/1984.jpg" alt="image 1"class="d-block w-100" >
            </div>
            <div class="carousel-item">
              <img src="covers/Crime_et_Chatiment.jpg" class="d-block w-100" alt="image 2">
            </div>
            <div class="carousel-item">
              <img src="covers/Emma.jpg" class="d-block w-100" alt="image 3">
            </div>
          </div>

          <!-- Boutons précédent / suivant -->
          <button class="carousel-control-prev" type="button" data-bs-target="#monCarrousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>

          <button class="carousel-control-next" type="button" data-bs-target="#monCarrousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>

        </div>
					carroussel / résultat de la recherche / pages d'admin (ajout d'un livre)
			</div>
            <!--le formulaire d'inscription à importer !-->
			<div class="col-sm-3">
					formulaire de connexion / profil connecté (include)
			</div>
		</div>
	</div>
</body>
</html>