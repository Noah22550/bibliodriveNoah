<!DOCTYPE html>
<html>
<body>
<?php
if (!isset($_POST['btnSeConnecter'])) {
    echo '
    <h3>Connexion</h3>
    <form action="" method="post">
        <h6>Identifiant</h6>
        <input name="mel" type="text" size="30" required>
        <h6>Mot de passe</h6>
        <input name="motdepasse" type="password" size="30" required>
        <input type="submit" name="btnSeConnecter" value="Se connecter">
    </form>';
} else {
    // On se connecte
    require_once 'connexion.php';
    $mel = $_POST['mel'];
    $motdepasse = $_POST['motdepasse'];
    
    $stmt = $connexion->prepare("SELECT * FROM utilisateur WHERE mel=:mel AND motdepasse=:motdepasse");
    $stmt->bindValue(":mel", $mel);
    $stmt->bindValue(":motdepasse", $motdepasse);
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();
    $enregistrement = $stmt->fetch();
    
    if ($enregistrement) {
        // Définir toutes les variables de session
        $_SESSION['mel'] = $enregistrement->mel;
        $_SESSION['nom'] = $enregistrement->nom;
        $_SESSION['prenom'] = $enregistrement->prenom;
        $_SESSION['adresse'] = $enregistrement->adresse;
        $_SESSION['codepostal'] = $enregistrement->codepostal;
        $_SESSION['ville'] = $enregistrement->ville;
        $_SESSION['inscription_completee'] = true; // AJOUTER CETTE LIGNE
        
        echo 'Bonjour ' .'<br>' . $_SESSION['prenom'] . ' ' . $_SESSION['nom'] . '<br>';
        echo $_SESSION['adresse'] . '<br>';
        echo $_SESSION['codepostal'] . ' ' . $_SESSION['ville'] . '<br>';
        
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
            header('Location: recherchelivres.php'); // Rediriger après déconnexion
            exit();
        }
    } else {
        echo '
        <h3>Connexion</h3>
        <form action="" method="post">
            <h6>Identifiant</h6>
            <input name="mel" type="text" size="30" required>
            <h6>Mot de passe</h6>
            <input name="motdepasse" type="password" size="30" required>
            <input type="submit" name="btnSeConnecter" value="Se connecter">
        </form>';
        echo "<p class='incorrect'>Identifiant ou mot de passe incorrect</p>";
    }
}
?>
</body>
</html>