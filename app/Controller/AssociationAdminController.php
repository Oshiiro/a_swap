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
use \Services\Pagination;
use \Services\Tools\Tools;
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
	private $tools;

	public function __construct()
	{
		$this->valid = new ValidationTools();
		$this->model = new UsersModel();
		$this->assos = new AssosModel();
		$this->our_u_model = new OurUModel();
		$this->intermediaire = new IntermediaireModel();
		$this->backmodel = new BackModel(); //
		$this->invitation = new InvitationModel();
		$this->tools = new Tools();
	}
// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
	/**
	 * Page Back Association Admin
	 */
	public function backAssos($slug, $page)
	{
		$this->allowTo(array('admin'));
		if ($this->tools->isLogged() == true) {
			$slug_is_mine = $this->assos->slugIsMine($slug);
			if($slug_is_mine == true) {
				$slug = $this->assos->getSlugByIdUser($_SESSION['user']['id']);


				$limit = 10;
				$id_asso = $this->assos->FindElementByElement('id', 'slug', $slug);
				//limit d'affichage par page
				$Pagination = new Pagination('intermediaire');
				//on precise la table a exploiter
				$calcul = $Pagination->calcule_page('id_assos = \''.$id_asso.'\'',$limit,$page);
				//en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
				//ce qui calcule le nombre de page total et le offset
				$pagination_adh = $Pagination->pagination($calcul['page'],$calcul['nb_page'],'admin_back_assos', ['slug' => $slug,'page' => $page]);
				//on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
       debug($calcul);
				$adherants = $this->our_u_model->affAllAdherants($slug, $id_asso, $limit, $calcul['offset']);

				$this->show('association/assos_admin_back', array(

					'slug' => $slug,
					'adherants' => $adherants,
					'page' => $page,
					'pagination_adh'=> $pagination_adh,

				));

			} else {
				$this->showForbidden(); // erreur 403
			}
		} else {
			$this->showForbidden(); // erreur 403
		}

	}



	/**
	 * Modification Association Admin ( page de modif )
	 */
	public function updateAssosForm($slug)
	{
		$this->allowTo(array('admin'));
		$slug_is_mine = $this->assos->slugIsMine($slug);
		if($slug_is_mine == true) {
			$association = $this->assos->ModifAssos();

			$slug = $this->assos->getSlugByIdUser($_SESSION['user']['id']);
			$this->show('association/modifassos_admin_back', array(
				'slug' => $slug,
				'association' => $association,
			));
		} else {
			$this->showForbidden(); // erreur 403
		}
	}

	/**
	 * Modification de l'Association Admin
	 */
	public function updateAssosAction($slug)
	{
		$slug = $this->assos->getSlugByIdUser($_SESSION['user']['id']);
		// protection XSS
		$name   = trim(strip_tags($_POST['name']));
		$description   = trim(strip_tags($_POST['description']));
		$money_name   = trim(strip_tags($_POST['money_name']));
		$rules   = trim(strip_tags($_POST['rules']));
		$id = $this->assos->FindElementByElement('id','name', $_SESSION['user']['nom_assos']);
		// verif de pseudo
		$exist = $this->assos->nameAssosExists($name,'name', 3, 50);

		// si le pseudo est le même que celui de la session, alors c'est good
		if($name == $_SESSION['user']['nom_assos'])
		{
			$exist = false;
		}

		// si l'utilisateur tente de prendre un pseudo deja existant, on le bloque mamene
		if($exist == true)
		{
			$error['name'] = 'Ce nom est déjà pris';
		} else {
			$error['name']   = $this->valid->textValid($name,'name', 3, 50);
		}

		// verif de name
		if(empty($_POST['name'])){
			$error['name'] = 'Veuillez renseigner un nom pour votre association';
		} else {
			$error['name']   = $this->valid->textValid($name,'name', 3, 50);
		}


		// verif de la monnaie de l'assos
		if(empty($_POST['money_name'])){
			$error['money_name'] = 'Veuillez renseigner un nom pour votre monnaie';
		} else {
			$error['money_name']   = $this->valid->textValid($money_name,'money_name', 3, 150);
		}


		// GG si il n'y a pas d'erreur
		if ($this->valid->IsValid($error)){
			$token = StringUtils::randomString(40);
			$data = array(
				'name' => $name,
				'description' => $description,
				'money_name' => $money_name,
				'rules' => $rules,
				'slug' => $slug
			);
			$this->assos->update($data, $id);
			$flash = new FlashBags();
			$flash->setFlash('warning', 'Votre association a bien été modifiée');
		}

			$slug = $this->assos->getSlugByIdUser($_SESSION['user']['id']);
    	$this->show('association/modifassos_admin_back', array(
				'error' => $error,
				'slug' => $slug,
			));
	}



// ===================================================================================================================
// 																						TRAITEMENT DES FORMULAIRES
// ===================================================================================================================

	/**
	* Invitation d'un membre a rejoindre l'assocation
	*/
	public function inviteNewMemberByMail()
	{
		$app = getApp();

		$id_admin = $_SESSION['user']['id'];
		$email   = trim(strip_tags($_POST['mail_invite']));
		$email_sender = $_SESSION['user']['email'];
		$slug = $this->assos->getSlugByIdUser($id_admin);

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
					$mail->Body = $_SESSION['user']['firstname']. ' '. $_SESSION['user']['lastname'] .
												' souhaite vous inviter a rejoindre son association : "' . $name_asso . '". Cliquez ici pour le rejoindre :
												<a href="' .$app->getConfig('url_de_base'). '/inscription/user/' .$token_assos. '/' .$token_invitation. '">Rejoindre l\'association</a>';
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
			$this->redirectToRoute('admin_back_assos', ['slug' => $slug]);

		} else {
			$this->show('admin/back', array(
				'error' => $error,

			));
		}
	}


	//Supprimer un membre de l'association (le compte user existe toujours, mais il ne figure
	// plus dans la table intermediaire.)
	public function deleteUser($id_user) {
		$this->allowTo(array('admin'));

		$id_logged = $_SESSION['user']['id'];
		$slug = $this->assos-> getSlugByIdUser($id_logged);

		// Verifier que le user qu'on est en train de delete fait bien parti de l'asso dont je suis admin
		$isInMyTeam = $this->intermediaire->isInMyteam($id_logged, $id_user);

		if($isInMyTeam == true) {
			$supprimerIntermediaire = $this->intermediaire->DeleteIntermediaireUser($id_user);
			// doit-on faire apparaitre un message de confirmation ?
			$flash = new FlashBags();
			$flash->setFlash('warning', 'Cet utilisateur ne fait désormais plus parti de votre association.');
			$this->redirectToRoute('admin_back_assos', ['slug' => $slug]);
		} else {
			$this->showForbidden(); // erreur 403
		}
	}



}
