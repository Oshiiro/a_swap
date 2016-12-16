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

      $affMessages = $this->dbh->prepare("SELECT * FROM private_message
              WHERE id_user_sender = :id OR id_user_receiver = :id
              LEFT JOIN users ON private_message.id_user_receiver = users.id");
      $affMessages->bindValue(':id', $id);
      $affMessages->execute();
      return $affMessages->fetchAll();
    }
}
