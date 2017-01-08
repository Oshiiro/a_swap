<?php

namespace Controller;

use \Controller\AppController;
use \Services\Tools\ValidationTools;
use \Services\Tools\Tools;
use \Services\Pagination;
use \Model\IntermediaireModel;
use \Model\UsersModel as OurUModel;
use \Model\AssosModel;
use \Model\AvatarModel;
use \Model\BackModel;
use \Model\InvitationModel;
use \W\Model\UsersModel;
use \W\Security\AuthentificationModel;
use \W\Security\StringUtils;
use \Services\Flash\FlashBags;
use PHPMailer;

class UserController extends AppController
{
	private $valid;
	private $model;
	private $tools;
	private $model_avatar;
	private $model_intermediaire;
	private $model_assos;
	private $model_invitation;
	private $ourumodel;
	private $authentificationmodel;

	public function __construct()
	{
		$this->valid = new ValidationTools();
		$this->tools = new Tools();
		$this->model = new UsersModel();
		$this->model_avatar = new AvatarModel();
		$this->model_intermediaire = new IntermediaireModel();
		$this->model_assos = new AssosModel();
		$this->model_invitation = new InvitationModel();
		$this->ourumodel = new OurUModel();
		$this->backmodel = new BackModel();
		$this->authentificationmodel = new AuthentificationModel();
	}

// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
  * Affichage pour un utilisateur de la page d'inscription faisant suite à une invitation
  * @param string $token_asso Token de l'association qui invite
  * @param string $token_invit Token de l'invitation concernée
  */
	public function registerUserFromInvite($token_asso, $token_invit)
	{
		if ($this->tools->isLogged() == false) {
			$token_asso = (!empty($token_asso)) ? trim(strip_tags($token_asso)) : null;
			$token_invit = (!empty($token_invit)) ? trim(strip_tags($token_invit)) : null;
			$this->show('users/register_user', array(
				'token_asso' => $token_asso,
				'token_invit' => $token_invit,
			));
		} else {
			$this->showForbidden(); // erreur 403
		}

	}

	/**
	 * Affichage de la page d'inscription pour un utilisateur
	 */
	public function registerUser()
	{
		if ($this->tools->isLogged() == false) {
			$token_asso = (!empty($token)) ? trim(strip_tags($token)) : null;
			$this->show('users/register_user', array(
				'token_asso' => $token_asso,
			));
		} else {
			$this->showForbidden(); // erreur 403
		}

	}

	/**
	* Affichage de la page de connexion
	*/
	public function login()
	{
		if ($this->tools->isLogged() == false) {
		$this->show('users/login');
		} else {
			$this->showForbidden(); // erreur 403
		}
	}

