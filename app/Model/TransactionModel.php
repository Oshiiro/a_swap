<?php
namespace Model;

use \W\Model\Model;

/**
 *
 */
class TransactionModel extends Model
{

  function __construct()
  {
    parent::__construct();
    $this->setTable('transaction');
  }

// Transaction pour admin
public function MakeTransactionAdmin() {

  // debug($_POST['destinataire']);
  if(!empty($_POST['submit'])) {

    $id_buyer = $_SESSION['user']['id'];
    $id_seller = trim(strip_tags($_POST['destinataire']));
    $sum = trim(strip_tags($_POST['sum']));
    $description = trim(strip_tags($_POST['description']));

      if($_POST['sum'] > 0) {

    // Insersion dans transaction
      $sql ="INSERT INTO transaction (`id_user_buyer`, `id_user_seller`, `sum`, `description`, `created_at`) VALUES (:id_user_buyer, :id_user_seller, :sum, :description, NOW())";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':description', $description);
      $query->bindValue(':id_user_buyer', $id_buyer);
      $query->bindValue(':id_user_seller', $id_seller);
      $query->bindValue(':sum', $sum);
      $query->execute();
    //  Upadate du portfeuille +
      $sql = "UPDATE intermediaire SET wallet = wallet + :sum
      WHERE id_users = :id_user_seller
      ";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':id_user_seller', $id_seller);
      $query->bindValue(':sum', $sum);
      $query->execute();

    } else {
     echo 'Veuillez indiquer un montant supérieur à 0.';
    }
  } else {
    echo 'Veuillez indiquer un montant supérieur à 0.';
  }
} // MakeTransaction



// Transaction pour users
  public function makeTransactionUser() {

    // debug($_POST['destinataire']);

    if(!empty($_POST['submit'])) {

      $id_buyer = $_SESSION['user']['id'];
      $id_seller = trim(strip_tags($_POST['destinataire']));
      $sum = trim(strip_tags($_POST['sum']));
      $description = trim(strip_tags($_POST['description']));

      $sql = "SELECT wallet FROM intermediaire WHERE id_users = :id_user_buyer";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':id_user_buyer', $id_buyer);
      $query->execute();
      $montant = $query->fetch();

        if ($_POST['sum'] > 0) {

      // verifier que le buyer a assez de fond pour transferer de l'argent
        if($montant['wallet'] >= $sum) {
      // Insersion dans transaction
        $sql ="INSERT INTO transaction (`id_user_buyer`, `id_user_seller`, `sum`, `description`, `created_at`) VALUES (:id_user_buyer, :id_user_seller, :sum, :description, NOW())";
        $query = $this->dbh->prepare($sql);
        $query->bindValue(':description', $description);
        $query->bindValue(':id_user_buyer', $id_buyer);
        $query->bindValue(':id_user_seller', $id_seller);
        $query->bindValue(':sum', $sum);
        $query->execute();
      //  Upadate du portfeuille +
        $sql = "UPDATE intermediaire SET wallet = wallet + :sum
        WHERE id_users = :id_user_seller
        ";
        $query = $this->dbh->prepare($sql);
        $query->bindValue(':id_user_seller', $id_seller);
        $query->bindValue(':sum', $sum);
        $query->execute();
        debug(($_POST['destinataire']));

      // Update du portfeuille -
        $sql = "UPDATE intermediaire SET wallet = wallet - :sum
        WHERE id_users = :id_user_buyer
        ";
        $query = $this->dbh->prepare($sql);
        $query->bindValue(':id_user_buyer', $id_buyer);
        $query->bindValue(':sum', $sum);
        $query->execute();



      } else
        {
          echo 'Pas assez de sousou mon ti pere';
        }

      } else {
        echo 'Veuillez indiquer un chiffre supérieur à 0.';
      }
    } // Submit
  } // MakeTransaction


} // Class
