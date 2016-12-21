<?php

namespace Controller;

use \Controller\AppController;
use \Services\Tools\ValidationTools;
use \Services\Tools\Tools;
use \Model\IntermediaireModel;
use \Model\UsersModel as OurUModel;
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
	private $model_intermediaire;
	private $authentificationmodel;

	public function __construct()
	{
		$this->valid = new ValidationTools();
		$this->tools = new Tools();
		$this->model = new UsersModel();
		$this->model_intermediaire = new IntermediaireModel();
		$this->ourumodel = new OurUModel();
		$this->authentificationmodel = new AuthentificationModel();
	}

// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page d'inscription
	 */
	public function registerUser($token=null)
	{

		$token_asso = (!empty($token)) ? trim(strip_tags($token)) : null;
		$this->show('users/register_user', array(
			'success' => $this->success,
			'token_asso' => $token_asso,
		));
	}

	/**
	 * Page de connexion
	 */
	public function login()
	{
		$this->show('users/login');
	}

	/**
	 * Page de profil
	 */
	public function profil()
	{
		$this->show('users/profil');
	}








// ===================================================================================================================
// 																							TRAITEMENT DES FORMULAIRES
// ===================================================================================================================

	/**
	 * Page d'inscription traitement
	 */
	public function tryRegister($token)
	{
		// recuperer le token en GET pour ligne 146 ci-dessous
		$token_asso = $token;
		$lastname   = trim(strip_tags($_POST['lastname']));
		$firstname   = trim(strip_tags($_POST['firstname']));
		$username   = trim(strip_tags($_POST['username']));
		$email = trim(strip_tags($_POST['email']));
		$password  = trim(strip_tags($_POST['password']));
		$password_confirm  = trim(strip_tags($_POST['password_confirm']));
		// verif de pseudo
		$exist = $this->model->usernameExists($username,'username', 3, 50);
		if($exist == true)
		{
			$error['username'] = 'Votre pseudo et deja prit';
		} else {
			$error['username']   = $this->valid->textValid($username,'username', 3, 50);
		}

		if(empty($_POST['lastname'])){
			$error['lastname'] = 'Veuillez renseigner un prenom';
		} else {
			$error['lastname']   = $this->valid->textValid($lastname,'lastname', 3, 50);
		}

		if(empty($_POST['firstname'])){
			$error['firstname'] = 'Veuillez renseigner un nom';
		} else {
			$error['firstname']   = $this->valid->textValid($firstname,'firstname', 3, 50);
		}

		if(empty($_POST['antiBot'])){

		} else {
			$error['antiBot'] = 'BIM';
		}

		if (isset($_POST['checkbox'])){

		} else {
			$error['checkbox'] = 'Vous n\'avez pas valider les CGU.';;
		}

		$exist = $this->model->emailExists($email,'email', 3, 50);
		if($exist == true){
			$error['email'] = 'le mail et deja prit';
		} else {
			$error['email'] = $this->valid->emailValid($email,'email', 3, 50);
		}

		$error['password']  = $this->valid->textValid($password,'password', 3, 50);

		if($password == $password_confirm){

			$passwordHash = $this->authentificationmodel->hashPassword($password);
			if ($this->valid->IsValid($error)) {
				$token = StringUtils::randomString();
				$slug = $firstname. ' ' .$username. ' ' .$lastname;
				$slug = $this->tools->slugify($slug);
				$data = array(
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

				$this->model->insert($data);

				if($token_asso != null){
					$data_intermediaire = array(
						'id_users' => 1,
						'id_assos' => 1,
						'created_at' => date('Y-m-d H:i:s'),
					);
					$this->model_intermediaire->insert($data_intermediaire);
				}

				$flash = new FlashBags();
				$flash->setFlash('warning', 'bravo vous etes inscrit');
				$this->show('users/login');
			} else {
				$this->show('users/register_user', array(
					'error' => $error,
				));
			}
		}	else {
			$error['password'] = 'Les mot de passe ne sont pas identique';
			$this->show('users/register_user', array(
				'error' => $error,
			));
		}
	}

/**
	* Page de connexion traitement
	*/
	public function tryLogin()
	{
		$error = array();

		$usernameOrEmail  = trim(strip_tags($_POST['emailOrPseudo']));
		$plainPassword   = trim(strip_tags($_POST['password']));

		$sessionActive = $this->model->getUserByUsernameOrEmail($usernameOrEmail);

      if(!empty($sessionActive)){
        if($this->authentificationmodel->isValidLoginInfo($usernameOrEmail, $plainPassword)){
          $this->authentificationmodel->logUserIn($sessionActive);
          $this->redirectToRoute('users_accueil');
        } else {
          $error['emailOrPseudo'] = "Le pseudo/mail ne correspond pas au mot de passe";
        }
      } else {
        $error['emailOrPseudo'] = "Ce compte n'existe pas";
      }

		$this->show('users/login', array('error' => $error));

	}

/**
  * Deconnexion
  */
	public function Deconnexion()
	{
		$this->authentificationmodel->logUserOut();
    $this->redirectToRoute('default_home');
	}

/**
  * Page de profil modification traitement
  */
	public function updateProfil()
	{
		// protection XSS
		$lastname   = trim(strip_tags($_POST['lastname']));
		$firstname   = trim(strip_tags($_POST['firstname']));
		$username   = trim(strip_tags($_POST['username']));
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
			$error['username'] = 'Votre pseudo et deja prit';
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

		// GG si il n'y a pas d'erreur
		if ($this->valid->IsValid($error)){
			$token = StringUtils::randomString();
			$data = array(
				'firstname' => $firstname,
				'lastname' => $lastname,
				'username' => $username,
				'token' => $token,
				'modified_at' => date('Y-m-d H:i:s'),
			);
			$this->model->update($data, $id);
			$this->authentificationmodel->refreshUser();
			$this->profil();
		}

    $this->show('users/profil', array('error' => $error));
	}

// =============================================================================
// ===============================FORGOT PASSWORD===============================
// =============================================================================
	public function forgotPassword()
	{
		$this->show('users/forgot_password');
	}

	public function tryForgotPassword()
	{
		$email   = trim(strip_tags($_POST['email']));

		// verif que le mail existe bien dans la BDD
		$exist = $this->model->emailExists($email,'email', 3, 50);
		if($exist == false){
			$error['email'] = 'Cet utilisateur n\'existe pas.';
		} else {
			$error['email'] = $this->valid->emailValid($email,'email', 3, 50);
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
	    $mail->Body = 'Cliquez : ' . '<a href="http://localhost/a_swap/public/connexion/modify_password?email=' . '' . $email . '&token=' . $token . '">Creer un nouveau mot de passe</a>';
	    // Il reste encore à ajouter au moins un destinataire
	    // (ou plus, par plusieurs appel à cette méthode)
	    $mail->AddAddress($email);
	    // Pour finir, on envoi l'e-mail
	    $mail->send();

			$flash = new FlashBags();
			$flash->setFlash('warning', 'Un email vous a été envoyer');
			$this->show('users/login');

		}

		$this->show('users/forgot_password', array(
			'error' => $error,
		));

	}

//==============================================================================
//================================MODIFY PASSWORD===============================
//==============================================================================
	public function modifyPassword()
	{
		$this->show('users/modify_password');
	}

	public function tryModifyPassword()
	{
		$getId = new OurUModel();
		$id = $getId->getIdByEmailAndToken();
		$password  = trim(strip_tags($_POST['password']));
		$password_confirm  = trim(strip_tags($_POST['repeat']));

		$error['password']  = $this->valid->textValid($password,'password', 3, 50);

		//Verfication que le token est bien le bon dans la BDD (si non, cela veux dire que c'est un ancien mail)
		$verif_token = $getId->tokenIsActive();
		if($verif_token == false){
			$error['token'] = 'Le mail que vous avez utilisé n\'est plus valide.';
		}

		if(!empty($password)) {

			if($password == $password_confirm){

				$passwordHash = $this->authentificationmodel->hashPassword($password);
				if ($this->valid->IsValid($error)) {
					$token = StringUtils::randomString();
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
					$flash->setFlash('warning', 'Votre mot de passe a bien été changer');
					$this->show('users/login');
				}

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

// Afficher les adhérants et derniers transaction sur page d'accueil d'un user
	public function usersAccueil()
	{

			$adherants = $this->ourumodel->affAdherants();
			$trans = $this->ourumodel->GetItsTrans();
			$this->show('users/accueil', array(
				'adherants' => $adherants,
				'trans' => $trans

			));

	}


} // Class
