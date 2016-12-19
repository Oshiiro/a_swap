<?php

namespace Controller;

use \Controller\AppController;
use \Model\MessageModel;
use \Model\UsersModel;

class MessageController extends AppController
{


// ===================================================================================================================
// AFFICHAGE DES PAGES
// ===================================================================================================================
/**
* Page de messagerie
*/
public function message()
{
$UsersModel = new UsersModel();
$users = $UsersModel->findAll();
// debug($articles);

$showMessages = new MessageModel();
$messages = $showMessages->AfficherMessages();

$this->show('message/message', array(
'users' => $users,
'messages' => $messages

));
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
