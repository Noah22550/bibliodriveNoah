<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - Flow</title>
  <link rel="stylesheet" href="style.css">
  <script src="inscription.js" defer></script>
</head>
<body>
  <section>
  <?php
  if (!isset($_POST['btnSeConnecter'])) { /* L'entrée btnSeConnecter est vide = le formulaire n'a pas été submit=posté, on affiche le formulaire */
    echo '
    <form action="authentification.php" method = "post">
        nom: <input name="nom" type="text" size ="30"">
        code : <input name="code" type="text" size ="30"">
        <input type="submit" name="btnSeConnecter"  value="Se connecter">
    </form>';
} else
/* L'utilisateur a cliqué sur Se connecter, l'entrée btnSeConnecter <> vide, on traite le formulaire */
{
// On se connecte
    require_once 'connexion.php';
    $nom = $_POST['nom'];
    $code = $_POST['code'];
    $stmt = $connexion->prepare("SELECT * FROM agent where nom=:pnom AND code=:pcode");
    $stmt->bindValue(":pnom", $nom); // pas de troisième paramètre STR par défaut
    $stmt->bindValue(":pcode", $code); // idem
    $stmt->setFetchMode(PDO::FETCH_OBJ);
// Les résultats retournés par la requête seront traités en 'mode' objet
    $stmt->execute();
    $enregistrement = $stmt->fetch(); // boucle while inutile
    if ($enregistrement) { // si $enregistrement n'est pas vide = on a trouvé quelque chose -> on est connecté
        echo '<h1>Connexion réussie !</h1>';
        echo 'bienvenido '.$enregistrement->prenom;
    } else { // La requête n'a pas retournée de résultat, on a pas trouvé de ligne correspondant au mel et mot de passe
        echo "Echec à la connexion.";
    }
}
  ?>
</body>
</html>