<?php

namespace Controller;

use \Controller\AppController;
use \Model\MessageModel;
use \Model\AssosModel;
use \Model\BackModel;
use \Model\AvatarModel;
use \Model\UsersModel AS OurUModel;
use \Services\Tools\Tools;
use \Services\Pagination;



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
  * Affichage d'une page "messages reçus"
  * @param int $page_rec Numero de la page a afficher
  */
  public function message($page=1)
  {
    if ($this->tools->isLogged() == true) {
      $showMessages = new MessageModel();
      $users = $showMessages->ListAdherantsMessage();
      $slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);

      $Pagination = new Pagination('private_message');
      //on precise la table a exploiter

      $limit_receiver = 5;
      $id_receiver = $_SESSION['user']['id'];
      //limit d'affichage par page
      $calcule_receiver = $Pagination->calcule_page('id_user_receiver = \''.$id_receiver.'\' AND active_receiver = 1',$limit_receiver,$page);
      //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
      //ce qui calcule le nombre de page total et le offset
      $pagination = $Pagination->pagination($calcule_receiver['page'],$calcule_receiver['nb_page'],'message');
      //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
      $messages = $showMessages->AfficherMessages($limit_receiver,$calcule_receiver['offset']);
      // $avatar = $this->model_avatar->FindLinkForImg('link_relative', 'id_user', $_SESSION['user']['id']);

      $this->show('message/message',
        [
        'pagination'=> $pagination,
        'slug' => $slug,
        'users' => $users,
        'messages' => $messages,
        'page'=> $page,
        // 'avatar' => $avatar,

      ]
      );
    } else {
      $this->showForbidden(); // erreur 403
    }
  }

  /**
  * Affichage d'une page "messages envoyés"
  * @param int $page_sen Numero de la page a afficher
  */
  public function messagesEnvoyes($page =1)
  {
    if ($this->tools->isLogged() == true) {
      $showMessages = new MessageModel();
      $users = $showMessages->ListAdherantsMessage();
      $slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);

      $Pagination = new Pagination('private_message');
      //on precise la table a exploiter


      $limit_sender = 5;
      $id_sender = $_SESSION['user']['id'];
      //limit d'affichage par page
      //on precise la table a exploiter
      $calcule_sender = $Pagination->calcule_page('id_user_sender = \''.$id_sender.'\' AND active_sender = 1',$limit_sender,$page);

      //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
      //ce qui calcule le nombre de page total et le offset
      $pagination2 = $Pagination->pagination($calcule_sender['page'],$calcule_sender['nb_page'],'messages_envoyes');
      //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
      $messagesenvoyes = $showMessages->AfficherMessagesEnvoyes($limit_sender,$calcule_sender['offset']);
      $avatar = $this->model_avatar->FindLinkForImg('link_relative', 'id_user', $_SESSION['user']['id']);
      $this->show('message/messagesenvoyes',
        [
        'pagination2'=> $pagination2,
        'slug' => $slug,
        'users' => $users,
        'messagesenvoyes' => $messagesenvoyes,
        'page'=> $page,
        'avatar' => $avatar,
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
  * @param int $page_rec Numero de la page a afficher
  */
  public function sendMessage($page_rec)
  {
    $newMessages = new MessageModel();
    $message = $newMessages->sendMessages();
    $this->message($page_rec);
  }

  /**
  *  Confirmation d'une invitation
  */
  public function confirmAssosInvit()
  {
  $this->show('message/message');

  }

  /**
  * Suppression d'un message de la boite de reception
  * @param int $page_rec Numero de la page a afficher après traitement
  * @param int $id Id du message à supprimer
  */
  public function DeleteMessageRecu($page, $id)
  {
    $VerifMessage = $this->messageModel->VerifMessageReceiver($page, $id);
    if($VerifMessage === true) {
      $active_receiver = '0';
      $data = array(
        'active_receiver' => $active_receiver,
      );

      $this->messageModel->update($data, $id);

      $this->redirectToRoute('message',['page'=> $page, 'page' => $page]);

    } else {
      $this->showForbidden(); // erreur 403
    }
  }


  /**
  * Suppression d'un message de la boite d'envoi'
  * @param int $page_sen Numero de la page a afficher après traitement
  * @param int $id Id du message à supprimer
  */
  public function DeleteMessageEnvoye($page, $id)
  {
    $VerifMessageS = $this->messageModel->VerifMessageSender($page, $id);
      if($VerifMessageS === true) {

        $active_sender = '0';
        $data = array(
          'active_sender' => $active_sender,
        );

        $this->messageModel->update($data, $id);

        $this->redirectToRoute('messages_envoyes',['page'=> $page, 'page' => $page]);
      } else {
        $this->showForbidden(); // erreur 403
        }
  }


}
