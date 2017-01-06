<?php
namespace Model;

use \W\Model\UsersModel as UModel;
use \W\Model\ConnectionModel;

/**
 *
 */
class AvatarModel extends UModel
{

  public function __construct()
  {
    parent::__construct();
    $this->setTable('avatar');
  }

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

}
