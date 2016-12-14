<?php

namespace Services\Plates;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

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
      $engine->registerFunction('logged', [$this, 'isLogged']);

    }

    /**
     * 
     */
    public function Majuscule($string)
    {
      return strtoupper($string);
    }

    /**
     * @return bool
     */
    public function isLogged($w_user)
    {

    }


}
