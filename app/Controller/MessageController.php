<?php

namespace Controller;

use \Controller\AppController;
use \Model\MessageModel;
use \Model\AssosModel;
use \Model\BackModel;
use \Model\AvatarModel;
use \Model\UsersModel AS OurUModel;
use \Services\Tools\Tools;
use \Services\PaginationDuo;



class MessageController extends AppController
{
  private $tools;
  private $model_assos;
  private $model_avatar;


  public function __construct()
	{
		$this->tools = new Tools();
    $this->model_assos = new AssosModel();
    $this->backmodel = new BackModel();
    $this->OurUModel = new OurUModel();
    $this->messageModel = new MessageModel();
    $this->model_avatar = new AvatarModel();


  }

// ===================================================================================================================
// AFFICHAGE DES PAGES
// ===================================================================================================================
/**
* Page de messagerie
*/
  public function message($page_rec)
  {
    if ($this->tools->isLogged() == true) {
      $showMessages = new MessageModel();
      $users = $showMessages->ListAdherantsMessage();
      $slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);

      $Pagination = new PaginationDuo('private_message');
      //on precise la table a exploiter

      $limit_receiver = 3;
      $id_receiver = $_SESSION['user']['id'];
      //limit d'affichage par page
      $calcule_receiver = $Pagination->calcule_page('id_user_receiver = \''.$id_receiver.'\'',$limit_receiver,$page_rec);
      //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
      //ce qui calcule le nombre de page total et le offset
      $pagination = $Pagination->pagination($calcule_receiver['page'],'page_rec',$calcule_receiver['nb_page'],'message',['page_rec' =>$page_rec]);
      //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
      $messages = $showMessages->AfficherMessages($limit_receiver,$calcule_receiver['offset']);
      $avatar = $this->model_avatar->FindLinkForImg('link_relative', 'id_user', $_SESSION['user']['id']);

      $this->show('message/message',
        [
        'pagination'=> $pagination,
        'slug' => $slug,
        'users' => $users,
        'messages' => $messages,
        'page_rec'=> $page_rec,
        'avatar' => $avatar,

      ]
      );
    } else {
      $this->showForbidden(); // erreur 403
    }
  }

  /**
  * Page de messagerie
  */
    public function messagesEnvoyes($page_sen)
    {
      if ($this->tools->isLogged() == true) {
        $showMessages = new MessageModel();
        $users = $showMessages->ListAdherantsMessage();
        $slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);

        $Pagination = new PaginationDuo('private_message');
        //on precise la table a exploiter


        $limit_sender = 3;
        $id_sender = $_SESSION['user']['id'];
        //limit d'affichage par page
        //on precise la table a exploiter
        $calcule_sender = $Pagination->calcule_page2('id_user_sender = \''.$id_sender.'\'',$limit_sender,$page_sen);

        //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
        //ce qui calcule le nombre de page total et le offset
        $pagination2 = $Pagination->pagination($calcule_sender['page'],'page_sen',$calcule_sender['nb_page'],'messages_envoyes',['page_sen' =>$page_sen]);
        //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
        $messagesenvoyes = $showMessages->AfficherMessagesEnvoyes($limit_sender,$calcule_sender['offset']);
        $this->show('message/messagesenvoyes',
          [
          'pagination2'=> $pagination2,
          'slug' => $slug,
          'users' => $users,
          'messagesenvoyes' => $messagesenvoyes,
          'page_sen'=> $page_sen,

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
  public function sendMessage($page_rec)
  {
    $newMessages = new MessageModel();
    $message = $newMessages->sendMessages();
    $this->message($page_rec);
  }

  /**
  * Envois d'un message
  */
  public function confirmAssosInvit()
  {
  $this->show('message/message');
  }

  /**
  * Supprimer un message recu
  */
  public function DeleteMessageRecu($page_rec, $id)
  {
    $VerifMessage = $this->messageModel->VerifMessageReceiver($page_rec, $id);
    if($VerifMessage === true) {
      $active_receiver = '0';
      $data = array(
        'active_receiver' => $active_receiver,
      );

      $this->messageModel->update($data, $id);

      $this->redirectToRoute('message',['page_rec'=> $page_rec, 'page_sen' => $page_sen]);

    } else {
      $this->showForbidden(); // erreur 403
    }
  }


  /**
  * Supprimer un message envoyé
  */
  public function DeleteMessageEnvoye($page_sen, $id)
  {
    $VerifMessageS = $this->messageModel->VerifMessageSender($page_sen, $id);
      if($VerifMessageS === true) {

        $active_sender = '0';
        $data = array(
          'active_sender' => $active_sender,
        );

        $this->messageModel->update($data, $id);

        $this->redirectToRoute('message',['page_rec'=> $page_rec, 'page_sen' => $page_sen]);
      } else {
        $this->showForbidden(); // erreur 403
        }
  }


}
