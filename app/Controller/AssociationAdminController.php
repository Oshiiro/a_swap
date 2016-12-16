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

	/**
	 * Page Back Association Admin ( page de modif )
	 */
	public function backAssosTryModif()
	{
		$this->show('association/modifassos_admin_back');
	}


// ===================================================================================================================
// 																						TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
	/**
	* Ajout de crédit à un membre
	*/
	public function addCoinToUser()
	{
		$this->show('association/back_assos');
	}

  /**
	 * Page d'inscription Admin traitement
	 */
	public function backAssosModify()
	{
		$this->show('association/modifassos_admin_back');
	}



  /**
	 *
	 */
  public function updateform($id)
  {
		$this->show('association/modifassos_admin_back');
  }

	/**
	 *
	 */
  public function updateaction($id)
  {
		$this->show('association/modifassos_admin_back');
  }



}
