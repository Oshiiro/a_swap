<?php

namespace Controller;

use \Controller\AppController;

class AssociationController extends AppController
{
// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
  /**
	 * Page Association
	 */
	public function assos()
	{
		$this->show('association/assos');
	}



}
