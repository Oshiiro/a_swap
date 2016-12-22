<?php

namespace Controller;

use \Controller\AppController;
use \W\Model\UsersModel;
use \Model\UsersModel as OurUModel;
use \Model\IntermediaireModel;
use \Model\AssosModel;
use \Model\MessageModel;
use \Services\Flash\FlashBags;
use PHPMailer;


class AssociationAdminController extends AppController
{

	private $model;
	private $assos;
	private $our_u_model;
	private $intermediaire;

	public function __construct()
	{
		$this->model = new UsersModel();
		$this->assos = new AssosModel();
		$this->our_u_model = new OurUModel();
		$this->intermediaire = new IntermediaireModel();
	}
// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page Back Association Admin
	 */
	public function backAssos()
	{
		$this->show('association/back_assos');
	}

	/**
	 * Page Back Association Admin ( page de modif )
	 */
	public function backAssosTryModif()
	{
		$this->show('association/modifassos_admin_back');
	}


// ===================================================================================================================
// 																						TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
	/**
	* Ajout de crédit à un membre
	*/
	public function addCoinToUser()
	{
		$this->show('association/back_assos');
	}

  /**
	 * Page d'inscription Admin traitement
	 */
	public function backAssosModify()
	{
		$this->show('association/modifassos_admin_back');
	}



  /**
	 *
	 */
  public function updateform($id)
  {
		$this->show('association/modifassos_admin_back');
  }

	/**
	 *
	 */
  public function updateaction($id)
  {
		$this->show('association/modifassos_admin_back');
  }

	/**
	* Invitation d'un membre a rejoindre l'assocation
	*/
	public function inviteNewMemberByMail()
	{
		$id_admin = $_SESSION['user']['id'];
		$email   = trim(strip_tags($_POST['mail_invite']));
		// On verifie que c'est bien une adresse mail qui a été renseignée
		// A FAIRE !!!

		// On verifie que cet email existe dans la table Users
		$exist = $this->model->emailExists($email,'email', 3, 50);
		if($exist == false)
		{
			$token_assos = $this->assos->getToken($id_admin);
			$name_asso = $this->assos->getNameByIdAdmin($id_admin);
			// On envoi l'invit par mail
			$mailEncode = urlencode($email);
			$mail = new PHPMailer();
			$mail->CharSet = "utf8";
			$mail->From = "no.reply@a-swap.com";
			$mail->FromName = "A-Swap Admin";
			$mail->Subject = "Invitation a rejoindre une association";
			// ATTENTION PENSEZ A MODIFIER LE LIEN CI DESSOUS EN FONCTION DU NOM DU
			// REPERTOIRE DU PROJET DANS VOTRE LOCALHOST
			$mail->Body = $_SESSION['user']['firstname']. ' '. $_SESSION['user']['lastname'] .
										' souhaite vous inviter a rejoindre son association : "' . $name_asso . '". Cliquez ici pour le rejoindre :
										<a href="http://localhost/a_swap/public/inscription/user/' .$token_assos. '">Rejoindre l\'association</a>';
			$mail->AddAddress($email);
			$mail->send();

			$flash = new FlashBags();
			$flash->setFlash('warning', 'L\'utilisateur recevera votre invitation par mail.');
		} else {
			// On verifie que ce user est libre (pas dans la table intermediaire)
			$id_user = $this->our_u_model->getIdByEmail($email);
			$free = $this->intermediaire->isFree($id_user);

			if($free == true){
				// On envoi un MP d'invitation au membre
				$invitation = new MessageModel();
			  $message = $invitation->sendInvitation();

				$flash = new FlashBags();
				$flash->setFlash('warning', 'L\'utilisateur recevera votre invitation dans son espace messagerie.');
			} else {
				// On affiche un message d'erreur "ce user a deja rejoint une association"
				$flash = new FlashBags();
				$flash->setFlash('warning', 'Cet utilisateur ne peux pas être invité car il a déjà rejoint une association');
			}

		}
		// le lien revera vers quoi ?
		// si user exist => update table user et intermediaire
		$this->show('admin/back', array(

		));
	}


}
