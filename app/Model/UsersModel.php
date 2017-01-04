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

// Fonction permettant d'afficher ses derniers transactions et seulement les siennes (pour user).
  public function GetItsTrans($limit, $offset)
  {

    $id = $_SESSION['user']['id'];

    $sql = "SELECT assos.name,transaction.created_at, transaction.sum,transaction.description ,userbuyer.username as username_buyer,userseller.username as username_seller FROM transaction
            LEFT JOIN users as userbuyer ON transaction.id_user_buyer = userbuyer.id
            LEFT JOIN users as userseller ON transaction.id_user_seller = userseller.id
            LEFT JOIN assos ON transaction.id_asso = assos.id
            WHERE transaction.id_user_seller = :id OR transaction.id_user_buyer = :id
            LIMIT $limit OFFSET $offset
    ";
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetchAll();

  }

  public function registerProfilImage($id_user)
  {



  }

  // Afficher liste des adhérerants y compris l'admin
    public function affAllAdherants()
    {
  // Recuperation de l'idée de l'assos via l'id user de la session
      $id = $_SESSION['user']['id'];

      $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':id', $id);
      $query->execute();
      $result = $query->fetch();


      $sql = "SELECT * FROM users INNER JOIN intermediaire ON users.id = intermediaire.id_users
      WHERE intermediaire.id_assos = :result";
      $query = $this->dbh->prepare($sql);
      $query->bindValue(':result', $result['id_assos']);
      $query->execute();
      return $query->fetchAll();
    }

  // Afficher liste des adhérerants sauf l'admin
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


    //Function d'affichage de l'adhérant choisis par l'admin pour une créditation
      public function affOneAdherants($id)
      {
        // Recuperation de l'idée de l'assos via l'id user de la session
            $id_session = $_SESSION['user']['id'];


            $sql = "SELECT id_assos FROM intermediaire WHERE id_users = :id";
            $query = $this->dbh->prepare($sql);
            $query->bindValue(':id', $id_session);
            $query->execute();
            $result = $query->fetch();

          // $sql = "SELECT * FROM users INNER JOIN intermediaire ON users.id = intermediaire.id_users
          // WHERE intermediaire.id_assos = :result";
          //   $query = $this->dbh->prepare($sql);
          //   $query->bindValue(':result', $result['id_assos']);
          //   $query->execute();
          //   return $query->fetchAll();

            $sql = "SELECT * FROM users
            WHERE id = :id";
              $query = $this->dbh->prepare($sql);
              $query->bindValue(':id', $id);
              $query->execute();
              return $query->fetchAll();
      }

}
