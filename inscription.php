<?php
// Traiter la connexion
if (isset($_POST["btn"])){
    $Mail = $_POST["mail"];
    $Mdp = $_POST["Mdp"];

    require_once("connexion.php");

    $stmt = $connexion->prepare("SELECT * from utilisateur where mel = :mail and motdepasse = :Mdp");
    $stmt->bindValue(':mail', $Mail, PDO::PARAM_STR);
    $stmt->bindValue(':Mdp', $Mdp, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();
    $enregistrement = $stmt->fetch();

    if ($enregistrement) {
        $_SESSION['mel'] = $Mail;
        $_SESSION['prenom'] = $enregistrement->prenom;
        $_SESSION['nom'] = $enregistrement->nom;
        $_SESSION['adresse'] = $enregistrement->adresse;
        $_SESSION['ville'] = $enregistrement->ville;
        $_SESSION['codepostal'] = $enregistrement->codepostal;
        $_SESSION['profil'] = $enregistrement->profil;
        $_SESSION['inscription_completee'] = true;
        
        // Redirection META au lieu de header()
        echo '<meta http-equiv="refresh" content="0;url=index.php">';
        exit();
    }
}

// Traiter la déconnexion
if (isset($_POST['deco'])) {
    session_unset();
    session_destroy();
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

// AFFICHAGE
if (isset($_SESSION["mel"])){
    echo '<div class="card p-3 mt-3">';
    echo '<h5>Bonjour</h5>';
    echo '<h6>' . $_SESSION['prenom'] . " " . $_SESSION['nom'] . '</h6>';
    echo '<p class="mb-1">' . $_SESSION['adresse'] . '</p>';
    echo '<p>' . $_SESSION['codepostal'] . " " . $_SESSION['ville'] . '</p>';
    echo '<form method="post">
            <button type="submit" name="deco" class="btn btn-danger w-100">Déconnexion</button>
          </form>';
    echo '</div>';
} else {
    echo '<div class="card p-3 mt-3">
    <h3>CONNEXION</h3>
    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">Identifiant</label>
            <input type="text" name="mail" class="form-control" required/>
        </div>
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="Mdp" class="form-control" required/>
        </div>
        <button type="submit" name="btn" class="btn couleurVert w-100">Se Connecter</button>
    </form>
    </div>';
}
?>