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

  /**
   * Récupère les infos de l'assos par l'utilisateur
   */
  public function getAssosByUser()
  {
    $id_user = $_SESSION['user']['id'];
    
    $this->show('association/assos');
  }

}
