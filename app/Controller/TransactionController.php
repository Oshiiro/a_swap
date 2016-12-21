<?php

namespace Controller;

use \Controller\AppController;
use \Model\UsersModel as OurUModel;
use \Model\TransactionModel;

class TransactionController extends AppController
{

  private $transactionModel;

  public function __construct()
  {

    $this->transactionModel = new TransactionModel();
    $this->usersModel = new OurUModel();
  }

  // Affichage du formulaire pour transaction, avec liste des adhérants
  public function ShowFormTransaction() {
    $adherants = $this->usersModel->affAdherants();
    $this->show('transaction/users_transaction', array(
    'adherants' => $adherants
    ));
  }

  public function makeTransaction()
  {
  $newTransactions = $this->transactionModel->MakeTransaction();
  $adherants = $this->usersModel->affAdherants();
  $this->show('transaction/users_transaction', array(
  'newTransactions' => $newTransactions,
  'adherants' => $adherants
  ));
  }



}
