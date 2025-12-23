<?php
session_start();

// Gérer la déconnexion (valable sur toutes les pages)
if (isset($_POST['deco'])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}

require_once('connexion.php');
?>