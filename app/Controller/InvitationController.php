<?php

namespace Controller;

use \Controller\AppController;
use \Model\InvitationModel;
use \Services\Flash\FlashBags;
use \Model\UsersModel as OurUModel;
use \Model\AssosModel;
use \Model\IntermediaireModel;
use \W\Security\StringUtils;


class InvitationController extends AppController
{
  private $model_invitation;
  private $model_assos;
  private $model_intermediaire;
  private $ourumodel;

  public function __construct()
	{
		$this->model_invitation = new InvitationModel();
    $this->model_assos = new AssosModel();
    $this->model_intermediaire = new IntermediaireModel();
		$this->ourumodel = new OurUModel();
	}
// ===================================================================================================================
//
// ===================================================================================================================
  /**
	* Page Association
	*/
	public function accept($token_asso, $token_invit)
	{

    $id_user = $_SESSION['user']['id'];
    $user_is_free = $this->model_intermediaire->isFree($id_user);
    $invit_exist = $this->model_invitation->invationIsValid($token_asso, $token_invit);

    if($invit_exist == false){
      // si les tokens dans l'url ne correspondent pas a une invtitation qui existe
      // on renvoi vers la page de messagerie avec un flashMessage d'erreur.

      $flash = new FlashBags();
      $flash->setFlash('warning', 'Vous utilisez une invitation privée invalide');
      $this->redirectToRoute('message');
    } elseif ($user_is_free == false) {
      // si le user a deja rejoint une asso (il est deja dans la table intermediaire) :
      // on renvoi vers la page de messagerie avec un flashMessage d'erreur.

      $flash = new FlashBags();
      $flash->setFlash('warning', 'Vous ne pouvez pas rejoindre plusieurs associations.');
      $this->redirectToRoute('message');
    } else {
      // sinon, on fait un insert dans intermediaire et on maj l'invitation dans la table
      // correspondante puis on redirige.
      $id_assos = $this->model_assos->getIdByToken($token_asso);

      $data_intermediaire = array(
        'id_users' => $id_user,
        'id_assos' => $id_assos,
        'created_at' => date('Y-m-d H:i:s'),
        'role' => 'user',
      );
      $this->model_intermediaire->insert($data_intermediaire);

      $id_invitation = $this->model_invitation->getIdByTokens($token_asso, $token_invit);
      $data_invitation = array(
        'token_invit' => StringUtils::randomString(40),
        'status' => 'accepted',
        'modified_at' => date('Y-m-d H:i:s'),
      );
      // MAJ du token_invit, du status et du modified_at
      $this->model_invitation->update($data_invitation, $id_invitation);

      $flash = new FlashBags();
      $flash->setFlash('warning', 'Vous avez bien rejoint l\'association');
      $this->redirectToRoute('message');
    }
	}



}
