<?php

namespace Controller;

use \Controller\AppController;

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
	/**
	 * Page d'inscription
	 */
	public function tryRegister()
	{
		$this->show('default/register');
	}

	/**
	 * Page d'inscription
	 */
	public function tryLogin()
	{
		$this->show('default/login');
	}


}
