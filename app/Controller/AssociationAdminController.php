<?php

namespace Controller;

use \Controller\AppController;

class AssociationAdminController extends AppController
{

// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page d'accueil d'Admin association
	 */
  public function adminAssociation()
  {
    $this->show('association/adminassociation');
  }

  /**
	 * Page d'accueil d'Admin association
	 */
  public function updateform($id)
  {

  }

  public function updateaction($id)
  {

  }



}
