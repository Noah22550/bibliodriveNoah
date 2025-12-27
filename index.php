<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>BLIBLIODRIVE</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
           <?php require_once('config.php') ?>
        </div>
        <div class="row">
            <!-- le carrousel -->
            <div class="col-sm-9">
             <?php require_once('caroussel.php'); ?>
            </div>
            <!-- formulaire d'inscription à importer -->
            <div class="col-sm-3">    
                <?php include ('inscription.php'); ?>
            </div>
        </div>
    </div> 
</body>
</html>