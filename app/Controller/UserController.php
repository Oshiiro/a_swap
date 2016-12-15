<?php

namespace Controller;

use \Controller\AppController;

class UserController extends AppController
{

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
		$this->show('users/register_user');
	}

	/**
	 * Page de connexion traitement
	 */
	public function tryLogin()
	{
		$this->show('users/login');
	}


}