	/**
	* Affichage de la page profil d'un utilisateur
	*/
	public function profil()
	{
		$this->allowTo(array('user','admin', 'superadmin'));
		$slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);
		$avatar = $this->model_avatar->FindLinkForImg('link_relative', 'id_user', $_SESSION['user']['id']);
		$this->show('users/profil', array(
			'slug' => $slug,
			'avatar' => $avatar,
		));
	}

	/**
	* Affichage de la page transactions de l'utilisateur
	* @param string $slug Slug de l'association pour laquelle l'utilisateur consulte ses transactions
	* @param int $page Numero de la page consultée
	*/
	public function associationTrans($slug,$page)
	{

		if ($this->tools->isLogged() == true) {
			$slug_is_mine = $this->model_assos->slugIsMine($slug);
			if($slug_is_mine == true) {
				$slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);

				$limit1 = 10;
				$id_asso = $this->model_assos->FindElementByElement('id', 'slug', $slug);
				//limit d'affichage par page
				$Pagination = new Pagination('transaction');
				//on precise la table a exploiter
				$calcul1 = $Pagination->calcule_page('id_asso = \''.$id_asso.'\'',$limit1,$page);
				//en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
				//ce qui calcule le nombre de page total et le offset
				$adherants = $this->ourumodel->affAllAdherants($slug, $id_asso, $limit1, $calcul1['offset']);
				$pagination_trans = $Pagination->pagination($calcul1['page'],$calcul1['nb_page'],'association', ['slug' => $slug,'page' => $page]);
				//on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
				$trans = $this->ourumodel->GetItsTrans($slug, $limit1,$calcul1['offset']);

				$this->show('association/assos_trans', array(
					'pagination_trans'=> $pagination_trans,
					'slug' => $slug,
					'adherants' => $adherants,
					'trans' => $trans,
					'page' => $page
				));

			} else {
				$this->showForbidden(); // erreur 403
			}
		} else {
			$this->showForbidden(); // erreur 403
		}

	}

	/**
	* Affichage de la page "Info" de l'association
	* @param string $slug Slug de l'association concernée
	*/
	public function associationInfos($slug)
	{
		if ($this->tools->isLogged() == true) {
			$slug_is_mine = $this->model_assos->slugIsMine($slug);
			if($slug_is_mine == true) {
				$slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);
				$id_asso = $this->model_assos->FindElementByElement('id', 'slug', $slug);

				$this->show('association/assos_infos', array(
					'slug' => $slug,
				));
			} else {
				$this->showForbidden(); // erreur 403
			}
		} else {
			$this->showForbidden(); // erreur 403
		}

	}

	/**
	* Affichage des dernieres transaction effectuée par l'utilisateur
	* @param string $slug Slug de l'association concernée
	* @param int $page Numero de la page consultée
	*/
	public function associationAdherants($slug, $page)
	{

		if ($this->tools->isLogged() == true) {
			$slug_is_mine = $this->model_assos->slugIsMine($slug);
			if($slug_is_mine == true) {
				$slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);

				$limit1 = 10;
				$id_asso = $this->model_assos->FindElementByElement('id', 'slug', $slug);
				//limit d'affichage par page
				$Pagination = new Pagination('intermediaire');
				//on precise la table a exploiter
				$calcul1 = $Pagination->calcule_page('id_assos = \''.$id_asso.'\'',$limit1,$page);
				//en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
				//ce qui calcule le nombre de page total et le offset
				$adherants = $this->ourumodel->affAllAdherants($slug,$id_asso, $limit1, $calcul1['offset']);
				$pagination_adh = $Pagination->pagination($calcul1['page'],$calcul1['nb_page'],'association_adherants', ['slug' => $slug,'page' => $page]);
				//on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe


				$this->show('association/assos_adherants', array(
					'pagination_adh'=> $pagination_adh,
					'slug' => $slug,
					'adherants' => $adherants,
					'page' => $page

				));

			} else {
				$this->showForbidden(); // erreur 403
			}
		} else {
			$this->showForbidden(); // erreur 403
		}
	}

