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
       if(!empty($foundUser)){
         return $foundUser ;
       }else{
         return false;
       }
     }
   }

  /**
  * Créer un array avec toute les infos d'une assos
  * @param int $id Id de l'association dont on veut recuperer des infos
  * @return array Tableaux d'information
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
    return $result;
  }

  /**
  * Verifie qu'une association portant ce nom n'est pas deja present en BDD
  * @param string $nom_asso Nom à verifier
  * @return boolean true si présent en base de données, false sinon
  */
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

  /**
  * Verifie qu'une association portant ce slug n'est pas deja present en BDD
  * @param string $slug_asso Slug à verifier
  * @return boolean true si présent en base de données, false sinon
  */
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

  /**
  * Verifie que le slug passé en argument correspont bien au slug de l'association
  * dont l'utilisateur connécté est membre
  * @param string $slug Slug à verifier
  * @return boolean true correspondance, false sinon
  */
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

  /**
  * Recupere le token de l'association dont l'id de l'utilisateur est passé en argument
  * @param string $id_admin Id de l'utiisateur
  * @return string Token de l'association
  */
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

  /**
  * Recupere le nom de l'association dont l'id de l'utilisateur est passé en argument
  * @param string $id_admin Id de l'utiisateur
  * @return string Nom de l'association
  */
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

  /**
  * Recupere le slug de l'association dont l'id de l'utilisateur est passé en argument
  * @param string $id Id de l'utiisateur
  * @return string Slug de l'association
  */
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

  /**
  * Recupere l'Id' de l'association dont le token est passé en argument
  * @param string $token_asso Token de l'association
  * @return string Id de l'association
  */
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

  /**
  * Modification de l'association dans le back
  */
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

  /**
  * Verifie qu'une association portant ce nom n'est pas deja present en BDD
  * @param string $name Nom à verifier
  * @return boolean true si présent en base de données, false sinon
  */
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
