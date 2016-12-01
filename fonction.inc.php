<?php

// Vérifier si un internaute est connecté :

function Is_co() {
	return isset($_SESSION['membre']);	
}

// Vérifier si l'internaute est admin et connecté :
function Is_coAdm() {
	return (isset($_SESSION['membre']) && $_SESSION['membre']['statut'] == 1);
}

// Fonction qui execute les requêtes en base : 
function executeRequete($req,$param = array()) {

	if (!empty($param)) {	// si il y a bien un array en argument
		foreach ($param as $indice => $valeur) {
			$param[$indice] = htmlspecialchars($valeur);
		}
	}

	global $pdo;	// permet d'accéder à la variable $pdo qui est definie dans l'espace globale (cf init.inc.php)

	$r = $pdo->prepare($req);

	$r->execute($param);
	// Si il y a une erreur dans la requête SQL on l'affiche
	if (!empty($r->errorInfo()[2])) {
		die('Erreur sur la requête SQL. <br> Message : ' . $r->errorInfo()[2] . '<br> Code de la requête : ' . $req);
	}
	return $r;
}