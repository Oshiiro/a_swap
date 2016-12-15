<?php

namespace Controller;

use \Controller\AppController;

class DefaultController extends AppController
{

// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		$this->show('default/home');
	}

	/**
	 * Page de contact
	 */
	public function contact()
	{
		$this->show('default/contact');
	}

	/**
	 * Page de CGU
	 */
	public function cgu()
	{
		$this->show('default/cgu');
	}

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