// ===================================================================================================================
// 																							TRAITEMENT DES FORMULAIRES
// ===================================================================================================================

	/**
 	* Traitement de l'inscription d'un utilisateur
 	*/
	public function tryRegister()
	{
		$token_asso = (!empty($_POST['token_asso'])) ? trim(strip_tags($_POST['token_asso'])) : null ;
		$token_invit = (!empty($_POST['token_invit'])) ? trim(strip_tags($_POST['token_invit'])) : null ;
		$lastname   = (!empty($_POST['lastname'])) ? trim(strip_tags($_POST['lastname'])) : null ;
		$firstname   = (!empty($_POST['firstname'])) ? trim(strip_tags($_POST['firstname'])) : null ;
		$username   = (!empty($_POST['username'])) ? trim(strip_tags($_POST['username'])) : null ;
		$email = (!empty($_POST['email'])) ? trim(strip_tags($_POST['email'])) : null ;
		$password  = (!empty($_POST['password'])) ? trim(strip_tags($_POST['password'])) : null ;
		$password_confirm  = (!empty($_POST['password_confirm'])) ? trim(strip_tags($_POST['password_confirm'])) : null ;
		// verif de pseudo
		$exist = $this->model->usernameExists($username,'username', 3, 50);
		if($exist == true)
		{
			$error['username'] = 'Votre pseudo est déjà pris';
		} else {
			$error['username']   = $this->valid->textValid($username,'pseudo', 3, 50);
		}

		if(empty($_POST['lastname'])){
			$error['lastname'] = 'Veuillez renseigner un prénom';
		} else {
			$error['lastname']   = $this->valid->textValid($lastname,'nom', 3, 50);
		}

		if(empty($_POST['firstname'])){
			$error['firstname'] = 'Veuillez renseigner un nom';
		} else {
			$error['firstname']   = $this->valid->textValid($firstname,'prénom', 3, 50);
		}

		if(!empty($_POST['antiBot'])){
			$error['antiBot'] = 'BIM';
		}

		if (isset($_POST['checkbox'])){

		} else {
			$error['checkbox'] = 'Vous n\'avez pas validé les CGU.';;
		}

		$exist = $this->model->emailExists($email,'email', 3, 50);
		if($exist == true){
			$error['email'] = 'L\'e-mail est déjà pris';
		} else {
			$error['email'] = $this->valid->emailValid($email,'email', 3, 50);
		}

		$error['password']  = $this->valid->textValid($password,'password', 3, 50);

		if($token_asso != null) {
			// si un token d'asso est present, on verifie qu'il existe bien une invitation
			// dans la table invitation avec ce mail, ce token_asso et ce token_invit
			$invit_exist = $this->model_invitation->invationIsValid($token_asso, $token_invit);
			if($invit_exist == false){
				$error['tokens'] = 'Vous utilisez un e-mail d\'invitation invalide.';
			}
			$email_of_this_invitation = $this->model_invitation->getEmailByTokens($token_asso, $token_invit);
			if($email_of_this_invitation != $email){
				$error['email'] = 'Vous devez vous inscrire avec l\'e-mail sur lequel vous avez reçu l\'invitation';
			}
		}

		if($password == $password_confirm){

			$passwordHash = $this->authentificationmodel->hashPassword($password);
			if ($this->valid->IsValid($error)) {
				$token = StringUtils::randomString(40);
				$slug = $firstname. ' ' .$username. ' ' .$lastname;
				$slug = $this->tools->slugify($slug);
				$data_user = array(
					'firstname' => $firstname,
					'lastname' => $lastname,
					'username' => $username,
					'email' => $email,
					'token' => $token,
					'slug' => $slug,
					'password' => $passwordHash,
					'role' => 'user',
					'active' => 1,
					'created_at' => date('Y-m-d H:i:s'),
				);

				$this->model->insert($data_user);

				if($token_asso != null){
					$id_users = $this->ourumodel->getIdByEmail($email);
					$id_assos = $this->model_assos->getIdByToken($token_asso);

					$data_intermediaire = array(
						'id_users' => $id_users,
						'id_assos' => $id_assos,
						'created_at' => date('Y-m-d H:i:s'),
						'role' => 'user',
					);
					$this->model_intermediaire->insert($data_intermediaire);

					$id_invitation = $this->model_invitation->getIdByTokens($token_asso, $token_invit);
					$data_invitation = array(
						'token_invit' => StringUtils::randomString(40),
						'status' => 'accepted',
						'modified_at' => date('Y-m-d H:i:s'),
					);
					// MAJ du token_invit, du status et du modified_at
					$this->model_invitation->update($data_invitation, $id_invitation);
				}

				$flash = new FlashBags();
				$flash->setFlash('warning', 'Bravo vous êtes inscrits');
				$this->show('users/login');
			} else {
				$this->show('users/register_user', array(
					'error' => $error,
				));
			}
		}	else {
			$error['password'] = 'Les mots de passe ne sont pas identiques';
			$this->show('users/register_user', array(
				'error' => $error,
			));
		}
	}

	/**
	* Traitement de la page de connexion
	*/
	public function tryLogin()
	{

		$error = array();
		$slug = null;
		$usernameOrEmail  = (!empty($_POST['emailOrPseudo'])) ? trim(strip_tags($_POST['emailOrPseudo'])) : null ;
		$plainPassword   = (!empty($_POST['password'])) ? trim(strip_tags($_POST['password'])) : null ;

		$sessionActive = $this->model->getUserByUsernameOrEmail($usernameOrEmail);

      if(!empty($sessionActive)){
        if($this->authentificationmodel->isValidLoginInfo($usernameOrEmail, $plainPassword)){
          $this->authentificationmodel->logUserIn($sessionActive);
					$_SESSION['user']['nom_assos'] = $this->model_assos->getNameByIdAdmin($_SESSION['user']['id']);
					$_SESSION['user']['wallet'] = $this->model_intermediaire->FindElementByElement('wallet', 'id_users', $_SESSION['user']['id']);

					$slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);
					$this->redirectToRoute('message', array(
						'page_rec'=> 1,
						'page_sen' => 1,
					));

        } else {
          $error['emailOrPseudo'] = "Le pseudo/e-mail ne correspond pas au mot de passe";
        }
      } else {
        $error['emailOrPseudo'] = "Ce compte n'existe pas";
      }

		$this->show('users/login', array(
			'error' => $error,
			'slug' => $slug,
		));

	}

	/**
  * Traitement de la page de deconnexion
  */
	public function Deconnexion() // pas de majuscule pour les function plz
	{
		$this->authentificationmodel->logUserOut();
    $this->redirectToRoute('default_home');
	}

	/**
  * Traitement de la page de modification de profil
  */
	public function updateProfil()
	{
		// protection XSS
		$lastname   = (!empty($_POST['lastname'])) ? trim(strip_tags($_POST['lastname'])) : null;
		$firstname   = (!empty($_POST['firstname'])) ? trim(strip_tags($_POST['firstname'])) : null;
		$username   = (!empty($_POST['username'])) ? trim(strip_tags($_POST['username'])) : null;
		$id = $_SESSION['user']['id'];

		// verif de pseudo
		$exist = $this->model->usernameExists($username,'username', 3, 50);

		// si le pseudo est le même que celui de la session, alors c'est good
		if($username == $_SESSION['user']['username'])
		{
			$exist = false;
		}

		// si l'utilisateur tente de prendre un pseudo deja existant, on le bloque mamene
		if($exist == true)
		{
			$error['username'] = 'Ce pseudo est déjà pris';
		} else {
			$error['username']   = $this->valid->textValid($username,'username', 3, 50);
		}

		// verif de lastname
		if(empty($_POST['lastname'])){
			$error['lastname'] = 'Veuillez renseigner un prenom';
		} else {
			$error['lastname']   = $this->valid->textValid($lastname,'lastname', 3, 50);
		}

		// verif de firstname
		if(empty($_POST['firstname'])){
			$error['firstname'] = 'Veuillez renseigner un nom';
		} else {
			$error['firstname']   = $this->valid->textValid($firstname,'firstname', 3, 50);
		}

		// verif antibot
		if(empty($_POST['antiBot'])){
		} else {
			$error['antiBot'] = 'BIM';
		}

		// upload de la photo de profil
		if($_FILES['foo']['error'] == 0) {
			$error['img'] = $this->updateProfilImg();
		}

		// GG si il n'y a pas d'erreur
		if ($this->valid->IsValid($error)){
			$token = StringUtils::randomString(40);
			$data = array(
				'firstname' => $firstname,
				'lastname' => $lastname,
				'username' => $username,
				'token' => $token,
				'modified_at' => date('Y-m-d H:i:s'),
			);
			$this->model->update($data, $id);
			$this->authentificationmodel->refreshUser();
			$_SESSION['user']['nom_assos'] = $this->model_assos->getNameByIdAdmin($_SESSION['user']['id']);
			$_SESSION['user']['wallet'] = $this->model_intermediaire->FindElementByElement('wallet', 'id_users', $_SESSION['user']['id']);



			$flash = new FlashBags();
			$flash->setFlash('warning', 'Votre profil a bien été modifié');
			$this->profil();
		}
    $this->show('users/profil', array('error' => $error));
	}

	/**
  * Traitement de la modification de photo de profil
  */
	public function updateProfilImg()
	{
		// endroit ou on sauvegarde l'image
		$storage = new \Upload\Storage\FileSystem(WEBROOT . '\assets\img\profil', true);
		$file = new \Upload\File('foo', $storage);

		// Optionally you can rename the file on upload
		$new_filename = 'profil-' . $_SESSION['user']['slug'];
		$file->setName($new_filename);

		// Validate file upload
		// MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
		$file->addValidations(array(
		    // Ensure file is of type "image/png"
		    new \Upload\Validation\Mimetype(array('image/png', 'image/jpeg',  'image/jpg')),

		    //You can also add multi mimetype validation
		    //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

		    // Ensure file is no larger than 5M (use "B", "K", M", or "G")
		    new \Upload\Validation\Size('2M')
		));

		// Access data about the file that has been uploaded
		$data = array(
		    'name'       => $file->getNameWithExtension(),
		    'extension'  => $file->getExtension(),
		    'mime'       => $file->getMimetype(),
		    'size'       => $file->getSize(),
		    'md5'        => $file->getMd5(),
		    'dimensions' => $file->getDimensions()
		);

		// Try to upload file
		try {
		    // Success!
		    $file->upload();

				$dataPerso = array(
					'id_user' 			=> $_SESSION['user']['id'],
					'origin_name' 	=> 'chépacomenlavoir',
					'name' 					=> $data['name'],
					'created_at'	  => date('Y-m-d H:i:s'),
					'link_absolute' => 'C:\xampp\htdocs\a_swap\public\assets\img\profil\\' . $data['name'],
					'link_relative' => 'img\profil\\' . $data['name'],
					'size' 					=> $data['size'],
					'mimetype'		 	=> $data['mime'],
					'extension' 		=> $data['extension'],
					'active' 				=> 1,
				);

				$this->model_avatar->insert($dataPerso);
		} catch (\Exception $e) {
		    // Fail!
		    $errors = $file->getErrors();
				return "Erreur lors de l'upload de l'image";
		}
	}

