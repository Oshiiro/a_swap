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

  /**
  * Fonction facilitant la recherche d'un element par un autre dans une table de la BDD
  * !ATTENTION! : utilise un fetchColomn, donc ne fonctionne que pour UN element à la fois
  * @param string $search element qu'on recherche
  * @param string $colone nom de la colonne de reference
  * @param string $where element de reference pour la recherche
  * @return string L'element recherché
  */
  public function FindElementByElement($search,$colone,$where)
  {
   $sql = 'SELECT '.$search.' FROM '.$this->table.' WHERE '.$colone.' = :where LIMIT 1';
   $sth = $this->dbh->prepare($sql);
   $sth->bindValue(':where', $where);
   if($sth->execute()){
     $foundUser = $sth->fetchColumn();
     if(!empty($foundUser)) {
       return $foundUser ;
     } else {
       return false;
     }
   }
  }

  /**
  * Prepare un tableau d'informations utile a l'ajout d'un user à la table intermediaire
  * @param string $slug Slug d'association
  * @param string $username_admin Username de l'admin de l'association
  * @return array Tableau d'informations a ajouter à la table intermediaire
  */
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

  /**
  * Fonction qui verifie que le user dont l'ID est passé en argument n'est PAS
  * inscrit dans la table intermediaire.
  * @param int $id Id de l'utilisateur
  * @return boolean true si présent dans la table intermediaire, false sinon
  */
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

  /**
  * Fonction qui efface un utilisateur de la table intermediaire.
  * @param int $id_user Id de l'utilisateur
  */
  public function DeleteIntermediaireUser($id_user)
  {
    $sql = "DELETE FROM intermediaire WHERE id_users = $id_user";
    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->execute();
  }

  /**
  * Fonction qui verifie que le user dont l'Id est passé en second argument est bien inscrit
  * dans l'association de l'admin dont l'Id est passé en premier argument
  * @param int $id_admin Id de l'admin
  * @param int $id_user Id de l'utilisateur
  * @return boolean true si OK, false sinon
  */
  public function isInMyTeam($id_admin, $id_user)
  {
    $info = "SELECT id_assos FROM intermediaire WHERE id_users = :id_admin AND role = 'admin'";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($info);
    $sth->bindValue(':id_admin', $id_admin);
    $sth->execute();
    $id_asso_admin = $sth->fetch();

    $info = "SELECT id_assos FROM intermediaire WHERE id_users = :id_user";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($info);
    $sth->bindValue(':id_user', $id_user);
    $sth->execute();
    $id_asso_user = $sth->fetch();

    if($id_asso_admin == $id_asso_user) {
      return true;
    } else {
      return false;
    }

  }



}
?>
