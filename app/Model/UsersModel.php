<?php
namespace Model;

use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

class UsersModel extends UModel
{

  public function __construct()
  {
    parent::__construct();
    $this->setTable('users');
  }

  /**
  * Recupere et retourne le token du user dont le mail est passé en argument
  * @param string $mail Email de l'utilisateur
  * @return string Token de l'utilisateur
  */
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

  /**
  * Recupere et retourne l'Id de l'utilisateur dont le mail est passé en argument
  * @param string $mail Email de l'utilisateur
  * @return string Id de l'utilisateur
  */
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

  /**
  * Fonction qui recupere et retourne l'Id d'un utilisateur
  * @param string $mail Email de l'utilisateur
  * @param string $token Token de l'utilisateur
  * @return string Id de l'utilisateur
  */
  public function getIdByEmailAndToken($email, $token)
  {
    $app = getApp();
    $sql = 'SELECT id FROM users WHERE email = :email AND token = :token LIMIT 1';

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':email', $email);
    $sth->bindValue(':token', $token);
    $sth->execute();
    $id = $sth->fetchColumn();

    return $id;
  }

  /**
  * Fonction qui verifie que le token est bien le bon
  * @return boolean true si le token existe, false sinon
  */
  public function tokenIsActive($email, $token)
  {
    $tokenGET = $token;

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

  /**
  *Fonction permettant d'afficher ses derniers transactions et seulement les siennes (pour user)
  * @param string $slug Slug de l'association concernée
  * @param int $limit Limit pour la pagination
  * @param int $offset Offset pour la pagination
  */
  public function GetItsTrans($slug, $limit, $offset)
  {

    $id = $_SESSION['user']['id'];

    $sql = "SELECT assos.name,transaction.created_at, transaction.sum,transaction.description ,userbuyer.username as username_buyer,userseller.username as username_seller FROM transaction
            LEFT JOIN users as userbuyer ON transaction.id_user_buyer = userbuyer.id
            LEFT JOIN users as userseller ON transaction.id_user_seller = userseller.id
            LEFT JOIN assos ON transaction.id_asso = assos.id
            WHERE transaction.id_user_seller = :id OR transaction.id_user_buyer = :id
            ORDER BY created_at DESC
            LIMIT $limit OFFSET $offset
    ";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetchAll();

  }

  /**
  * Affiche la liste des adhérerants y compris l'admin
  * @param string $slug Slug de l'association concernée
  * @param int $id_asso Id de l'association concernée
  * @param int $limit Limit pour la pagination
  * @param int $offset Offset pour la pagination
  * @return array Liste des adherants.
  */
  public function affAllAdherants($slug, $id_asso, $limit, $offset)
  {

  // Recuperation de l'idée de l'assos via l'id user de la session
    $id = $_SESSION['user']['id'];

    $sql = "SELECT id FROM assos WHERE slug = :slug";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':slug', $slug);
    $query->execute();
    $result = $query->fetch();

    $sql = "SELECT * FROM users
            INNER JOIN intermediaire ON users.id = intermediaire.id_users
            WHERE intermediaire.id_assos = :result
            ORDER BY username LIMIT $limit OFFSET $offset";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':result', $id_asso);
    $query->execute();
    return $query->fetchAll();
  }

  /**
  * Afficher liste des adhérerants hormis l'admin
  * @param string $slug Slug de l'association concernée
  * @return array Liste des adherants.
  */
  public function affAdherants($slug)
  {
  // Recuperation de l'idée de l'assos via l'id user de la session
    $id = $_SESSION['user']['id'];

    $sql = "SELECT id FROM assos WHERE slug = :slug";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':slug', $slug);
    $query->execute();
    $result = $query->fetch();


    $sql = "SELECT * FROM users
            INNER JOIN intermediaire ON users.id = intermediaire.id_users
            WHERE intermediaire.id_assos = :result AND users.id != :id";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':result', $result['id']);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetchAll();
  }

  /**
  * Affichage de l'adhérant choisis par l'admin pour une créditation
  * @param int $id Id de l'utilisateur
  * @return int Id de l'assos
  */
  public function affOneAdherants($id)
  {
    // Recuperation de l'idée de l'assos via l'id user de la session
    $id_session = $_SESSION['user']['id'];


    $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':id', $id_session);
    $query->execute();
    $result = $query->fetch();

    $sql = "SELECT * FROM users WHERE id = :id";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();

    return $query->fetchAll();
  }

}
