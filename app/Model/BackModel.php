<?php
namespace Model;

use \W\Model\Model;
use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

class BackModel extends UModel
{
  private $backmodel;

  public function __construct()
  {
    parent::__construct();
    $this->setTable('transaction');
    $this->setTable('assos');
    $this->setTable('intermediaire');
  }

  /**
  * Recupere les transaction de l'assocaition dont le slug est passé en argument
  * @param string $slug Slug de l'association
  * @return string Liste des transactions
  */
  public function GetTrans($slug)
  {
    $id = $_SESSION['user']['id'];
    $sql = "SELECT id FROM assos WHERE slug = :slug";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':slug', $slug);
    $query->execute();
    $result = $query->fetch();


    $sql = "SELECT assos.name,transaction.created_at, transaction.sum,transaction.description ,userbuyer.username as username_buyer,userseller.username as username_seller FROM transaction
            LEFT JOIN users as userbuyer ON transaction.id_user_buyer = userbuyer.id
            LEFT JOIN users as userseller ON transaction.id_user_seller = userseller.id
            LEFT JOIN assos ON transaction.id_asso = assos.id
            WHERE transaction.id_asso = :result
            ORDER BY transaction.created_at DESC
            -- LIMIT ".(($cPage-1)).", $nbrParPage
    ";

    $query = $this->dbh->prepare($sql);
    $query->bindValue(':result', $result['id']);
    $query->execute();
    return $query->fetchAll();
  }

  /**
  * Recupere les transaction de l'association dont l'id est passé en argument
  * avec des limites pour la pagination
  * @param int $id_asso Id de l'association
  * @param int $limit Limit pour la pagination
  * @param int $offset Offset pour la pagination
  * @return string Liste des transactions
  */
  public function GetTransTempo($id_asso,$limit,$offset)
  {
    $sql = "SELECT assos.name,transaction.created_at, transaction.sum,transaction.description ,userbuyer.username as username_buyer,userseller.username as username_seller FROM transaction
            LEFT JOIN users as userbuyer ON transaction.id_user_buyer = userbuyer.id
            LEFT JOIN users as userseller ON transaction.id_user_seller = userseller.id
            LEFT JOIN assos ON transaction.id_asso = assos.id
            WHERE transaction.id_asso = :result
            ORDER BY transaction.created_at DESC
            LIMIT $limit OFFSET $offset

    ";

    $query = $this->dbh->prepare($sql);
    $query->bindValue(':result', $id_asso);
    $query->execute();
    return $query->fetchAll();
  }



}
?>
