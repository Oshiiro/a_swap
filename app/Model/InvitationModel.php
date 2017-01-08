<?php
namespace Model;

use \W\Model\Model;
use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

class InvitationModel extends UModel
{
  public function __construct()
  {
    parent::__construct();
    $this->setTable('invitation');
  }

  /**
  * Fonction qui verifie si une invitation de cet admin vers cet utilisateur existe
  * @param string $email_sender Email de l'admin
  * @param string $email_receiver Email de l'utilisateur
  * @return boolean true si l'invitaion existe deja, false sinon
  */
  public function invitationExist($email_sender, $email_receiver)
  {
    $app = getApp();
    $sql = "SELECT id FROM invitation
            WHERE email_sender = :email_sender
            AND email_receiver = :email_receiver
            LIMIT 1";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':email_sender', $email_sender);
    $sth->bindValue(':email_receiver', $email_receiver);
    $sth->execute();
    $foundInvit = $sth->fetch();
    if(!empty($foundInvit['id'])){
      return true;
    } else {
      return false;
    }
  }

  /**
  * Fonction qui verifie la validité d'une invitation
  * @param string $token_asso Token d'une association
  * @param string $token_invit Token d'une invitation
  * @return boolean true si l'invitaion est valide, false sinon
  */
  public function invationIsValid($token_asso, $token_invit)
  {
    $app = getApp();
    $sql = "SELECT id FROM invitation WHERE status = 'waiting'
            AND token_asso = :token_asso
            AND token_invit = :token_invit
            LIMIT 1";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':token_asso', $token_asso);
    $sth->bindValue(':token_invit', $token_invit);
    $sth->execute();
    $foundInvit = $sth->fetch();
    if(!empty($foundInvit['id'])){
      return true;
    } else {
      return false;
    }
  }

  /**
  * Fonction qui recupere l'adresse mail d'un utilisateur ayant une invitation en attente
  * selon les tokens passés en argument
  * @param string $token_asso Token de l'association
  * @param string $token_invit Token de l'invitation
  * @return string Adresse mail de l'utlisateur
  */
  public function getEmailByTokens($token_asso, $token_invit)
    {
      $sql = "SELECT email_receiver FROM invitation WHERE status = 'waiting'
              AND token_asso = :token_asso
              AND token_invit = :token_invit
              LIMIT 1";
      $dbh = ConnectionModel::getDbh();
      $sth = $dbh->prepare($sql);
      $sth->bindValue(':token_asso', $token_asso);
      $sth->bindValue(':token_invit', $token_invit);
      $sth->execute();
      $foundEmail = $sth->fetchColumn();

      return $foundEmail;
    }

  /**
  * Fonction qui recupere l'Id d'une invitaion selon les tokens passés en argument
  * @param string $token_asso Token d'association
  * @param string $token_invit Token de l'invitation
  * @return int Id de l'invitation
  */
  public function getIdByTokens($token_asso, $token_invit)
  {
    $app = getApp();
    $sql = "SELECT id FROM invitation WHERE token_asso = :token_asso
            AND token_invit = :token_invit
            LIMIT 1";
    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':token_asso', $token_asso);
    $sth->bindValue(':token_invit', $token_invit);
    $sth->execute();
    $id_invitation = $sth->fetch();

    return $id_invitation['id'];
  }

  /**
  * Fonction qui recupere l'Id d'une invitaion selon les adresses mail passés en argument
  * @param string $email_sender Email de l'admin invitant
  * @param string $email_receiver Email de l'utilisateur invité
  * @return int Id de l'invitation
  */
  public function getIdByEmails($email_sender, $email_receiver)
  {
    $app = getApp();
    $sql = "SELECT id FROM invitation
            WHERE email_sender = :email_sender
            AND email_receiver = :email_receiver
            LIMIT 1";

    $dbh = ConnectionModel::getDbh();
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':email_sender', $email_sender);
    $sth->bindValue(':email_receiver', $email_receiver);
    $sth->execute();
    $foundId = $sth->fetchColumn();

    return $foundId;
  }

}
