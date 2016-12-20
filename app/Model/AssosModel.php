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

  public function getToken($id_admin)
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




}
?>
