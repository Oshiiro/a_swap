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
