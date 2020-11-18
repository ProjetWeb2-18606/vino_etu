<?php
/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */

class Controler 
{
	
		/**
		 * Traite la requête
		 * @return void
		 */
		public function gerer()
		{
			switch ($_GET['requete']) {
				case 'authentification':
					$this->authentification();
					break;
				case 'listeBouteille':
					$this->listeBouteille();
					break;
				case 'autocompleteBouteille':
					$this->autocompleteBouteille();
					break;
				case 'ajouterNouvelleBouteilleCellier':
					$this->ajouterNouvelleBouteilleCellier();
					break;
				case 'ajouterBouteilleCellier':
					$this->ajouterBouteilleCellier();
					break;
				case 'boireBouteilleCellier':
					$this->boireBouteilleCellier();
					break;
				case 'accueilUsager':
					$this->accueilUsager();
				case 'modifierCompte':
					$this->modifierCompte();
					break;
				case 'sauvegardeCompte':
					$this->sauvegardeCompte();
					break;
				default:
					$this->accueil();
					break;
			}

		
			
		}

		private function authentification()
		{
			// echo "controller-auth";

			$auth = new Authentification();


			// 1- test option 1 infos via ajax
			$valide = $auth->validerAuthentification($_POST['pseudo'], $_POST['password']);


			if($valide) {

				// TODO : sauvegarde de l'usager authentifié
				// $_SESSION["username"] = $_REQUEST["username"];
				
				$this->accueilUsager();

			}


		}

		// accueil publique (usager qui n'est pas encore authentifié)
		private function accueil()
		{
			// include("vues/entete.php");
			include("vues/welcome.php");
			// include("vues/pied.php");      
		}

		// cette méthode se nommait "accueil" avant
		private function accueilUsager()
		{
			$bte = new Bouteille();
			$data = $bte->getListeBouteilleCellier();
			include("vues/entete.php");
			include("vues/cellier.php");
			include("vues/pied.php");      
		}

		private function listeBouteille()
		{
			$bte = new Bouteille();
            $cellier = $bte->getListeBouteilleCellier();
            
            echo json_encode($cellier);
                  
		}
		
		private function autocompleteBouteille()
		{
			$bte = new Bouteille();
			//var_dump(file_get_contents('php://input'));
			$body = json_decode(file_get_contents('php://input'));
			//var_dump($body);
            $listeBouteille = $bte->autocomplete($body->nom);
            
            echo json_encode($listeBouteille);    
		}

		private function ajouterNouvelleBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			//var_dump($body);
			if(!empty($body)){
				$bte = new Bouteille();
				//var_dump($_POST['data']);
				
				//var_dump($data);
				$resultat = $bte->ajouterBouteilleCellier($body);
				echo json_encode($resultat);
			}
			else{
				include("vues/entete.php");
				include("vues/ajouter.php");
				include("vues/pied.php");
			}
		}
		
		private function boireBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			
			$bte = new Bouteille();
			$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, -1);
			echo json_encode($resultat);
		}

		private function ajouterBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			
			$bte = new Bouteille();
			$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, 1);
			echo json_encode($resultat);
		}

		private function modifierCompte()
		{
		
			$body = json_decode(file_get_contents('php://input'));
			//var_dump($body);
			if(!empty($body)){
				$usager = new Usager();
				//var_dump($_POST['data']);
				
				//var_dump($data);
				$resultat = $usager->sauvegardeModificationCompte($body); 
				echo json_encode($resultat);
			}
			else{
				include("vues/entete.php");
				include("vues/compte.php");
				include("vues/pied.php");	
			}

		}

		private function sauvegardeCompte()
		{
			/**
			 * *******************
			 * To Do
			 * récupérer id d'usager quand authentification
			 * *******************
			 */
			$usager = new Usager();
			$usager->sauvegardeModificationCompte(1, $_POST['nom'],$_POST['prenom'], $_POST['mot_de_passe']); 
			include("vues/entete.php");
			include("vues/compte.php");
			include("vues/pied.php");
		}
		
		private function getCurrentUser()
		{

		}

}
?>















