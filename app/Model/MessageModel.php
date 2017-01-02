<?php
namespace Model;

use \W\Model\Model;
use \Model\AssosModel;
use \Services\Flash\FlashBags;


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


    // Affiche les messages envoyer, et recu par la personne connecté
    public function AfficherMessages()
    {
    $id = $_SESSION['user']['id'];

      $affMessages = $this->dbh->prepare("SELECT * FROM private_message AS pm
        LEFT JOIN users AS u ON pm.id_user_receiver = u.id
        WHERE (pm.id_user_sender = :id OR pm.id_user_receiver = :id)
              AND pm.active = 1");
      $affMessages->bindValue(':id', $id);
      $affMessages->execute();
      return $affMessages->fetchAll();

    }

    // Récuperer la liste des adhérants de l'assos, hormis lui même.
    public function OurfindAll()
    {
      // Recuperation de l'idée de l'assos via l'id user de la session
          $id = $_SESSION['user']['id'];
          $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id";
          $query = $this->dbh->prepare($sql);
          $query->bindValue(':id', $id);
          $result = $query->execute();

      // Recuperer les users dont le id assos est égal à celui de l'user connecté
          $sql ="SELECT * FROM users
          LEFT JOIN intermediaire ON intermediaire.id_users = users.id
          WHERE intermediaire.id_assos = $result
          AND users.id != $id
          ";

          $query = $this->dbh->prepare($sql);
          $query->bindValue(':id', $id);
          $query->execute();
          return $query->fetchAll();

    }


    // Insert envoi de message privé
    public function sendMessages()
    {

      if(!empty($_POST['destinataire'])) {
        if(!empty($_POST['message'])) {
      $id_sender = $_SESSION['user']['id'];
      $id_receiver = trim(strip_tags($_POST['destinataire']));
      $message = trim(strip_tags($_POST['message']));

            $insMessages = $this->dbh->prepare("INSERT INTO private_message (id_user_sender, id_user_receiver, content, created_at) VALUES (:id_sender, :id_receiver, :message, NOW())");
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

  // Fonction qui envoie une invitation en MP au user dont l'id est passé en argument a rejoindre l'asso.
  public function sendInvitation($id_receiver, $token_invitation)
  {
    $id_sender = $_SESSION['user']['id'];
    // requete pour recup le nom de l'asso.
    $name_asso = AssosModel::getNameByIdAdmin($id_sender);
    $token_asso = AssosModel::getToken($id_sender);

    $message =  $_SESSION['user']['firstname']. ' ' .$_SESSION['user']['lastname'].
                ' souhaite vous inviter a rejoindre son association "' .$name_asso. '".
                <a href="http://localhost/a_swap/public/acceptinvitation/' .$token_asso. '/' .$token_invitation. '"> Cliquez ici pour accepter </a>';
                // ajoute-t-on un boutton pour refuser ? si oui, il faudra certainement
                // rajouter une colone "active" a la table "private-message"
                // ou delete le private_message.

    $insMessages = $this->dbh->prepare("INSERT INTO private_message (id_user_sender, id_user_receiver, content, created_at)
                                        VALUES (:id_sender, :id_receiver, :message, NOW())");
    $insMessages->bindValue(':id_sender', $id_sender);
    $insMessages->bindValue(':id_receiver', $id_receiver);
    $insMessages->bindValue(':message', $message);
    $insMessages->execute();
  }

}
