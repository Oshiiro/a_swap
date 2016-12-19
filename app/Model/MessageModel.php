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

    public function AfficherMessages() {
    $id = $_SESSION['user']['id'];
    debug($id);

      $affMessages = $this->dbh->prepare("SELECT * FROM private_message AS pm
        LEFT JOIN users AS u ON pm.id_user_receiver = u.id
        WHERE (pm.id_user_sender = :id OR pm.id_user_receiver = :id)
              ");
      $affMessages->bindValue(':id', $id);
      $affMessages->execute();
      return $affMessages->fetchAll();

    }

    public function sendMessages() {

    debug($_POST['destinataire']);
    $id = $_SESSION['user']['id'];
    if(!empty($_POST['submit'])) {
      $id_sender = trim(strip_tags($_POST['destinataire']));
      $id_receiver = trim(strip_tags($_POST['message']));

            $insMessages - $this->dbh->prepare("INSERT INTO private message (`id_user_sender`, `id_user_receiver`, `content`, `created_at`) VALUES (:id_user, :id_receiver, :message, NOW())");
            $insMessages->bindValue(':id_user', $id_sender);
            $insMessages->bindValue(':id_receiver', $id_receiver);
            $insMessages->execute();


    }
  }



}
