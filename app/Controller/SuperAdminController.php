<?php

namespace Controller;

use \Controller\AppController;
use \Services\Tools\Tools;
use \Model\StatsModel;


class SuperAdminController extends AppController
{

  private $tools;
  private $model_stats;

  public function __construct()
  {
    $this->tools = new Tools();
    $this->model_stats = new StatsModel();
  }

  /**
   * accueil du super Admin
   */
  public function superAccueil()
  {
    $this->allowTo(array('superadmin'));

    $nombreAsso = $this->model_stats->countNbAsso();
    $lastAsso = $this->model_stats->lastAsso();
    $nombreUsers = $this->model_stats->countNbUser();
    $lastUser = $this->model_stats->lastUser();
    $allUsers = $this->model_stats->allUsers();
    $allAssos = $this->model_stats->allAssos();
    $most_money_asso = $this->model_stats->mostMoneyAsso();
    $most_active_asso = $this->model_stats->mostActiveAsso();



      $this->show('super_admin/back', array(
        'nombreAsso' => $nombreAsso,
        'nombreUsers' => $nombreUsers,
        'lastAsso' => $lastAsso,
        'lastUser' => $lastUser,
        'allUsers' => $allUsers,
        'allAssos' => $allAssos,
        'most_money_asso' => $most_money_asso,
        'most_active_asso' => $most_active_asso,
      ));
  }

}

?>
