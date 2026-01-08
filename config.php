<?php
// Gestion des sessions
session_start();
require_once('connexion.php');
// Afficher l'en-tête selon le profil
if (isset($_SESSION['profil']) && $_SESSION['profil'] === 'admin') {
    include 'enteteadmin.php';
} else {
    include 'entete.php';
}
?>
