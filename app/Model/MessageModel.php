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


}
