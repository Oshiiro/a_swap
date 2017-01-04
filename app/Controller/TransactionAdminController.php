<?php

namespace Controller;

use \Controller\AppController;
use \Model\TransactionModel;
use \Model\BackModel;
use \Model\UsersModel as OurUModel;


class TransactionAdminController extends AppController
{

  private $transactionModel;

  public function __construct()
  {

    $this->transactionModel = new TransactionModel();
    $this->backModel = new backModel();
    $this->ourumodel = new OurUModel();
  }

// Affichage du formulaire pour transaction, alors liste des adhérants

  // public function ShowFormTransaction() {
  //   $adherants = $this->backModel->affAdherants();
  //   $this->show('transaction/admin_transaction', array(
  //   'adherants' => $adherants
  //   ));
  // }
  //
  // public function makeTransactionAdmin()
  // {
  // $newTransactions = $this->transactionModel->MakeTransactionAdmin();
  // $adherants = $this->backModel->affAdherants();
  // $this->show('transaction/admin_transaction', array(
  // 'newTransactions' => $newTransactions,
  // 'adherants' => $adherants
  // ));
  // }

  public function ShowFormCredit($id_seller) {
    $adherants = $this->ourumodel->affOneAdherants($id_seller);
    $this->show('transaction/admin_credit', array(
    'adherants' => $adherants
    ));
  }

  public function makeCreditAdmin()
  {
    $newTransactions = $this->transactionModel->MakeCreditAdmin();
    $adherants = $this->ourumodel->affOneAdherants($_POST['destinataire']);
    $this->show('transaction/admin_credit', array(
    'newTransactions' => $newTransactions,
    'adherants' => $adherants,

    ));
  }


} // Class
