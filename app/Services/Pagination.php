<?php
namespace Services;
use \W\Model\Model;
use \W\Model\ConnectionModel;
use \Controller\AppController;

class Pagination extends Model
{
  // la table dans la quel on va travailler
  public function __construct($table)
  {
    $this->setTable($table);
    $this->dbh = ConnectionModel::getDbh() ;

  }
/**
*@param string $where  where de la requete sql
* @param int $num Nombre d'article par page
* @param int $page Page de base
* @return $result Retourne le tableau de la requète avec l'offset et la page
*/
  public function calcule_page($where='',$num,$page)
  {

    $where_full ='';
    if($where != ''){
      $where_full = 'WHERE '.$where;
    }
    $tab = $this->getTable() ;
    $sql = "SELECT COUNT(id) FROM $this->table $where_full ";
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $count = $sth->fetchColumn();

    $nb_page = ceil($count/$num);
    $result['nb_page'] = $nb_page;
    //on declare page et offset
    if(!empty($page) && is_numeric($page) && ctype_digit($page) && ($page <= $nb_page) && ($page > 0)){
      $result['page'] = $page;
      $result['offset'] = (($page-1)*$num);
    }else {
      $result['page'] = 1;
      $result['offset'] = 0;
    }
    return $result;
  }

  /**
  *@param int $page Page actuelle
  * @param int $nb_page Nombre total de page
  * @param string $route Le nom de la route pour générer l'url
  * @param string $arg Tableau d'argument qui génère l'url (ex : ['slug' => $slug])
  * @return $result Retourne le tableau de la requète avec l'offset et la page 
  */
  //on genere et retourne l'affichage de la pagination si elle a lieu d'etre
  public function pagination($page,$nb_page,$route,$arg='')
  {
    $html = '';

    if($nb_page > 1){ $html .='<br/>';};
    $html .='<div class="pagin">';
    $argumentFull='';

    if(!empty($arg)){
      foreach ($arg as $key => $value) {
        $argumentFull[$key] = $value ;
      }
    }

    if($page == $nb_page && $page != 1){
      $argumentFull['page'] = ($page-1);
      $html .='<a href="'.AppController::generateUrl($route,$argumentFull).'"> << </a>';
      $html .= $this->liste($nb_page,$route,$page,$argumentFull);
    }elseif ($page < $nb_page && $page > 1) {
      $argumentFull['page'] = ($page-1);
      $html .= '<a href="'.AppController::generateUrl($route,$argumentFull).'"> << </a>';
      $html .= $this->liste($nb_page,$route,$page,$argumentFull);
      $argumentFull['page'] = ($page+1);
      $html .= '<a href="'.AppController::generateUrl($route,$argumentFull).'">  >> </a>';
    }elseif($page == 1 && $nb_page > 1){
      $argumentFull['page'] = ($page+1);
      $html .= $this->liste($nb_page,$route,$page,$argumentFull);
      $html .= '<a href="'.AppController::generateUrl($route,$argumentFull).'">  >> </a>';
    }
    $html .='</div>';
    if($nb_page > 1){
      $html .='<br/>';
    }
    return $html;
  }
  public function liste($nb_page,$route,$page,$argumentFull)
  {
    $html ='';
    for($i=1; $i <= $nb_page; $i++) {
      if($i == $page){
        $argumentFull['page'] = $i;
        $style = '<span class="actuel"><a href="'.AppController::generateUrl($route,$argumentFull).'">'.$i.'</a></span>';
      }else {
        $argumentFull['page'] = $i;
        $style = '<span class="voisin"><a href="'.AppController::generateUrl($route,$argumentFull).'">'.$i.'</a></span>';
      }

      if($i ==1 && $i != $page){
        $html .= $style;
      }elseif($i ==1 && $i == $page){
        $html .= $style.'<span class="voisin">...</span>';
      }elseif($i == $nb_page  && $i != $page){
        $html .= $style;
      }elseif($i == $nb_page  && $i == $page){
        $html .= '<span class="voisin">...</span>'.$style;
      }elseif($i == $page) {
        $html .= '<span class="voisin">...</span>'.$style.'<span class="voisin">...</span>';
      }
    }
    return $html;
  }
}
