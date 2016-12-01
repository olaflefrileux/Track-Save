<?php
// Connexion à la BDD site :

$pdo = new PDO('mysql:host=localhost; dbname=save_track', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// création ou ouverture d'une session:

session_start();

// Définition du chemin du site
define('RACINE_SITE', '/PIS2/'); // chemin du site sans la mention localhost

// Inclusion du fichier fonction:
require_once('fonction.inc.php');