// =============================================================================
// ===============================FORGOT PASSWORD===============================
// =============================================================================
	/**
	* Affichage de la page d'oubli de mot de passe
	*/
	public function forgotPassword()
	{
		$this->show('users/forgot_password');
	}

	/**
	* Traitement de la page d'oubli de mot de passe
	*/
	public function tryForgotPassword()
	{
		$email   = (!empty($_POST['email'])) ? trim(strip_tags($_POST['email'])) : null ;

		$error['email'] = $this->valid->emailValid($email,'email', 3, 50);
		// verif que le mail existe bien dans la BDD
		$exist = $this->model->emailExists($email,'email', 3, 50);
		if($exist == false){
			$error['email'] = 'Cet utilisateur n\'existe pas.';
		}

		// S'il n'y a pas d'erreurs
		if ($this->valid->IsValid($error)) {

			$usersModel = new OurUModel();
			$token = $usersModel->recupToken($email);
			//encodage de l'email
	    $mailEncode = urlencode($email);

	    // On créé une nouvelle instance de la classe
	    $mail = new PHPMailer();
			// $mail->CharSet = 'UTF-8';
			$mail->CharSet = "utf8";
	    // De qui vient le message, e-mail puis nom
	    $mail->From = "no.reply@a-swap.com";
	    $mail->FromName = "A-Swap Admin";
	    // Définition du sujet/objet
	    $mail->Subject = "Récupération du mot de passe";
	    // On définit le corps du message
			// ATTENTION PENSEZ A MODIFIER LE LIEN CI DESSOUS EN FONCTION DU NOM DU
			// REPERTOIRE DU PROJET DANS VOTRE LOCALHOST
			$modify_mail = $this->generateUrl('modify_password', ['token' => $token], true);
	    $mail->Body = 'Cliquez : ' . '<a href="' .$modify_mail. '">Creer un nouveau mot de passe</a>';
	    // Il reste encore à ajouter au moins un destinataire
	    // (ou plus, par plusieurs appel à cette méthode)
	    $mail->AddAddress($email);
	    // Pour finir, on envoi l'e-mail
	    $mail->send();

			$flash = new FlashBags();
			$flash->setFlash('warning', 'Un e-mail vous a été envoyé');
			$this->show('users/login');

		}

		$this->show('users/forgot_password', array(
			'error' => $error,
		));

	}

