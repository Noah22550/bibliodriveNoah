<!DOCTYPE html>
<html>
<body>
<?php
if (!isset($_POST['btnSeConnecter'])) { /* L'entrée btnSeConnecter est vide = le formulaire n'a pas été submit=posté, on affiche le formulaire */
    echo '
    <h3> connexion </h3>
    <form action="" method = "post" ">
        <h6> iddentifiant </h6>
        <input name="mel" type="text" size ="30"">
       <h6> Mot de passe </h6>
        <input name="motdepasse" type="text" size ="30"">
        <input type="submit" name="btnSeConnecter"  value="Se connecter">
    </form>';
} else
/* L'utilisateur a cliqué sur Se connecter, l'entrée btnSeConnecter <> vide, on traite le formulaire */
{
// On se connecte
    require_once 'connexion.php';
    $mel = $_POST['mel'];
    $motdepasse = $_POST['motdepasse'];
    $stmt = $connexion->prepare("SELECT * FROM utilisateur where mel=:mel AND motdepasse=:motdepasse");
    $stmt->bindValue(":mel", $mel); // pas de troisième paramètre STR par défaut
    $stmt->bindValue(":motdepasse", $motdepasse); // idem
    $stmt->setFetchMode(PDO::FETCH_OBJ);
// Les résultats retournés par la requête seront traités en 'mode' objet
    $stmt->execute();
    $enregistrement = $stmt->fetch(); // boucle while inutile
    if ($enregistrement) {
      $_SESSION['mel'] = $enregistrement -> mel;
      $_SESSION['nom'] = $enregistrement -> nom;
      $_SESSION['prenom'] = $enregistrement -> prenom;
      $_SESSION['adresse'] = $enregistrement -> adresse;
      $_SESSION['codepostal'] = $enregistrement -> codepostal;
      $_SESSION['ville'] = $enregistrement -> ville;
        echo 'Bonjour ' . $_SESSION['prenom'] . ' ' . $_SESSION['nom'] . '</br>';
        echo $_SESSION['adresse'] . '</br>';
        echo $_SESSION['codepostal'] . ' ' . $_SESSION['ville'] . '</br>';
        // Formulaire de déconnexion
        if (!isset($_POST['deco'])) { ?>
          <form method="post">
              <div class="input-group-btn text-center">
                  <button class="btn btn-danger" name="deco" type="submit">Déconnexion</button>
              </div>
          </form>
          <?php } else {
                session_unset();         
                session_destroy();
                exit();
               }
               ob_end_flush();
    } else { // La requête n'a pas retournée de résultat, on a pas trouvé de ligne correspondant au mel et mot de passe
        echo  '
    <h3> connexion </h3>
    <form action="" method = "post" ">
        <h6> iddentifiant </h6>
        <input name="mel" type="text" size ="30"">
       <h6> Mot de passe </h6>
        <input name="motdepasse" type="text" size ="30"">
        <input type="submit" name="btnSeConnecter"  value="Se connecter">
    </form>';
        echo "<p style='color:red'> Identifiant ou mot de passe incorrect </p>";
    }
}
?>
</body>
</html>