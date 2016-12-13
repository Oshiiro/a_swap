<?php

namespace Controller;

use \Controller\AppController;

class DefaultController extends AppController
{
	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		$this->show('default/home');
	}

}
