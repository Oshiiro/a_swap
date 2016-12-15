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

// ===================================================================================================================
// 																							TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
/**
 * Page de contact - Envois du mail traitement
 */
public function sendMailContact()
{
	$this->show('default/contact');
}

}
