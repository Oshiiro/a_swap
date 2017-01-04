<?php

namespace Controller;

use \Controller\AppController;
use \Model\MessageModel;
use \Model\AssosModel;
use \Model\BackModel;
use \Model\UsersModel AS OurUModel;
use \Services\Tools\Tools;
use \Services\Pagination;

class MessageController extends AppController
{
  private $tools;
  private $model_assos;

  public function __construct()
	{
		$this->tools = new Tools();
    $this->model_assos = new AssosModel();
    $this->backmodel = new BackModel();
  }

// ===================================================================================================================
// AFFICHAGE DES PAGES
// ===================================================================================================================
/**
* Page de messagerie
*/
  public function message($page = 1)
  {
    if ($this->tools->isLogged() == true) {
      $showMessages = new MessageModel();
      $users = $showMessages->ListAdherantsMessage();
      // debug($articles);
      $slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);
      $messages = $showMessages->AfficherMessages();
      $messagesenvoyes = $showMessages->AfficherMessagesEnvoyes();

      $limit = 5;
      $id_asso = $this->model_assos->FindElementByElement('id', 'slug', $slug);
      //limit d'affichage par page
      $Pagination = new Pagination('private_message');
      //on precise la table a exploiter
      $calcule = $Pagination->calcule_page('id = \''.$id_asso.'\'',$limit,$page);
      //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
      //ce qui calcule le nombre de page total et le offset
      $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],'message',['slug'=>$slug]);
      //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
      $trans = $this->backmodel->GetTransTempo($id_asso,$limit,$calcule['offset']);
      $this->show('message/message',
        [
        'pagination'=> $affichage_pagination,
        'slug' => $slug,
        'users' => $users,
        'messages' => $messages,
        'messagesenvoyes' => $messagesenvoyes
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


}
