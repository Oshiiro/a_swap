<?php
namespace Services\Tools;

class Tools
{
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

  function isLogged()
  {
   if((!empty($_SESSION['user'])) && (!empty($_SESSION['user']['id'])) && (!empty($_SESSION['user']['username']))) {
    //  $ip = $_SERVER['REMOTE_ADDR'];
    //  if($ip == $_SESSION['user']['ip']){
    //    return true;
    //  }
     return true;
   } else {
     return false;
   }
  }

}


 ?>
