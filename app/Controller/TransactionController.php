<?php

namespace Controller;

use \Controller\AppController;
use \Model\UsersModel as OurUModel;
use \Model\TransactionModel;
use \Model\BackModel;
use \Model\AssosModel;

class TransactionController extends AppController
{

  private $transactionModel;

  public function __construct()
  {

    $this->transactionModel = new TransactionModel();
    $this->usersModel = new OurUModel();
    $this->backmodel = new BackModel();
    $this->AssosModel = new AssosModel();
  }

  // Affichage du formulaire pour transaction, avec liste des adhérants
  public function ShowFormTransaction() {
    $slug = $this->AssosModel->getSlugByIdUser($_SESSION['user']['id']);
    $adherants = $this->usersModel->affAdherants($slug);
    $this->show('transaction/users_transaction', array(
    'adherants' => $adherants,
    'slug' => $slug

    ));
  }

  public function makeTransactionUser()
  {
  $slug = $this->AssosModel->getSlugByIdUser($_SESSION['user']['id']);
  $newTransac = $this->transactionModel->makeTransactionUser();
  $adherants = $this->usersModel->affAdherants($slug);
  $this->show('transaction/users_transaction', array(
  'newTransac' => $newTransac,
  'adherants' => $adherants,
  'slug' => $slug


  ));
  }



}
