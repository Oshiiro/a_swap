<?php

namespace Controller;

use \Controller\AppController;
use \W\Model\UsersModel;
use \W\Security\StringUtils;
use \Model\UsersModel as OurUModel;
use \Model\IntermediaireModel;
use \Model\AssosModel;
use \Model\MessageModel;
use \Model\InvitationModel;
use \Services\Flash\FlashBags;
use \Services\Tools\ValidationTools;
use \Model\BackModel;
use PHPMailer;


class AssociationAdminController extends AppController
{
	private $valid;
	private $model;
	private $assos;
	private $our_u_model;
	private $intermediaire;
	private $invitation;

	public function __construct()
	{
		$this->valid = new ValidationTools();
		$this->model = new UsersModel();
		$this->assos = new AssosModel();
		$this->our_u_model = new OurUModel();
		$this->intermediaire = new IntermediaireModel();
		$this->backmodel = new BackModel(); //
		$this->invitation = new InvitationModel();
	}
// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page Back Association Admin
	 */
	public function backAssos()
	{
		$adherants = $this->backmodel->affAdherants();
		$this->show('association/assos_admin_back', array( 'adherants' => $adherants));


	}

	/**
	 * Modification Association Admin ( page de modif )
	 */
	public function backAssosModif()
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
		$email_sender = $_SESSION['user']['email'];

		// On verifie que c'est bien une adresse mail qui a été renseignée
		$error['email'] = $this->valid->emailValid($email,'email', 3, 50);
		if ($this->valid->IsValid($error)) {

			$invit_exist = $this->invitation->invitationExist($email_sender, $email);
			// On verifie que cette invitation n'existe pas deja
			if($invit_exist == true) {
				$flash = new FlashBags();
				$flash->setFlash('warning', 'Cet utilisateur à déja une invitation de votre part en attente.');

			} else {

				// On verifie que cet email existe dans la table Users
				$exist = $this->model->emailExists($email,'email', 3, 50);
				if($exist == false) {
					$token_assos = $this->assos->getToken($id_admin);
					$name_asso = $this->assos->getNameByIdAdmin($id_admin);
					$token_invitation = StringUtils::randomString(40);
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
												<a href="http://localhost/a_swap/public/inscription/user/' .$token_assos. '/' .$token_invitation. '">Rejoindre l\'association</a>';
					$mail->AddAddress($email);
					$mail->send();

					$data_invit = array(
						'email_sender' => $email_sender,
						'email_receiver' => $email,
						'token_asso' => $token_assos,
						'token_invit' => $token_invitation,
						'type' => 'email',
						'created_at' => date('Y-m-d H:i:s'),
						'status' => 'waiting',
					);
					$this->invitation->insert($data_invit);


					$flash = new FlashBags();
					$flash->setFlash('warning', 'L\'utilisateur recevera votre invitation par mail.');
				} else {
					$token_assos = $this->assos->getToken($id_admin);
					$token_invitation = StringUtils::randomString(40);

					// On verifie que ce user est libre (pas dans la table intermediaire)
					$id_user = $this->our_u_model->getIdByEmail($email);
					$free = $this->intermediaire->isFree($id_user);

					if($free == true){
						// On envoi un MP d'invitation au membre
						$invitation = new MessageModel();
					  $message = $invitation->sendInvitation($id_user, $token_invitation);

						$data_invit = array(
							'email_sender' => $_SESSION['user']['email'],
							'email_receiver' => $email,
							'token_asso' => $token_assos,
							'token_invit' => $token_invitation,
							'type' => 'private_message',
							'created_at' => date('Y-m-d H:i:s'),
							'status' => 'waiting',
						);
						$this->invitation->insert($data_invit);

						$flash = new FlashBags();
						$flash->setFlash('warning', 'L\'utilisateur recevera votre invitation dans son espace messagerie.');
					} else {
						// On affiche un message d'erreur "ce user a deja rejoint une association"
						$flash = new FlashBags();
						$flash->setFlash('warning', 'Cet utilisateur ne peux pas être invité car il a déjà rejoint une association');
					}

				}
			}
			$this->redirectToRoute('admin_back_assos');

		} else {
			$this->show('admin/back', array(
				'error' => $error,
			));
		}
	}


//Supprimer un membre de l'association (le compte user existe toujours, mais il ne figure
// plus dans la table intermediaire.)
public function deleteUser($id_user) {
	$supprimerIntermediaire = $this->intermediaire->DeleteIntermediaireUser($id_user);
	// doit-on faire apparaitre un message de confirmation ?
	$flash = new FlashBags();
	$flash->setFlash('warning', 'Cet utilisateur ne fait désormais plus parti de votre association.');
	$this->redirectToRoute('admin_back_assos');

}



}
