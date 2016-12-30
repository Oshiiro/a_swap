<?php
namespace Model;

use \W\Model\Model;
use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

class StatsModel extends UModel
{
  public function __construct()
  {

  }

  // fonction qui compte le nombre d'association inscrite sur le site et retourne ce resultat
  public function countNbAsso()
  {
    $app = getApp();
    $sql = "SELECT id FROM assos";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $count = $sth->fetchAll();

    return count($count);
  }

  // fonction qui compte le nombre de personnes inscrite sur le site et retourne ce resultat
  public function countNbUser()
  {
    $app = getApp();
    $sql = "SELECT id FROM users";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $count = $sth->fetchAll();

    return count($count);
  }

  // fonction qui retourne le nom de la derniere asso inscrite sur le site.
  public function lastAsso()
  {
    $app = getApp();
    $sql = "SELECT name FROM assos ORDER BY created_at DESC LIMIT 1";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $name = $sth->fetch();

    return $name['name'];
  }

  // fonction qui retourne le nom du dernier utilisateur inscrit sur le site.
  public function lastUser()
  {
    $app = getApp();
    $sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT 1";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $name = $sth->fetch();

    return $name['firstname']. ' ' .$name['lastname'];
  }

  public function allUsers()
  {
    $app = getApp();
    $sql = "SELECT * FROM users";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $users = $sth->fetchAll();

    return $users;
  }

  // Fonction qui retourne des infos sur l'asso ayant actuellement le + de coins en circulation.
 public function mostMoneyAsso()
 {
  $app = getApp();
  $sql = "SELECT DISTINCT id_assos FROM intermediaire";

  $dbh = ConnectionModel::getDbh();
  $sth = $dbh->prepare($sql);
  $sth->execute();
  $assos = $sth->fetchAll();

  $most_money_asso = array('name'=>'Aucun', 'money'=>0);
  foreach ($assos as $asso) {
    $sql = "SELECT SUM(wallet) FROM intermediaire WHERE id_assos = $asso[id_assos]";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $result =  $sth->fetch();

    if($result > $most_money_asso['money']) {
      $app = getApp();
      $sql = "SELECT name, money_name FROM assos WHERE id=$asso[id_assos]";

      $dbh = ConnectionModel::getDbh();
      $sth = $dbh->prepare($sql);
      $sth->execute();
      $name = $sth->fetch();

      $most_money_asso['name'] = $name['name'];
      $most_money_asso['money_name'] = $name['money_name'];
      $most_money_asso['money'] = $result;
    }
  }

  return $most_money_asso;
 }

 // Fonction qui retourne des infos sur l'asso qui a la moyenne de nombre de transaction par jour la + elevée.
 public function mostActiveAsso()
 {

 }


}


 ?>
