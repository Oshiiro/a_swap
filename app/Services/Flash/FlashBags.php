<?php
namespace Services\Flash;

class FlashBags {

    public function __construct() {
        //session_start();
    }

    /**
     * Affiche le message contenu dans la session flash :
     */
    public function getFlash() {
        if(isset($_SESSION['flash'])) {
            return $_SESSION['flash'];
        }
        return NULL;
    }

    /**
     * Créer un message flash dans la session :
     * @param $what string => danger = red, success = green, info = blue, warning = yellow
     * @param $msg string => le message à afficher
     */
    public function setFlash($what, $msg) {
        $_SESSION['flash'] = ['type' => $what, 'message' => $msg];
    }

    /**
     * Supprime le message contenu dans la session flash :
     */
    public function unsetFlash() {
        if(isset($_SESSION['flash'])) {
            unset($_SESSION['flash']);
        }
    }

}
