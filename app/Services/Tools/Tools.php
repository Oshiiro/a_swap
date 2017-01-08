<?php
namespace Services\Tools;

class Tools
{
  /**
  * Fonction permettant de "slugifier" un texte
  * @param string $text Le texte a "slugifier" <= ceci est un neologisme, oui ! Et alors ?!!!!
  * @return string Le text "slugifié"
  */
  public function slugify($text)
  {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }
    return $text;
  }

  /**
  * Fonction permettant de verifier qu'une session est bien en cours
  */
  public function isLogged()
  {
   if((!empty($_SESSION['user'])) && (!empty($_SESSION['user']['id'])) && (!empty($_SESSION['user']['username']))) {
     return true;
   } else {
     return false;
   }
  }

}


 ?>
