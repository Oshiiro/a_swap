<?php

namespace Controller;

use \Controller\AppController;
use \Services\Tools\ValidationTools;
use \W\Model\UsersModel;
use \W\Security\AuthentificationModel;
use \W\Security\StringUtils;

class UserController extends AppController
{
	private $valid;
	private $model;
	private $authentificationmodel;

	public function __construct()
	{
		$this->valid = new ValidationTools();
		$this->model = new UsersModel();
		$this->authentificationmodel = new AuthentificationModel();
	}

// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page d'inscription
	 */
	public function registerUser()
	{
		$this->show('users/register_user');
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
	public function tryRegister()
	{
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
				$data = array(
					'firstname' => $firstname,
					'lastname' => $lastname,
					'username' => $username,
					'email' => $email,
					'token' => $token,
					'password' => $passwordHash,
					'role' => 'user',
					'created_at' => date('Y-m-d H:i:s'),
				);

				$this->model->insert($data);

				// redirection
				$this->show('users/register_user');

			} else {
				$this->show('users/register_user', array('error' => $error));
			}

		}	else {
			$error['password'] = 'Les mot de passe ne sont pas identique';
			$this->show('users/register_user', array('error' => $error));
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

          $this->redirectToRoute('default_home');

        } else {
          $error['emailOrPseudo'] = "Le pseudo/mail ne correspond pas au mot de passe";
        }
      } else {
        $error['emailOrPseudo'] = "Ce compte n'existe pas";
      }

		$this->show('users/login', array('error' => $error));
	}


// Deconnexion
	public function Deconnexion()
	{
		$this->authentificationmodel->logUserOut();
    $this->redirectToRoute('default_home');
	}

} // Class
