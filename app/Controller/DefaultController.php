<?php

namespace Controller;

use \Controller\AppController;
use \Model\AssosModel;
use \Services\Tools\Tools;




class DefaultController extends AppController
{
	private $tools;

	public function __construct()
	{
		$this->tools = new Tools();
	}

// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		if ($this->tools->isLogged() == true){
			$slug = new AssosModel();
			$slug = $slug->getSlugByIdAdmin($_SESSION['user']['id']);
			$this->show('default/home', array(
				'slug' => $slug,
			));
		} else {
			$this->show('default/home');
		}
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
