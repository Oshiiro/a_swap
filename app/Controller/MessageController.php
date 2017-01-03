<?php

namespace Controller;

use \Controller\AppController;
use \Model\MessageModel;
use \Model\AssosModel;
use \Model\UsersModel AS OurUModel;
use \Services\Tools\Tools;

class MessageController extends AppController
{
  private $tools;
  private $model_assos;

  public function __construct()
	{
		$this->tools = new Tools();
    $this->model_assos = new AssosModel();
  }

// ===================================================================================================================
// AFFICHAGE DES PAGES
// ===================================================================================================================
/**
* Page de messagerie
*/
public function message()
{
  if ($this->tools->isLogged() == true) {
    $showMessages = new MessageModel();
    $users = $showMessages->ListAdherantsMessage();
    // debug($articles);
    $slug = $this->model_assos->getSlugByIdAdmin($_SESSION['user']['id']);
    $messages = $showMessages->AfficherMessages();

    $this->show('message/message', array(
      'slug' => $slug,
      'users' => $users,
      'messages' => $messages,
    ));
  } else {
    $this->showForbidden(); // erreur 403
  }
}
/**
* Afficher un message recu
*/
public function getMessage()
{

$this->show('message/message');
}

// ===================================================================================================================
// TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
/**
* Envois d'un message
*/
public function sendMessage()
{
  $newMessages = new MessageModel();
  $message = $newMessages->sendMessages();
  $this->message();
}

/**
* Envois d'un message
*/
public function confirmAssosInvit()
{
$this->show('message/message');
}


}
