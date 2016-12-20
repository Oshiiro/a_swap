<?php
namespace Model;

use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

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

  // Fonction qui recupere et retourne le token du user dont le mail est passé en argument.
  public function recupToken($mail)
  {
    $app = getApp();
    $sql = 'SELECT token FROM users WHERE email = :email LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':email', $mail);
    $sth->execute();
    $token = $sth->fetch();

    return $token['token'];
  }

  // Fonction qui recupere et retourn l'ID correspondant au mail passé en argument
  public function getIdByEmail($mail)
  {
    $app = getApp();
    $sql = 'SELECT id FROM users WHERE email = :email LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':email', $mail);
    $sth->execute();
    $id = $sth->fetch();

    return $id['id'];
  }

  // Fonction qui recupere et retourne l'id de la ligne en dont l'adrese mail et
  // le token sont passés en GET
  public function getIdByEmailAndToken()
  {
    $email = trim(strip_tags($_GET['email']));
    $token = trim(strip_tags($_GET['token']));

    $app = getApp();
    $sql = 'SELECT id FROM users WHERE email = :email AND token = :token LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':email', $email);
    $sth->bindValue(':token', $token);
    $sth->execute();
    $id = $sth->fetch();

    return $id['id'];
  }

  // Fonction qui verifie que le token est bien le bon
  public function tokenIsActive()
  {
    $tokenGET = trim(strip_tags($_GET['token']));
    $email = trim(strip_tags($_GET['email']));

    $app = getApp();
    $sql = 'SELECT token FROM users WHERE email = :email LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':email', $email);
    $sth->execute();
    $tokenBDD = $sth->fetch();

    if($tokenBDD['token'] == $tokenGET){
      return true;
    } else {
      return false;
    }
  }

}
