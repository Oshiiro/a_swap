<?php

namespace Controller;

use \Controller\AppController;

class UserAdminController extends AppController
{

// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
  /**
   * Page d'inscription Admin
   */
  public function registerAdmin()
  {
    $this->show('admin/register_admin');
  }


// ===================================================================================================================
// 																						TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
  /**
	 * Page d'inscription Admin traitement
	 */
	public function tryRegisterAdmin()
	{
		$this->show('users/register_user');
	}

}
