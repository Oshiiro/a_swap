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

  /**
  * Compte le nombre d'association inscrite sur le site et retourne ce resultat
  * @return int Count du nombre d'association inscrite sur le site
  */
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


  /**
  * Compte le nombre de personnes inscrite sur le site et retourne ce resultat
  * @return int Count du nombre d'utilisateurs inscrits sur le site
  */
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

  /**
  * Retourne le nom de la derniere asso inscrite sur le site.
  * @return string Nom de l'association
  */
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

  /**
  * Retourne le nom du dernier utilisateur inscrit sur le site.
  * @return string Nom de l'utilisateur
  */
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

  /**
  * Retourne la liste de tous les utilisateurs inscrits sur le site.
  * @return array Liste des utilisateurs
  */
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

  /**
  * Retourne la liste de toutes les associations inscrites sur le site.
  * @return array Liste des associations
  */
  public function allAssos()
  {
    $app = getApp();
    $sql = "SELECT * FROM assos";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $assos = $sth->fetchAll();

    return $assos;
  }

  /**
  * Retourne des infos sur l'asso ayant actuellement le + de coins en circulation
  * @return array Infos sur l'association concernée
  */
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

 /**
 * Retourne des infos sur l'asso qui a la moyenne de nombre de transaction par jour la + elevée
 * @return array Infos sur l'association concernée
 */
  public function mostActiveAsso()
  {
    $app = getApp();
    $sql = "SELECT DISTINCT id_asso FROM transaction";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $assos = $sth->fetchAll();

    $most_active_asso = array('name'=>'Aucun', 'transaction'=>0);
    $today = time();

    foreach ($assos as $asso) {
      $sql = "SELECT created_at FROM assos WHERE id = $asso[id_asso]";

      $dbh = ConnectionModel::getDbh();
      $sth = $dbh->prepare($sql);
      $sth->execute();
      $created_at =  $sth->fetch();
      $created_at = strtotime($created_at['created_at']);

      $temps=$today-$created_at; // On fait la différence des deux
      $ancien=$temps / 86400; // On transforme ça en jours

      $sql = "SELECT id FROM transaction WHERE id_asso = $asso[id_asso]";

      $dbh = ConnectionModel::getDbh();
      $sth = $dbh->prepare($sql);
      $sth->execute();
      $count = $sth->fetchAll();
      $count = count($count);

      $moyenne = $count/$ancien;
      $moy = number_format($moyenne, 2, ',', ' ');

      if($moyenne > $most_active_asso['transaction']) {
        $app = getApp();
        $sql = "SELECT name FROM assos WHERE id=$asso[id_asso]";

        $dbh = ConnectionModel::getDbh();
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $name = $sth->fetch();

        $most_active_asso['name'] = $name['name'];
        $most_active_asso['transaction'] = $moy;
      }

    }
    return $most_active_asso;
  }




}


 ?>
