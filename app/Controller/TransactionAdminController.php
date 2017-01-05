<?php

namespace Controller;

use \Controller\AppController;
use \Model\TransactionModel;
use \Model\BackModel;
use \Model\UsersModel as OurUModel;
use \Model\AssosModel;
use \Services\Tools\Tools;

class TransactionAdminController extends AppController
{

  private $transactionModel;
  private $model_assos;
  private $tools;

  public function __construct()
  {
    $this->transactionModel = new TransactionModel();
    $this->backModel = new backModel();
    $this->ourumodel = new OurUModel();
    $this->model_assos = new AssosModel();
    $this->tools = new Tools();
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
    if ($this->tools->isLogged() == true){
      $adherants = $this->ourumodel->affOneAdherants($id_seller);
      $slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);
      $this->show('transaction/admin_credit', array(
        'adherants' => $adherants,
        'slug' => $slug,
      ));
    } else {
      $this->showForbidden(); // erreur 403
    }
  }

  public function makeCreditAdmin()
  {
    $newTransactions = $this->transactionModel->MakeCreditAdmin();
    $adherants = $this->ourumodel->affOneAdherants($_POST['destinataire']);
    $slug = $this->model_assos->getSlugByIdUser($_SESSION['user']['id']);
    $this->show('transaction/admin_credit', array(
      'newTransactions' => $newTransactions,
      'adherants' => $adherants,
      'slug' => $slug,
    ));
  }


} // Class
