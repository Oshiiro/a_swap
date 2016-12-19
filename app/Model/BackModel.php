<?php
namespace Model;

use \W\Model\Model;
use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

class BackModel extends UModel
{
  private $backmodel;

  public function __construct()
  {
    parent::__construct();
    $this->setTable('transaction');
  }

  public function GetTrans()
  {
    $sql ='SELECT * FROM transaction LIMIT 10';

    $query = $pdo->prepare($sql);
    $query->execute();
    $trans = $query->fetchAll();
  }

}
?>
