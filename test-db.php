<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$link = mysqli_connect('localhost', 'root', '', 'motanathalie');

if (!$link) {
    die('❌ Erreur MySQL : ' . mysqli_connect_error());
} else {
    echo '✅ Connexion réussie à la base de données.';
}
