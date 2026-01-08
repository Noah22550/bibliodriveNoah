<?php
require_once('config.php'); // Config inclut déjà l'en-tête
?>

<!-- Juste le contenu spécifique à index.php -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <?php require_once('caroussel.php'); ?>
        </div>
        <div class="col-sm-3">    
            <?php include('inscription.php'); ?>
        </div>
    </div>
</div> 

</body>
</html>