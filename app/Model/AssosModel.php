<?php
namespace Model;

use \W\Model\Model;
use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

class AssosModel extends UModel
{
  public function __construct()
  {
    parent::__construct();
    $this->setTable('assos');
  }

  public function FindElementByElement($search,$colone,$where)
  {
     $sql = 'SELECT '.$search.' FROM '.$this->table.' WHERE '.$colone.' = :where LIMIT 1';
     $sth = $this->dbh->prepare($sql);
     $sth->bindValue(':where', $where);
     if($sth->execute()){
       $foundUser = $sth->fetchColumn();
       if(!empty($foundUser)){
         return $foundUser ;
       }else{
         return false;
       }
     }
   }

  /**
   * Créer un array avec toute les infos de l'assos par l'utilisateur
   */
  public function getAssosById($id)
  {
    $sql = 'SELECT a.* FROM assos AS a
            INNER JOIN intermediaire AS i ON a.id = i.id_assos
            INNER JOIN users AS u ON :id = i.id_users
            LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':id', $id);
    $sth->execute();
    $result = $sth->fetch();
  }

  public function assoExists($nom_asso)
	{
	    $app = getApp();
	    $sql = 'SELECT name FROM assos WHERE name = :name LIMIT 1';

	    $dbh = ConnectionModel::getDbh();
	    $sth = $dbh->prepare($sql);
	    $sth->bindValue(':name', $nom_asso);
	    if($sth->execute()){
	        $foundAsso = $sth->fetch();
	        if($foundAsso){
	            return true;
	        }
	    }
	    return false;
	}

  public function slugExist($slug_asso)
  {
    $app = getApp();
    $sql = 'SELECT slug FROM assos WHERE slug = :slug_asso LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':slug_asso', $slug_asso);
    if($sth->execute()){
        $foundAsso = $sth->fetch();
        if($foundAsso){
            return true;
        }
    }
    return false;
  }

  public function slugIsMine($slug)
  {
    $myId = $_SESSION['user']['id'];
    $app = getApp();
    $sql = "SELECT a.slug FROM assos AS a
            LEFT JOIN intermediaire AS i ON a.id = i.id_assos
            LEFT JOIN users AS u ON  i.id_users = u.id
            WHERE u.id = :myId
            LIMIT 1";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':myId', $myId);
    $sth->execute();
    $slugOK = $sth->fetchColumn();
    if($slugOK == $slug){
      return true;
    } else {
      return false;
    }
  }

  public function getToken($id_admin) //renommer en getTokenByIdAdmin ??
  {
    $app = getApp();
    $sql = 'SELECT a.token FROM assos AS a
            INNER JOIN intermediaire AS i ON a.id = i.id_assos
            INNER JOIN users AS u ON :id_admin = i.id_users
            LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':id_admin', $id_admin);
    $sth->execute();
    $token = $sth->fetch();

    return $token['token'];
  }

  // fonction qui retourne le nom de l'asso dont l'ID de l'admin est passé en argument.
  public function getNameByIdAdmin($id_admin)
  {
    $app = getApp();
    $sql = 'SELECT a.name FROM assos AS a
            INNER JOIN intermediaire AS i ON a.id = i.id_assos
            INNER JOIN users AS u ON :id_admin = i.id_users
            LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':id_admin', $id_admin);
    $sth->execute();
    $name = $sth->fetch();

    return $name['name'];
  }

  public function getSlugByIdUser($id)
  {
    $app = getApp();
    $sql = "SELECT a.slug FROM assos AS a
            INNER JOIN intermediaire as i ON a.id = i.id_assos
            INNER JOIN users AS u ON :id = i.id_users";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':id', $id);
    $sth->execute();
    $slug = $sth->fetch();

    return $slug['slug'];
  }

  public function getIdByToken($token_asso)
  {
    $app = getApp();
    $sql = 'SELECT id FROM assos WHERE token = :token_asso LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':token_asso', $token_asso);
    $sth->execute();
    $token = $sth->fetch();

    return $token['id'];
  }

// Modification de l'association dans le back
public function ModifAssos()
{

  $id = $_SESSION['user']['id'];
  // Récuperer l'id de l'assos en cours
  $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id";
  $query = $this->dbh->prepare($sql);
  $query->bindValue(':id', $id);
  $query->execute();
  $id_asso = $query->fetch();


  // Selectionner infos de l'asso
  $sql = "SELECT * FROM assos
  WHERE id = :id_asso";
  $query = $this->dbh->prepare($sql);
  $query->bindValue(':id_asso', $id_asso['id_assos']);
  $query->execute();
  $assos = $query->fetch();
  return $assos;
}

public function nameAssosExists($name)
{

    $app = getApp();

    $sql = 'SELECT ' . 'name' . ' FROM ' . $this->table .
           ' WHERE ' . 'name' . ' = :name LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':name', $name);
    if($sth->execute()){
        $foundUser = $sth->fetch();
        if($foundUser){
            return true;
        }
    }

    return false;
}

}
?>
