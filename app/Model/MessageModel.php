<?php
namespace Model;

use \W\Model\Model;


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
              ");
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

    if(!empty($_POST['submit'])) { //pas utile avec les routes !!!
      if(!empty($_POST['destinataire'])) {
      $id_sender = $_SESSION['user']['id'];
      $id_receiver = trim(strip_tags($_POST['destinataire']));
      $message = trim(strip_tags($_POST['message']));

            $insMessages = $this->dbh->prepare("INSERT INTO private_message (id_user_sender, id_user_receiver, content, created_at) VALUES (:id_sender, :id_receiver, :message, NOW())");
            $insMessages->bindValue(':id_sender', $id_sender);
            $insMessages->bindValue(':id_receiver', $id_receiver);
            $insMessages->bindValue(':message', $message);
            $insMessages->execute();

      }
    }
  }

  // Fonction qui envoie une invitation a rejoindre une asso en MP.
  public function sendInvitation()
  {
    $id_sender = $_SESSION['user']['id'];
    $id_receiver = 'TOTO';
    $message =  $_SESSION['user']['firstname']. ' ' .$_SESSION['user']['lastname'].
                ' souhaite vous inviter a rejoindre son association "(nom de l assos)". <a href=""> Cliquez ici pour accepter </a>';

    $insMessages = $this->dbh->prepare("INSERT INTO private_message (id_user_sender, id_user_receiver, content, created_at)
                                        VALUES (:id_sender, :id_receiver, :message, NOW())");
    $insMessages->bindValue(':id_sender', $id_sender);
    $insMessages->bindValue(':id_receiver', $id_receiver);
    $insMessages->bindValue(':message', $message);
    $insMessages->execute();
  }

}
