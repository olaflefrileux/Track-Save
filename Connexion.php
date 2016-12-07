<?php

require_once('init.inc.php');
/*--------------------------------------- TRAITEMENT ---------------------------------------  */

// Déconnexion demandée par l'internaute
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
	session_destroy();
}

// Vérification que le membre n'est pas déjà connecté
if (Is_co()) {	
	header('location:gestion_profil.php'); 
	exit();
}

// Connexion
if ($_POST) {	
	$resultat = executeRequete("SELECT * FROM membre WHERE login = :login", array(':login' => $_POST['login']));

	if ($resultat->rowCount() != 0) {
		$membre = $resultat->fetch(PDO::FETCH_ASSOC);
		if ($membre['mdp'] == $_POST['mdp']) {
			$_SESSION['membre'] = $membre['login'];
			$_SESSION['mail'] = $membre['mail'];
			$_SESSION['statut'] = $membre['statut'];
			header('location:gestion_profil.php'); 
			exit();

		} else {

			echo '<script type="text/javascript">window.alert("erreur de mot de passe");</script>';
		}
	} else {

		echo '<script type="text/javascript">window.alert("erreur de login");</script>';
	}

} 


/*--------------------------------------- AFFICHAGE--------------------------------------- */
?>