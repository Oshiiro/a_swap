<?php

namespace Controller;

use \Controller\AppController;
use \Model\TransactionModel;
use \Model\BackModel;


class TransactionAdminController extends AppController
{

  private $transactionModel;

  public function __construct()
  {

    $this->transactionModel = new TransactionModel();
    $this->backModel = new backModel();
  }

// Affichage du formulaire pour transaction, alors liste des adhérants
  public function ShowFormTransaction() {
    $adherants = $this->backModel->affAdherants();
    $this->show('transaction/admin_transaction', array(
    'adherants' => $adherants
    ));
  }

  public function makeTransactionAdmin()
  {
  $newTransactions = $this->transactionModel->MakeTransactionAdmin();
  $adherants = $this->backModel->affAdherants();
  $this->show('transaction/admin_transaction', array(
  'newTransactions' => $newTransactions,
  'adherants' => $adherants
  ));
  }


} // Class
