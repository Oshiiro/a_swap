<?php
namespace Model;

use \W\Model\Model;
use \Model\AssosModel;
use \Services\Flash\FlashBags;
use \Controller\AppController;


/**
 *
 */
class MessageModel extends Model
{

  public function __construct()
  {
    parent::__construct();
    $this->setTable('private_message');
  }

  /**
  * Affiche les messages recu par la personne connecté preparés pour la pagination
  * @param int $limit Limit pour la pagination
  * @param int $offset Offset pour la pagination
  * @return array Liste des messages concernés
  */
  public function AfficherMessages($limit, $offset)
  {
    $id = $_SESSION['user']['id'];

    $sql = "SELECT pm.created_at, pm.content, u.username, pm.id, pm.id_user_sender FROM private_message AS pm
            LEFT JOIN users AS u ON pm.id_user_sender = u.id
            WHERE pm.id_user_receiver = :id AND pm.active_receiver = 1
            ORDER BY created_at DESC
            LIMIT $limit OFFSET $offset";
    $affMessages = $this->dbh->prepare($sql);
    $affMessages->bindValue(':id', $id);
    $affMessages->execute();
    return $affMessages->fetchAll();
  }

  /**
  * Affiche les messages envoyés par la personne connecté preparés pour la pagination
  * @param int $limit Limit pour la pagination
  * @param int $offset Offset pour la pagination
  * @return array Liste des messages concernés
  */
  public function AfficherMessagesEnvoyes($limit, $offset)
  {
    $id = $_SESSION['user']['id'];

    $sql = "SELECT pm.created_at, pm.content, u.username, pm.id FROM private_message AS pm
            LEFT JOIN users AS u ON pm.id_user_receiver = u.id
            WHERE pm.id_user_sender = :id AND pm.active_sender = 1
            ORDER BY created_at DESC
            LIMIT $limit OFFSET $offset";
    $affMessages = $this->dbh->prepare($sql);
    $affMessages->bindValue(':id', $id);
    $affMessages->execute();
    return $affMessages->fetchAll();
  }

  /**
  * Récupere la liste des adhérants de l'assos de l'utilisateur connécté, hormis lui même.
  * @return array Liste des adhérants concernés
  */
  public function ListAdherantsMessage()
  {
    $id = $_SESSION['user']['id'];

    $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    $result = $query->fetch();


    $sql = "SELECT * FROM users INNER JOIN intermediaire ON users.id = intermediaire.id_users
    WHERE intermediaire.id_assos = :result AND users.id != :id";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':result', $result['id_assos']);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetchAll();
  }

  /**
  * Fonction pour l'insert pour l'envoi de message privé
  */
  public function sendMessages()
  {

    if(!empty($_POST['destinataire'])) {
      if(!empty($_POST['message'])) {
    $id_sender = $_SESSION['user']['id'];
    $id_receiver = trim(strip_tags($_POST['destinataire']));
    $message = trim(strip_tags($_POST['message']));

          $insMessages = $this->dbh->prepare("INSERT INTO private_message (id_user_sender, id_user_receiver, content, created_at, active_receiver, active_sender) VALUES (:id_sender, :id_receiver, :message, NOW(), 1, 1)");
          $insMessages->bindValue(':id_sender', $id_sender);
          $insMessages->bindValue(':id_receiver', $id_receiver);
          $insMessages->bindValue(':message', $message);
          $insMessages->execute();

          $flash = new FlashBags();
          $flash->setFlash('success', 'Votre message a bien été envoyé!');

      }
      else {
        $flash = new FlashBags();
        $flash->setFlash('danger', 'Veuillez indiquer un message!');
      }
    }
    else {
      $flash = new FlashBags();
      $flash->setFlash('danger', 'Veuillez indiquer un destinataire!');
    }

  }

  /**
  * Fonction pour l'envoie d'une invitation en MP au user
  * @param int $id_receiver Id de l'utilisateur à inviter
  * @param string $token_invitation Token de l'invitation concernée
  */
  public function sendInvitation($id_receiver, $token_invitation)
  {
    $id_sender = $_SESSION['user']['id'];
    // requete pour recup le nom de l'asso.
    $name_asso = AssosModel::getNameByIdAdmin($id_sender);
    $token_asso = AssosModel::getToken($id_sender);

    $appController = new appController();

    $invitation_MP = $appController->generateUrl('accept_invitation', ['token_asso' => $token_asso, 'token_invit' => $token_invitation], true);
    $message =  $_SESSION['user']['firstname']. ' ' .$_SESSION['user']['lastname'].
                ' souhaite vous inviter a rejoindre son association "' .$name_asso. '".
                <a href="' .$invitation_MP. '"> Cliquez ici pour accepter </a>';

    $insMessages = $this->dbh->prepare("INSERT INTO private_message (id_user_sender, id_user_receiver, content, created_at, active_receiver , active_sender)
                                        VALUES (:id_sender, :id_receiver, :message, NOW(), 1, 1)");
    $insMessages->bindValue(':id_sender', $id_sender);
    $insMessages->bindValue(':id_receiver', $id_receiver);
    $insMessages->bindValue(':message', $message);
    $insMessages->execute();
  }

  /**
  * Fonction qui verifie que le message reçu en cours de suppresion appartient bien
  * à l'utilisateur connécté
  * @param int $page_rec Numero de la page pour la pagination
  * @param int $idmessage Id du message à verifier
  * @return boolean true si le message appartient à l'utilisateur connécté, false sinon
  */
  public function VerifMessageReceiver($page_rec,$idmessage)
  {
    $id = $_SESSION['user']['id'];

    $sql = "SELECT id FROM private_message
            WHERE id = $idmessage
            AND id_user_receiver = :id
            ";
    $affMessages = $this->dbh->prepare($sql);
    $affMessages->bindValue(':id', $id);
    $affMessages->execute();
    $verifmessagerec = $affMessages->fetchColumn();
    if($idmessage === $verifmessagerec) {
      return true;
    } else {
      return false;
    }
  }

  /**
  * Fonction qui verifie que le message envoyé en cours de suppresion appartient bien
  * à l'utilisateur connécté
  * @param int $page_sen Numero de la page pour la pagination
  * @param int $idmessage Id du message à verifier
  * @return boolean true si le message appartient à l'utilisateur connécté, false sinon
  */
  public function VerifMessageSender($page_sen, $idmessage)
  {
    $id = $_SESSION['user']['id'];

    $sql = "SELECT id FROM private_message
            WHERE id = $idmessage
            AND id_user_sender = :id
            ";
    $affMessages = $this->dbh->prepare($sql);
    $affMessages->bindValue(':id', $id);
    $affMessages->execute();
    $verifmessagesender = $affMessages->fetch();

    if($idmessage === $verifmessagesender['id']) {
      return true;
    } else {
      return false;
    }
  }



}
