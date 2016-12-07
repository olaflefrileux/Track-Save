<?php
require_once('init.inc.php');

if (isset($_GET['action']) && $_GET['action'] == 'supprimer') {
	executeRequete("DELETE FROM produit WHERE id_produit = :id_produit", array(":id_produit" => $_GET['id_produit']));
}

if (!empty($_POST)) {
//	var_dump($_POST);
	if (isset($_POST['nom_produit']) && (isset($_POST['url_produit']))) {
		executeRequete("INSERT INTO produit (titre, description) VALUES (:titre, :description)", array(":titre" => $_POST['nom_produit'], ':description' => '.'));
		echo 'Produit : ' . $_POST['nom_produit'] . ' ajouté.';
		$idp = executeRequete("SELECT * FROM produit WHERE titre = '$_POST[nom_produit]'");
		$id = $idp->fetch(PDO::FETCH_ASSOC);
		
		executeRequete("INSERT INTO detail_produit (url, prix, date_enregistrement, id_produit) VALUES (:url, :prix, :date_enregistrement, :id_produit)", array(":url" => $_POST['url_produit'], ":prix" => '-42', ":date_enregistrement" => 'NOW()', ":id_produit" => $id['id_produit']));
	}
}

$resultat = executeRequete("SELECT * FROM produit");
$resultat_dt = executeRequete("SELECT * FROM detail_produit");
while ($tab_dt = $resultat_dt->fetch(PDO::FETCH_ASSOC))

//$produits = $resultat->fetch(PDO::FETCH_ASSOC);
$contenu = 'Nombre de produits : ' . $resultat->rowCount() . '<br>';
$contenu .= '
 	<table style="width:100%" border-collapse="separate" border="1px">
  		<tr>
    			<th>Produit</th>
    			<th>Prix</th>
    			<th>Ajouté le</th>
    			<th>Action</th>
		</tr>';
		while ($idk = $resultat->fetch(PDO::FETCH_ASSOC)) {
			$contenu .= '<tr>';
				$contenu .= '<td><a href="gestion_produit.php?id_produit='. $idk['id_produit'] . '">'. $idk['titre'] .'</a></td>';
				$idp = executeRequete("SELECT * FROM detail_produit WHERE id_produit = :id_produit", array(":id_produit" => $idk['id_produit']));
				$idpr = $idp->fetch(PDO::FETCH_ASSOC);
				$contenu .= '<td>'. $idpr['prix'] .'</td>';
				$contenu .= '<td>'. $idpr['date_enregistrement'] .'</td>';
				$contenu .='<td>
					<a href="gestion_produit.php?action=modifier&id_produit='. $idk['id_produit'] .'">Modifier</a> - 	
					<a href="?action=supprimer&id_produit='. $idk['id_produit'] .'" onclick="return(confirm(\'Etes-vous certain de vouloir supprimer ce produit ? \'));" >Supprimer</a>
							</td>';
			$contenu .= '</tr>';
		}

			/*$contenu .= '<tr>'; 
			for($i = 0; $i < 4; $i++) {
				if ($i == 0) {
					$contenu .= '<td><a href="gestion_produit.php?action=afficher&id_produit='. $i .'">Produit '. $n .'</a></td>';
				}
				else if ($i == 3) {
					$contenu .='<td>
						<a href="gestion_produit.php?action=modification&id_produit='. $i .'">modifier</a> - 	
						<a href="?action=suppression&id_produit='. $i .'" onclick="return(confirm(\'Etes-vous certain de vouloir supprimer ce produit ? \'));" >supprimer</a>					
					</td>';
				}
				else
					$contenu .= '<td>' .$n. '</td>';
			}
			$contenu .='</tr>';
		}*/
	$contenu .= '</table>';
?> 

<form method=post action="">
<label for="nom_produit">Nom du produit </label>
<input type="text" id="nom_produit" name="nom_produit"><br>
<label for="url_produit">Url du produit </label>
<input type="text" id="url_produit" name="url_produit"><br>
<input type="submit" id="enregistrement" name"enregistrement" value="enregistrement">
</form>
<?php
	echo $contenu;
?>
