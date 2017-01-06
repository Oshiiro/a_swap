<?php

namespace Services\Plates;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use \Services\Flash\FlashBags;

/**
 * @link http://platesphp.com/engine/extensions/ Documentation Plates
 */
class CuztomPlates implements ExtensionInterface
{

	/**
	 * Enregistre les nouvelles fonctions dans Plates
     * @param \League\Plates\Engine $engine L'instance du moteur de template
	 */
    public function register(Engine $engine)
    {
      $engine->registerFunction('maj', [$this, 'Majuscule']);
      $engine->registerFunction('getValueInArray', [$this, 'getValueInArray']);
			$engine->registerFunction('getFlash', [$this, 'getFlash']);
    }

		/**
		* Affiche le message contenu dans la session flash :
		*/
	  public function getFlash() {
			 $flashBag = new FlashBags();
			 if(!empty($flashBag->getFlash())) {
				 echo '<div class="flash"><p>'.$flashBag->getFlash()['message'].'</p></div>';
				 $flashBag->unsetFlash();
			 }
			 return NULL;
		}

    /**
     *
     */
    public function Majuscule($string)
    {
      return strtoupper($string);
    }

    /**
	   * Permet de recuperer la valeur d'une clef dans un array
     * @return value
		 * Or
		 * @return ''
		 * by Oshiiro
     */
		 public function getValueInArray($array, $key)
		 {
			 if (!empty($array)){
				 return $array[$key];
			 }else{
				 return '';
			 }
		 }

}
