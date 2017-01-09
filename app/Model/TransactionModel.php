<?php
namespace Model;

use \W\Model\Model;
use \Services\Flash\FlashBags;

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

  /**
  * Insert d'une transaction pour admin
  */
  public function MakeTransactionAdmin() {


      $id_buyer = $_SESSION['user']['id'];
      $id_seller = trim(strip_tags($_POST['destinataire']));
      $sum = trim(strip_tags($_POST['sum']));
      $description = trim(strip_tags($_POST['description']));

      // Récuperer l'id de l'assos en cours
      $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id_user_buyer";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':id_user_buyer', $id_buyer);
      $query->execute();
      $id_asso = $query->fetch();

      $sql = "SELECT wallet FROM intermediaire WHERE id_users = :id_user_buyer";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':id_user_buyer', $id_buyer);
      $query->execute();
      $montant = $query->fetch();


        if ($_POST['sum'] > 0) {

      // verifier que le buyer a assez de fond pour transferer de l'argent
        if($montant['wallet'] >= $sum) {
      // Insersion dans transaction
        $sql ="INSERT INTO transaction (`id_user_buyer`, `id_user_seller`, `id_asso`,`sum`, `description`, `created_at`) VALUES (:id_user_buyer, :id_user_seller, :id_asso, :sum, :description, NOW())";
        $query = $this->dbh->prepare($sql);
        $query->bindValue(':description', $description);
        $query->bindValue(':id_user_buyer', $id_buyer);
        $query->bindValue(':id_user_seller', $id_seller);
        $query->bindValue(':id_asso', $id_asso['id_assos']);
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


      // Update du portfeuille -
        $sql = "UPDATE intermediaire SET wallet = wallet - :sum
        WHERE id_users = :id_user_buyer
        ";
        $query = $this->dbh->prepare($sql);
        $query->bindValue(':id_user_buyer', $id_buyer);
        $query->bindValue(':sum', $sum);
        $query->execute();

        $flash = new FlashBags();
        $flash->setFlash('success', 'Transaction effectuée');

      } else
        {
          $flash = new FlashBags();
          $flash->setFlash('danger', 'Vous n\'avez pas assez de crédit');
        }
      } else {
        $flash = new FlashBags();
        $flash->setFlash('danger', 'Veuillez indiquer un chiffre supérieur à 0.');
      }
  } // MakeTransaction

  /**
  * Insert d'une transaction pour admin
  */
  public function MakeCreditAdmin() {

      $id_buyer = $_SESSION['user']['id'];
      $id_seller = trim(strip_tags($_POST['destinataire']));
      $sum = trim(strip_tags($_POST['sum']));
      $description = trim(strip_tags($_POST['description']));

      // Récuperer l'id de l'assos en cours
      $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id_user_buyer";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':id_user_buyer', $id_buyer);
      $query->execute();
      $id_asso = $query->fetch();

        if ($_POST['sum'] > 0) {

      // Insersion dans transaction
        $sql ="INSERT INTO transaction (`id_user_buyer`, `id_user_seller`, `id_asso`, `sum`, `description`, `created_at`) VALUES (:id_user_buyer, :id_user_seller, :id_asso, :sum, :description, NOW())";
        $query = $this->dbh->prepare($sql);
        $query->bindValue(':description', $description);
        $query->bindValue(':id_user_buyer', $id_buyer);
        $query->bindValue(':id_asso', $id_asso['id_assos']);
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

        $flash = new FlashBags();
        $flash->setFlash('success', 'L\'utilisateur a bien été crédité');

        } else {
          $flash = new FlashBags();
          $flash->setFlash('danger', 'Veuillez indiquer un chiffre supérieur à 0.');
        }

  } // MakeTransaction

  /**
  * Insert d'une transaction pour un utilisateur
  */
  public function makeTransactionUser() {


      $id_buyer = $_SESSION['user']['id'];
      $id_seller = trim(strip_tags($_POST['destinataire']));
      $sum = trim(strip_tags($_POST['sum']));
      $description = trim(strip_tags($_POST['description']));

      // Récuperer l'id de l'assos en cours
      $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id_user_buyer";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':id_user_buyer', $id_buyer);
      $query->execute();
      $id_asso = $query->fetch();

      $sql = "SELECT wallet FROM intermediaire WHERE id_users = :id_user_buyer";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':id_user_buyer', $id_buyer);
      $query->execute();
      $montant = $query->fetch();


        if ($_POST['sum'] > 0) {

      // verifier que le buyer a assez de fond pour transferer de l'argent
        if($montant['wallet'] >= $sum) {
      // Insersion dans transaction
        $sql ="INSERT INTO transaction (`id_user_buyer`, `id_user_seller`, `id_asso`,`sum`, `description`, `created_at`) VALUES (:id_user_buyer, :id_user_seller, :id_asso, :sum, :description, NOW())";
        $query = $this->dbh->prepare($sql);
        $query->bindValue(':description', $description);
        $query->bindValue(':id_user_buyer', $id_buyer);
        $query->bindValue(':id_user_seller', $id_seller);
        $query->bindValue(':id_asso', $id_asso['id_assos']);
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


      // Update du portfeuille -
        $sql = "UPDATE intermediaire SET wallet = wallet - :sum
        WHERE id_users = :id_user_buyer
        ";
        $query = $this->dbh->prepare($sql);
        $query->bindValue(':id_user_buyer', $id_buyer);
        $query->bindValue(':sum', $sum);
        $query->execute();

        $flash = new FlashBags();
        $flash->setFlash('success', 'Transaction effectuée');

      } else
        {
          $flash = new FlashBags();
          $flash->setFlash('danger', 'Vous n\'avez pas assez de crédit');
        }
      } else {
        $flash = new FlashBags();
        $flash->setFlash('danger', 'Veuillez indiquer un chiffre supérieur à 0.');
      }
  } // MakeTransaction
} // Class
