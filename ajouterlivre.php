<?php
require_once 'config.php';
$stmt = $connexion->prepare("SELECT noauteur, nom, prenom FROM auteur ORDER BY nom, prenom");
$stmt->execute();
?>
<!DOCTYPE html>
<html> 
<div class="container mt-4">
    <h2>Ajouter un nouveau livre</h2>
    <form method="post">
        <div class="mb-3">
            <label for="noauteur" class="form-label">Auteur:</label>
            <select name="noauteur" class="form-control" id="noauteur" required>
                <?php while ($auteur = $stmt->fetch(PDO::FETCH_OBJ)): ?>
                    <option value="<?= $auteur->noauteur ?>"><?= $auteur->prenom . ' ' . $auteur->nom ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="titre" class="form-label">Titre:</label>
            <input type="text" name="titre" class="form-control" id="titre" required>
        </div>
        <div class="mb-3">
            <label for="isbn13" class="form-label">ISBN13:</label>
            <input type="text" name="isbn13" class="form-control" id="isbn13" required>
        </div>
        <div class="mb-3">
            <label for="anneeparution" class="form-label">Année de parution:</label>
            <input type="text" name="anneeparution" class="form-control" id="anneeparution" required>
        </div>
        <div class="mb-3">
            <label for="detail" class="form-label">Résumé:</label>
            <textarea name="detail" class="form-control" id="detail" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Image:</label>
            <input type="text" name="photo" class="form-control" id="photo" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter livre</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>