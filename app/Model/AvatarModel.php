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

}
