<?php

namespace Controller;

use \Controller\AppController;
use \Model\MessageModel;
use \Model\AssosModel;
use \Model\BackModel;
use \Model\UsersModel AS OurUModel;
use \Services\Tools\Tools;
use \Services\PaginationDuo;



class MessageController extends AppController
{
  private $tools;
  private $model_assos;

  public function __construct()
	{
		$this->tools = new Tools();
    $this->model_assos = new AssosModel();
    $this->backmodel = new BackModel();
    $this->OurUModel = new OurUModel();
    $this->messageModel = new MessageModel();

  }

// ===================================================================================================================
// AFFICHAGE DES PAGES
// ===================================================================================================================
/**
* Page de messagerie
*/
  public function message($page_rec = 1,$page_sen = 1)
  {
    if ($this->tools->isLogged() == true) {
      $showMessages = new MessageModel();
      $users = $showMessages->ListAdherantsMessage();
      $slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);



      $limit_receiver = 3;
      $id_receiver = $_SESSION['user']['id'];
      //limit d'affichage par page
      $Pagination = new PaginationDuo('private_message');
      //on precise la table a exploiter
      $calcule_receiver = $Pagination->calcule_page('id_user_receiver = \''.$id_receiver.'\'',$limit_receiver,$page_rec);
      //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
      //ce qui calcule le nombre de page total et le offset
      $affichage_pagination_receiver = $Pagination->pagination($calcule_receiver['page'],'page_rec',$calcule_receiver['nb_page'],'message',['page_rec' =>$page_rec]);
      //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
      $messages = $showMessages->AfficherMessages($limit_receiver,$calcule_receiver['offset']);

      $limit_sender = 3;
      $id_sender = $_SESSION['user']['id'];
      //limit d'affichage par page
      //on precise la table a exploiter
      $calcule_sender = $Pagination->calcule_page('id_user_sender = \''.$id_sender.'\'',$limit_sender,$page_sen);
      //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
      //ce qui calcule le nombre de page total et le offset
      $affichage_pagination_sender = $Pagination->pagination($calcule_sender['page'],'page_sen',$calcule_sender['nb_page'],'message',['page_sen' =>$page_sen]);
      //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
      $messagesenvoyes = $showMessages->AfficherMessagesEnvoyes($limit_sender,$calcule_sender['offset']);



      $this->show('message/message',
        [
        'pagination_receiver'=> $affichage_pagination_receiver,
        'pagination_sender'=> $affichage_pagination_sender,
        'slug' => $slug,
        'users' => $users,
        'messages' => $messages,
        'messagesenvoyes' => $messagesenvoyes,
        'page_rec'=> $page_rec,
        'page_sen' => $page_sen
      ]
      );
    } else {
      $this->showForbidden(); // erreur 403
    }
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

  /**
  * Supprimer un message
  */
  public function DeleteMessage($page_rec, $page_sen, $id)
  {

    $active = '0';
    $data = array(
      'active' => $active,);

    $this->messageModel->update($data, $id);


  // $SupprimerMessage = $deleteMessage->DeleteMessage();
  $this->redirectToRoute('message',['page_rec'=> $page_rec, 'page_sen' => $page_sen]);
  }


}
