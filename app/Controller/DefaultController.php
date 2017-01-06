<?php

namespace Controller;

use \Controller\AppController;
use \Model\AssosModel;
use \Services\Tools\Tools;
use \Services\Tools\ValidationTools;
use \Services\Flash\FlashBags;
use PHPMailer;

class DefaultController extends AppController
{
	private $tools;
	private $valid;

	public function __construct()
	{
		$this->tools = new Tools();
		$this->valid = new ValidationTools();
	}

// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		if ($this->tools->isLogged() == true){
			$slug = new AssosModel();
			$slug = $slug->getSlugByIdUser($_SESSION['user']['id']);
			$this->show('default/home');
		} else {
			$this->show('default/home');
		}
	}

	/**
	 * Page de contact
	 */
	public function contact()
	{
		if ($this->tools->isLogged() == true){
			$slug = new AssosModel();
			$slug = $slug->getSlugByIdUser($_SESSION['user']['id']);
			$this->show('default/contact');
		} else {
			$this->show('default/contact');
		}
	}

	/**
	 * Page de CGU
	 */
	public function cgu()
	{
		$this->show('default/cgu');
	}

// ===================================================================================================================
// 																							TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
	/**
	 * Page de contact - Envois du mail traitement
	 */
	public function sendMailContact()
	{
		if ($this->tools->isLogged() == true){
			$slug = new AssosModel();
			$slug = $slug->getSlugByIdUser($_SESSION['user']['id']);
		} else {
			$slug = 'null';
		}
		$error = array();
		$email = (!empty($_POST['email'])) ? trim(strip_tags($_POST['email'])) : null;
		$objet = (!empty($_POST['objet'])) ? trim(strip_tags($_POST['objet'])) : null;
		$content = (!empty($_POST['content'])) ? trim(strip_tags($_POST['content'])) : null;

		$error['email'] = $this->valid->emailValid($email,'email', 3, 50);
		$error['objet'] = $this->valid->textValid($objet,'objet', 3, 50);
		$error['content'] = $this->valid->textValid($content,'contenu', 3, 2000);

		if ($this->valid->IsValid($error)) {

			$mailEncode = urlencode($email);
			$mail = new PHPMailer();
			$mail->CharSet = "utf8";
			$mail->From = $email;
			$mail->FromName = $email;
			$mail->Subject = 'Mail d\'un utilisateur d\'A-Swap : ' .$objet;
			$mail->Body = $content;
			$mail->AddAddress('a-swap@hotmail.com');
			$mail->send();

			// Tous s'est bien passé, on envoi un flash mesasge a l'utilisateur.
			$flash = new FlashBags();
			$flash->setFlash('warning', 'L\'équipe d\'A-Swap recevra votre message ; vous recevrez une reponse sous 48h.');

			$this->redirectToRoute('default_home', array(
				'slug' => $slug,
			));

		} else {
			$this->show('default/contact', array(
				'error' => $error,
				'slug' => $slug,
			));
		}

	}

}
