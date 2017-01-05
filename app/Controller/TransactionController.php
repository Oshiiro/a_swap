<?php

namespace Controller;

use \Controller\AppController;
use \Model\UsersModel as OurUModel;
use \Model\TransactionModel;
use \Model\BackModel;
use \Model\IntermediaireModel;
use \Model\AssosModel;
use \Services\Tools\Tools;

class TransactionController extends AppController
{
  private $model_intermediaire;
  private $transactionModel;
  private $tools;

  public function __construct()
  {
    $this->model_intermediaire = new IntermediaireModel();
    $this->transactionModel = new TransactionModel();
    $this->tools = new Tools();
    $this->usersModel = new OurUModel();
    $this->backmodel = new BackModel();
    $this->AssosModel = new AssosModel();
  }

  // Affichage du formulaire pour transaction, avec liste des adhérants
  public function ShowFormTransaction($slug) {
    if ($this->tools->isLogged() == true){
      $slug_is_mine = $this->AssosModel->slugIsMine($slug);

      if($slug_is_mine == true) {

        $slug = $this->AssosModel->getSlugByIdUser($_SESSION['user']['id']);
        $adherants = $this->usersModel->affAdherants($slug);
        $this->show('transaction/users_transaction', array(
          'adherants' => $adherants,
          'slug' => $slug
        ));

      } else {
        $this->showForbidden(); // erreur 403
      }
    } else {
      $this->showForbidden(); // erreur 403
    }
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
