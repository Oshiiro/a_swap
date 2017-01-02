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
    $this->setTable('intermediaire');
  }

// Afficher les transactions de son assocation
  // public function GetTrans()
  // {
  //   $id = $_SESSION['user']['id'];
  //   $sql ="SELECT * FROM transaction
  //   INNER JOIN intermediaire ON (transaction.id_user_buyer = intermediaire.id_users OR transaction.id_user_seller = intermediaire.id_users)
  //   INNER JOIN users ON intermediaire.id_users = users.id
  //   INNER JOIN assos ON intermediaire.id_assos = assos.id
  //   WHERE intermediaire.id_users = :id
  //   LIMIT 10";
  //
  //   $query = $this->dbh->prepare($sql);
  //   $query->bindValue(':id', $id);
  //   $query->execute();
  //   return $query->fetchAll();
  // }

  public function GetTrans()
  {

    $sql ="SELECT COUNT(id) as transNbr FROM transaction
    -- LEFT JOIN users ON (transaction.id_user_seller = users.id AND transaction.id_user_buyer = users.id)
    ";

    $query = $this->dbh->prepare($sql);
    $query->execute();
    $nbre = $query->fetchAll();
    print_r($nbre);

    if(isset($_GET['p'])) {
      $cPage = $_GET['p'];
    } else {
      $cPage = 1;
    }

    $transNbr = $nbre[0]['transNbr'];
    echo $nbre[0]['transNbr'];
    $nbrParPage = 5;
    $nbrPage = ceil($transNbr/$nbrParPage);
    echo $nbrPage;


    /**for($i=1; $i <= $nbrPage ; $i++) {
      echo '<a href= "'. echo $this->url('admin_back').'/'.$i.'"> '.$i.' </a>';
    }**/

    $sql ="SELECT * FROM transaction
    LEFT JOIN users ON (transaction.id_user_seller = users.id AND transaction.id_user_buyer = users.id)
    LIMIT ".(($cPage - 1) * $nbrParPage).",". $nbrParPage ."
    ";

    $query = $this->dbh->prepare($sql);
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


    //Function d'affichage des différents membres de l'association y compris d'admin pour créditation
      public function affAllAdherants()
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
        ";

        $query = $this->dbh->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetchAll();
      }

}
?>
