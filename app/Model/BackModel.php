<?php
namespace Model;

use \W\Model\Model;
use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

class BackModel extends UModel
{
  private $backmodel;

  public function __construct()
  {
    parent::__construct();
    $this->setTable('transaction');
    $this->setTable('assos');
  }

// Afficher les transactions de son assocation
  public function GetTrans()
  {
    $id = $_SESSION['user']['id'];
    $sql ="SELECT * FROM transaction, intermediaire
    LEFT JOIN users ON intermediaire.id_users = users.id
    LEFT JOIN assos ON intermediaire.id_assos = assos.id
    WHERE intermediaire.id_users = :id
    LIMIT 10";

    $query = $this->dbh->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetchAll();
  }

  public function affAdherants()
  {
// Recuperation de l'idée de l'assos via l'id user de la session
    $id = $_SESSION['user']['id'];
    $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':id', $id);
    $result = $query->execute();

// Recuperer les users dont le id assos est égal à celui de l'admin
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


}
?>
