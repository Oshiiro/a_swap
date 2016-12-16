<?php
namespace Model;

use \W\Model\Model;
use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

class AssosModel extends UModel
{

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

  


}
?>
