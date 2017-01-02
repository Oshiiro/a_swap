<?php
namespace Model;

use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

/**
 *
 */
class AvatarModel extends UModel
{

  public function __construct()
  {
    parent::__construct();
    $this->setTable('avatar');
  }

}
