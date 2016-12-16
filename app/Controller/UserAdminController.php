<?php

namespace Controller;

use \Controller\AppController;
use \Service\Tools\ValidationTools;


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
    $nom_assos = (!empty($_POST['nom_assos'])) ? trim(strip_tags($_POST['nom_assos'])) : null;

    $this->show('admin/register_admin', array(
      'nom_assos' => $nom_assos,
    ));
  }

  /**
   * Page Back de l'admin
   */
  public function back()
  {
    $this->show('admin/Back');
  }

// ===================================================================================================================
// 																						TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
  /**
	 * Page d'inscription Admin traitement
	 */
	public function tryRegisterAdmin()
	{
    $tools = new ValidationTools();
    $error = array();

    // xss partie assos
    $nom_assos = (!empty($_POST['nom_assos'])) ? trim(strip_tags($_POST['nom_assos'])) : null;
    $description_assos = (!empty($_POST['description_assos'])) ? trim(strip_tags($_POST['description_assos'])) : $email = null;
    $money_name = (!empty($_POST['money_name'])) ? $password = trim(strip_tags($_POST['money_name'])) : null;
    $rules_assos = (!empty($_POST['rules_assos'])) ? trim(strip_tags($_POST['rules_assos'])) : null;

    //xss partie admin

    // Verification des champs partie assos

    // Verification des champs partie admin

    // if (count($error) == 0)
    // => insert table assos
    // => insert table users
    // => insert table intermediaire
    // redirection

    // prout prout


  }

}
