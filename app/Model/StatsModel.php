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

  // fonction qui retourne la liste de toutes les assos inscrites sur le site.
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
    // partant du principe qu'il y a une colonne id-assos dans la table transaction
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
    // select distinct de chaque asso.
    // $best = 0;
    // pour chaque asso : - calculer l'ancienneté en jour
    //                    - count nmb de transaction (count id from transaction where id_assos)
    //                    - moyenne = nb transaction / ancieneté
    // if moyenne > $best { $best = array( asso.nom, count_transac  }

    // return $best

  }


}


 ?>
