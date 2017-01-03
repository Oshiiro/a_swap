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

  // Fonction qui verifie que le user dont l'ID est passé en argument n'est PAS
  // inscrit dans la table intermediaire.
  public function isFree($id)
  {
    $app = getApp();
    $info = "SELECT id FROM intermediaire WHERE id_users = :id";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($info);
    $sth->bindValue(':id', $id);
    $sth->execute();
    $exist = $sth->fetch();

    if (empty($exist['id'])){
      return true;
    } else {
      return false;
    }
  }

  public function DeleteIntermediaireUser($id_user)
  {
    $sql = "DELETE FROM intermediaire WHERE id_users = $id_user";
    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->execute();
  }

  // Fonction qui verifie que le user dont l'id est passé en second argument fait bien parti de
  // l'asso de l'admin dont l'id est passé en premier argument.
  public function isInMyTeam($id_admin, $id_user)
  {
    $info = "SELECT id_assos FROM intermediaire WHERE id_users = :id_admin AND role = 'admin'";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($info);
    $sth->bindValue(':id_admin', $id_admin);
    $sth->execute();
    $id_asso_admin = $sth->fetch();

    $info = "SELECT id_assos FROM intermediaire WHERE id_users = :id_user AND role = 'user'";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($info);
    $sth->bindValue(':id_user', $id_user);
    $sth->execute();
    $id_asso_user = $sth->fetch();

    if($id_asso_admin == $id_asso_user){
      return true;
    } else {
      return false;
    }

  }

}
?>
