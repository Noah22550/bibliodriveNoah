<?php 
    include 'config.php';
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
 </head>
    <body>  
        <?php 
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['mel'])) {
            echo "<div class='container mt-4'><div class='alert alert-warning'>⚠️ Vous devez être connecté pour accéder au panier.</div></div>";
            include('inscription.php');
            exit();
        }

        // Ajouter un livre
        if (isset($_GET['emprunter'])) {
            $stmt = $connexion->prepare("SELECT livre.titre, auteur.nom, auteur.prenom 
                                        FROM livre 
                                        INNER JOIN auteur ON livre.noauteur = auteur.noauteur 
                                        WHERE livre.nolivre = :nolivre");
            $stmt->bindValue(":nolivre", $_GET['emprunter']);
            $stmt->execute();
            $livre = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($livre) {
                $_SESSION['panier'][$_GET['emprunter']] = [
                    'titre' => $livre->titre,
                    'auteur' => $livre->prenom . ' ' . $livre->nom
                ];
            }
        }

        // Annuler un livre
        if (isset($_GET['annuler'])) {
            unset($_SESSION['panier'][$_GET['annuler']]);
        }

        // Valider le panier
        if (isset($_GET['valider']) && isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
            $stmt = $connexion->prepare("SELECT COUNT(*) as nb FROM emprunter WHERE mel = :mel AND dateretour IS NULL");
            $stmt->bindValue(":mel", $_SESSION['mel']);
            $stmt->execute();
            $nb_actuel = $stmt->fetch(PDO::FETCH_OBJ)->nb;
            
            $nb_total = $nb_actuel + count($_SESSION['panier']);
            
            if ($nb_total > 5) {
                echo "<div class='container mt-4'><div class='alert alert-danger'>❌ Maximum 5 emprunts ! Vous en avez $nb_actuel, vous voulez en ajouter " . count($_SESSION['panier']) . "</div></div>";
            } else {
                foreach ($_SESSION['panier'] as $nolivre => $infos) {
                    $stmt = $connexion->prepare("INSERT INTO emprunter (mel, nolivre, dateemprunt) VALUES (:mel, :nolivre, NOW())");
                    $stmt->bindValue(":mel", $_SESSION['mel']);
                    $stmt->bindValue(":nolivre", $nolivre);
                    $stmt->execute();
                }
                unset($_SESSION['panier']);
                echo "<div class='container mt-4'><div class='alert alert-success'>✅ Emprunts validés !</div></div>";
            }
        }

        // Compter emprunts
        $stmt = $connexion->prepare("SELECT COUNT(*) as nb FROM emprunter WHERE mel = :mel AND dateretour IS NULL");
        $stmt->bindValue(":mel", $_SESSION['mel']);
        $stmt->execute();
        $nb_emprunts = $stmt->fetch(PDO::FETCH_OBJ)->nb;
        ?>

        <div class="container mt-4">
            <div class="row">
                <div class="col-sm-9">
                    <h2>Mon Panier</h2>
                    <div class='alert alert-info'>📚 Emprunts en cours : <?= $nb_emprunts ?> / 5</div>
                    
                    <?php if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0): ?>
                        <table class='table'>
                            <tr><th>Titre</th><th>Auteur</th><th></th></tr>
                            <?php foreach ($_SESSION['panier'] as $nolivre => $infos): ?>
                                <tr>
                                    <td><?= $infos['titre'] ?></td>
                                    <td><?= $infos['auteur'] ?></td>
                                    <td><a href='panier.php?annuler=<?= $nolivre ?>' class='btn btn-danger btn-sm'>Annuler</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <a href='panier.php?valider' class='btn btn-success'>Valider le panier</a>
                    <?php else: ?>
                        <p>Votre panier est vide</p>
                    <?php endif; ?>
                    
                    <a href='recherchelivres.php' class='btn btn-primary mt-3'>Retour</a>
                </div>
                
                <div class="col-sm-3">
                    <?php if (isset($_SESSION["inscription_completee"])): ?>
                        <h5>Bonjour<br/><?= $_SESSION['prenom'] . " " . $_SESSION['nom'] ?></h5>
                        <p><?= $_SESSION['adresse'] ?></p>
                        <p><?= $_SESSION['codepostal'] . " " . $_SESSION['ville'] ?></p>
                        <form method="post">
                            <button class="btn btn-danger" name="deco" type="submit">Déconnexion</button>
                        </form>
                    <?php else: ?>
                        <?php include('inscription.php'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>