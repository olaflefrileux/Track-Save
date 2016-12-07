<?php
// Connexion à la BDD site :

$pdo = new PDO('mysql:host=212.47.252.97;port=3306;dbname=track_save', 'root', 'b395dd635afe9f2854bf64dc4269dfeb', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
// création ou ouverture d'une session:

session_start();

// Définition du chemin du site
define('RACINE_SITE', '/PIS2/'); // chemin du site sans la mention localhost

// Inclusion du fichier fonction:
require_once('fonction.inc.php');
