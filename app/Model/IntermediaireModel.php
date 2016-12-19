<?php
namespace Model;

use \W\Model\Model;
use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

class IntermediaireModel extends UModel
{
  public function __construct()
  {
    parent::__construct();
    $this->setTable('intermediaire');
  }

  public function getAssoAndAdmin($slug, $username_admin)
  {
    $app = getApp();
    $info = "SELECT id FROM assos WHERE slug = :slug_asso";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($info);
    $sth->bindValue(':slug_asso', $slug);
    $sth->execute();
    $id_asso = $sth->fetch();

    $info = "SELECT id FROM users WHERE username = :username_admin";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($info);
    $sth->bindValue(':username_admin', $username_admin);
    $sth->execute();
    $id_admin = $sth->fetch();

    $data_intermediaire = array(
      'id_users' => $id_admin['id'],
      'id_assos' => $id_asso['id'],
      'created_at' => date('Y-m-d H:i:s'),
      'role' => 'admin',
      'wallet' => 0,
    );
    return $data_intermediaire;
  }


}
?>
