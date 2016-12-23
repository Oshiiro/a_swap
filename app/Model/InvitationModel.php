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

}
