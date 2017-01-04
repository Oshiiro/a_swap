<?php

namespace Controller;

use \Controller\AppController;
use \Model\TransactionModel;
use \Model\BackModel;
use \Model\AssosModel;

class TransactionAdminController extends AppController
{

  private $transactionModel;
  private $model_assos;


  public function __construct()
  {
    $this->transactionModel = new TransactionModel();
    $this->backModel = new backModel();
    $this->model_assos = new AssosModel();
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
    $adherants = $this->backModel->affOneAdherants($id_seller);
    $slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);

    $this->show('transaction/admin_credit', array(
      'adherants' => $adherants,
      'slug' => $slug,
    ));
  }

  public function makeCreditAdmin()
  {
    $newTransactions = $this->transactionModel->MakeCreditAdmin();
    $adherants = $this->backModel->affOneAdherants($_POST['destinataire']);
    $this->show('transaction/admin_credit', array(
    'newTransactions' => $newTransactions,
    'adherants' => $adherants,

    ));
  }


} // Class
