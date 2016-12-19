<?php
namespace Model;

use \W\Model\UsersModel as UModel;

/**
 *
 */
class UsersModel extends UModel
{

  public function __construct()
  {
    parent::__construct();
    $this->setTable('users');
  }

  public function updateProfilSql()
  {

  }
}