//==============================================================================
//================================MODIFY PASSWORD===============================
//==============================================================================
	/**
	* Affichage de la page de modification de mot de passe
	*/
	public function modifyPassword($token)
	{
		$email = (!empty($email)) ? trim(strip_tags($email)) : null;
		$token = (!empty($token)) ? trim(strip_tags($token)) : null;
		$this->show('users/modify_password');
	}

	/**
	* Traitement de la page de modification de mot de passe
	*/
	public function tryModifyPassword($token)
	{
		$email  = (!empty($_POST['email'])) ? trim(strip_tags($_POST['email'])) : null ;
		$getId = new OurUModel();
		$id = $getId->getIdByEmailAndToken($email, $token);
		$password  = (!empty($_POST['password'])) ? trim(strip_tags($_POST['password'])) : null ;
		$password_confirm  = (!empty($_POST['repeat'])) ? trim(strip_tags($_POST['repeat'])) : null ;

		$error['password']  = $this->valid->textValid($password,'password', 3, 50);

		//Verification que le token est bien le bon dans la BDD (si non, cela veux dire que c'est un ancien mail)
		$verif_token = $getId->tokenIsActive($email, $token);
		if($verif_token == false){
			$error['token'] = 'L\'e-mail que vous avez utilisé n\'est plus valide.';
		}

		if(!empty($password)) {

			if($password == $password_confirm){

				$passwordHash = $this->authentificationmodel->hashPassword($password);
				if ($this->valid->IsValid($error)) {
					$token = StringUtils::randomString(40);
					$data = array(
						'token' => $token,
						'password' => $passwordHash,
						'modified_at' => date('Y-m-d H:i:s'),
					);
					// Modifie une ligne en fonction d'un identifiant
					// Le premier argument est un tableau associatif de valeurs à insérer
					// Le second est l'identifiant de la ligne à modifier
					$this->model->update($data, $id);
					//Redirection vers la page de login
					$flash = new FlashBags();
					$flash->setFlash('warning', 'Votre mot de passe a bien été changé');
					$this->show('users/login');
				}

				echo $verif_token;
				die();
				$this->show('users/modify_password', array(
					'error' => $error,
				));
			}
		} else {
			$error['password'] = 'Merci de definir un nouveau mot de passe';
		}
		$this->show('users/modify_password', array(
			'error' => $error,
		));
	}



} // Class
