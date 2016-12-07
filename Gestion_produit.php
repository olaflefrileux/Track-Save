<?php
require_once('init.inc.php');

$contenu = '';
/*
if (!Is_co()) {
	header('location:connexion.php');	
	exit();
}
*/

if (isset($_POST['envoi'])){

	if(!empty($_POST['description'])){
		$contenu .= 'Description de votre produit: ';
		$contenu .= $_POST['description'] . '<br><br>';
		$description = $_POST['description'];
		executeRequete("UPDATE produit SET description = '$description' WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));
	}

	if(!empty($_POST['alert']) && !empty($_POST['seuil'])){
		$contenu .= 'L\'alerte par mail est activée pour ce produit. <br><br>';
		$contenu .= 'Vous avez choisis ' . $_POST['seuil'] . ' € comme étant le prix souhaité pour ce produit. <br><br>';
		$seuil = $_POST['seuil'];
		executeRequete("INSERT INTO alert (seuil) VALUES '$seuil' WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));

	} else {
		$contenu .= 'L\'alerte par mail n\'est pas activée pour ce produit. <br><br>';
	}

	if (!empty($_POST['urlcomp'])){
		$urlcomp = $_POST['urlcomp'];
		executeRequete("INSERT INTO alert (urlcomp) VALUES '$urlcomp' WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));
		$nburlcomp = executeRequete("SELECT * FROM detail_produit");
	
		$contenu .= '<h3>Liste de comparaison: </h3>';
		$contenu .= 'Nombre de liens de comparaison: ' . $nburlcomp->rowCount() . '<br><br>';
		$contenu .= '<table border="1">';
		$contenu .= '<tr>';
		$contenu .= '<th>URL</th>';
		$contenu .= '<th>Prix actuel</th>';
		$contenu .= '<th>action</th>';
		$contenu .= '</tr>';

		while ($ligne = $nburlcomp->fetch(PDO::FETCH_ASSOC)) {
			$contenu .= '<tr>';
				foreach($ligne as $key => $value) {
						if($key == 'url'){
							$contenu .= '<td>'. $value .'</td>';
				        }

				        if($key == 'prix'){
							$contenu .= '<td>'. $value .'</td>';
				        }

		        }
		$contenu .= '<td>';
		$contenu .= '<a href="?action=suppression&id_detailproduit='.$ligne['id_detailproduit'].'" onclick="return(confirm(\'Etes-vous certain de vouloir supprimer cet url de comparaison ? \'));" >supprimer</a>';
		$contenu .= '<td>';
		$contenu .= '</tr>';	
		
		}
		$contenu .= '</table>';
		$contenu .= '<br><br>';
	}

}




?>

<h2> Gestion de vos Produits </h2><br><br>
<?php
echo $contenu;
?>


<form method="post" action="">

	<label for="description">Description de votre produit: </label><br>
	<input type="text" id="description" name="description"><br><br>

	<label><input type="checkbox" id="alert" name="alert" value="alert"> Activer l'alerte par email pour ce produit</label><br><br>

	<label for="seuil">Seuil: </label><br>
	<input type="text" id="seuil" name="seuil"><br><br>

	<label for="urlcomp">Ajouter une url de comparaison: </label><br>
	<input type="text" id="urlcomp" name="urlcomp"><br><br>

	<input type="submit" value="Soumettre" class="btn" name="envoi">
</form>

