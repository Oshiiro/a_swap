<?php

namespace Controller;

use \W\Controller\Controller;

class AppController extends Controller
{
  /**
   * Affiche un template
   * @param string $file Chemin vers le template, relatif à app/Views/
   * @param array  $data Données à rendre disponibles à la vue
   */
  public function show($file, array $data = array())
  {
    //incluant le chemin vers nos vues
    $engine = new \League\Plates\Engine(self::PATH_VIEWS);

    //charge nos extensions (nos fonctions personnalisées)
    $engine->loadExtension(new \W\View\Plates\PlatesExtensions());

    // on charge nos propre extension pour nos vues
    $engine->loadExtension(new \Services\Plates\CuztomPlates());

    $app = getApp();

    // Rend certaines données disponibles à tous les vues
    // accessible avec $w_user & $w_current_route dans les fichiers de vue
    $engine->addData(
      [
        'w_user' 		  => $this->getUser(),
        'w_current_route' => $app->getCurrentRoute(),
        'w_site_name'	  => $app->getConfig('site_name'),
      ]
    );

    // Retire l'éventuelle extension .php
    $file = str_replace('.php', '', $file);

    // Affiche le template
    echo $engine->render($file, $data);
    die();
  }





}
