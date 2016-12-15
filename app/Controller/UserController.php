<?php

namespace Controller;

use \Controller\AppController;
use \Services\ValidationTool;
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
		$this->valid = new ValidationTool();
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


// ===================================================================================================================
// 																							TRAITEMENT DES FORMULAIRES
// ===================================================================================================================

	/**
	 * Page d'inscription traitement
	 */
	public function tryRegister()
	{
		$username   = trim(strip_tags($_POST['username']));
		$email = trim(strip_tags($_POST['email']));
		$password  = trim(strip_tags($_POST['password']));
		$password_confirm  = trim(strip_tags($_POST['password_confirm']));

		$exist = $this->model->usernameExists($username,'username', 3, 50);
		if($exist == true)
		{
			$error['username'] = 'Votre username et deja prit';
		} else {
			$error['username']   = $this->valid->textValid($username,'username', 3, 50);
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
					'username' => $username,
					'email' => $email,
					'password' => $passwordHash,
					'token' => $token,
					'role' => 'utilisateur',
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
		$this->show('users/login');
	}


}
