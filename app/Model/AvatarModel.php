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

  /**
  * Fonction facilitant la recherche d'un element par un autre dans une table de la BDD
  * !ATTENTION! : utilise un fetchColomn, donc ne fonctionne que pour UN element à la fois
  * @param string $search element qu'on recherche
  * @param string $colone nom de la colonne de reference
  * @param string $where element de reference pour la recherche
  * @return string L'element recherché
  */
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

   /**
   * Fonction facilitant la recherche d'un element par un autre dans une table de la BDD
   * !ATTENTION! : utilise un fetchColomn, donc ne fonctionne que pour UN element à la fois
   * @param string $search element qu'on recherche
   * @param string $colone nom de la colonne de reference
   * @param string $where element de reference pour la recherche
   * @return string L'element recherché
   */
   public function FindLinkForImg($search,$colone,$where)
   {
      $sql = 'SELECT '.$search.' FROM '.$this->table.' WHERE '.$colone.' = :where ORDER BY created_at DESC LIMIT 1';
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

    // 
    //
    // public function FindLinkForImgReveived($limit, $offset)
    // {
    //   $sql = "SELECT avatar.link_relative, users.id, avatar.id_user, avatar.id FROM avatar
    //           LEFT JOIN users
    //           ON avatar.id_user_sender = users.id
    //           WHERE avatar.id_user_sender = users.id AND pm.active_receiver = 1
    //           ORDER BY created_at DESC
    //           LIMIT $limit OFFSET $offset";
    //   $affAvatar = $this->dbh->prepare($sql);
    //   $affAvatar->bindValue(':id', $id);
    //   $affAvatar->execute();
    //   return $affAvatar->fetchAll();
    // }

}
