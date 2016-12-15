<?php

namespace Controller;

use \Controller\AppController;

class MessageController extends AppController
{
// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page de messagerie
	 */
	public function message()
	{
		$this->show('message/message');
	}

// ===================================================================================================================
// 																							TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
  /**
   * Envois d'un message
   */
  public function sendMessage()
  {
  	$this->show('message/message');
  }

}
