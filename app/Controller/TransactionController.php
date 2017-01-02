<?php

namespace Controller;

use \Controller\AppController;
use \Model\UsersModel as OurUModel;
use \Model\TransactionModel;
use \Model\BackModel;

class TransactionController extends AppController
{

  private $transactionModel;

  public function __construct()
  {

    $this->transactionModel = new TransactionModel();
    $this->usersModel = new OurUModel();
    $this->backmodel = new BackModel();
  }

  // Affichage du formulaire pour transaction, avec liste des adhérants
  public function ShowFormTransaction() {
    $adherants = $this->backmodel->affAdherants();
    $this->show('transaction/users_transaction', array(
    'adherants' => $adherants
    ));
  }

  public function makeTransactionUser()
  {
  $newTransac = $this->transactionModel->makeTransactionUser();
  $adherants = $this->backmodel->affAdherants();
  $this->show('transaction/users_transaction', array(
  'newTransac' => $newTransac,
  'adherants' => $adherants
  ));
  }



}
