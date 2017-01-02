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



  public function GetTrans()
  {
// ----------------------- PAGINATION -----------------------------
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
    $nbrParPage = 10;
    $nbrPage = ceil($transNbr/$nbrParPage);
    echo $nbrPage;


    // for($i=1; $i <= $nbrPage ; $i++) {
    //   echo '<a href= "'. echo $this->url('admin_back').'/'.$i.'"> '.$i.' </a>';
    // }

    // $sql ="SELECT description, sum, username FROM users
    // INNER JOIN transaction ON transaction.id_user_buyer = users.id
    // LIMIT ".(($cPage - 1) * $nbrParPage).",". $nbrParPage ."
    // ";

    $sql = "SELECT assos.name,transaction.created_at, transaction.sum,transaction.description ,userbuyer.username as username_buyer,userseller.username as username_seller FROM transaction
            LEFT JOIN users as userbuyer ON transaction.id_user_buyer = userbuyer.id
            LEFT JOIN users as userseller ON transaction.id_user_seller = userseller.id
            LEFT JOIN assos ON transaction.id_asso = assos.id

    ";

    $query = $this->dbh->prepare($sql);
    $query->execute();
    return $query->fetchAll();

    // SELECT id, prenom, nom, date_achat, num_facture, prix_total
    // FROM utilisateur
    // INNER JOIN commande ON utilisateur.id = commande.utilisateur_id

  }

  // Afficher liste des adhérerants y compris l'admin
    public function affAllAdherants()
    {
  // Recuperation de l'idée de l'assos via l'id user de la session
      $id = $_SESSION['user']['id'];

      $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':id', $id);
      $query->execute();
      $result = $query->fetch();


      $sql = "SELECT * FROM users INNER JOIN intermediaire ON users.id = intermediaire.id_users
      WHERE intermediaire.id_assos = :result";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':result', $result['id_assos']);
      $query->execute();
      return $query->fetchAll();
    }

// Afficher liste des adhérerants sauf l'admin
  public function affAdherants()
  {
// Recuperation de l'idée de l'assos via l'id user de la session
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


    //Function d'affichage de l'adhérant choisis par l'admin pour une créditation
      public function affOneAdherants($id)
      {
        // Recuperation de l'idée de l'assos via l'id user de la session
            $id_session = $_SESSION['user']['id'];


            $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id";
            $query = $this->dbh->prepare($sql);
            $query->bindValue(':id', $id_session);
            $query->execute();
            $result = $query->fetch();


          // $sql = "SELECT * FROM users INNER JOIN intermediaire ON users.id = intermediaire.id_users
          // WHERE intermediaire.id_assos = :result";
          //   $query = $this->dbh->prepare($sql);
          //   $query->bindValue(':result', $result['id_assos']);
          //   $query->execute();
          //   return $query->fetchAll();

            $sql = "SELECT * FROM users
            WHERE id = :id";
              $query = $this->dbh->prepare($sql);
              $query->bindValue(':id', $id);
              $query->execute();
              return $query->fetchAll();
      }

}
?>
