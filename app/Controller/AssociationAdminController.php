<?php

namespace Controller;

use \Controller\AppController;

class AssociationAdminController extends AppController
{

// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page Back Association Admin
	 */
	public function backAssos()
	{
		$this->show('association/back_assos');
	}


// ===================================================================================================================
// 																						TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
  /**
	 * Page d'inscription Admin traitement
	 */
	public function backAssosModify()
	{
		$this->show('association/back_assos');
	}

  /**
	 *
	 */
  public function updateform($id)
  {

  }

	/**
	 *
	 */
  public function updateaction($id)
  {

  }



}
