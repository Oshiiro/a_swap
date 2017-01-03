<?php

namespace Controller;

use \Controller\AppController;
use \Model\MessageModel;
use \Model\UsersModel AS OurUModel;

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
$showMessages = new MessageModel();
  $users = $showMessages->ListAdherantsMessage();
  // debug($articles);

  $messages = $showMessages->AfficherMessages();
  $messagesenvoyes = $showMessages->AfficherMessagesEnvoyes();


  $this->show('message/message', array(
    'users' => $users,
    'messages' => $messages,
    'messagesenvoyes' => $messagesenvoyes
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
