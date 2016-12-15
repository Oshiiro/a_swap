<?php

namespace Controller;

use \Controller\AppController;
use \Services\ValidationTool;
use \W\Model\UsersModel;
use \W\Security\AuthentificationModel;
use \W\Security\StringUtils;

class UserController extends AppController
{

	/**
	 * Page d'inscription
	 */
	public function register()
	{
		$this->show('default/register');
	}

	/**
	 * Page de connexion
	 */
	public function login()
	{
		$this->show('default/login');
	}


// ===================================================================================================================
// 																							TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
private $valid;
private $model;
private $authentificationmodel;

public function __construct()
{
	$this->valid = new ValidationTool();
	$this->model = new UsersModel();
	$this->authentificationmodel = new AuthentificationModel();
}

	/**
	 * Page d'inscription
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
				$this->redirectToRoute('kakala');

			} else {

				$this->show('default/inscription', array('error' => $error, 'success'));

			}
		}	else {
			$error['password'] = 'Les mot de passe ne sont pas identique';
			$this->show('default/inscription', array('error' => $error));
		}
	}

	/**
	 * Page d'inscription
	 */
	public function tryLogin()
	{
		$this->show('default/login');
	}


}
