<?php

namespace Controller;

use \Controller\AppController;
use \Model\BackModel;
use \Services\Tools\ValidationTools;
use \Services\Tools\Tools;
use \Model\UsersModel;
use \Model\AssosModel;
use \Model\IntermediaireModel;
use \W\Security\AuthentificationModel;
use \W\Security\StringUtils;
use \Services\Flash\FlashBags;


class UserAdminController extends AppController
{
  private $valid;
  private $tools;
  private $model_user;
	private $model_assos;
	private $model_intermediaire;
  private $authentificationmodel;


  public function __construct()
	{
		$this->valid = new ValidationTools();
    $this->tools = new Tools();
		$this->model_user = new UsersModel();
    $this->model_assos = new AssosModel();
    $this->model_intermediaire = new IntermediaireModel();
		$this->authentificationmodel = new AuthentificationModel();
    $this->backmodel = new BackModel();

	}
// ===================================================================================================================
// 																								AFFICHAGE DES PAGES
// ===================================================================================================================
  /**
   * Page d'inscription Admin
   */
  public function registerAdmin()
  {
    $nom_assos = (!empty($_POST['nom_assos'])) ? trim(strip_tags($_POST['nom_assos'])) : null;
    $data = 'test';

    $this->show('admin/register_admin', array(
      'nom_assos' => $nom_assos,
      'data' => $data,
    ));
  }

  /**
   * Page Back de l'admin
   */



  public function back()
  {
    $trans = $this->backmodel->GetTrans();
    $this->show('admin/back',
     array(
      'trans' => $trans
    )
  );
  }

// ===================================================================================================================
// 																						TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
  /**
	 * Page d'inscription Admin traitement
	 */
	public function tryRegisterAdmin()
	{
    $validation = new ValidationTools();
    $error = array();

    // xss partie assos
    $nom_assos = (!empty($_POST['nom_assos'])) ? trim(strip_tags($_POST['nom_assos'])) : null;
    $description_assos = (!empty($_POST['description_assos'])) ? trim(strip_tags($_POST['description_assos'])) : null;
    $money_name = (!empty($_POST['money_name'])) ? $password = trim(strip_tags($_POST['money_name'])) : null;
    $rules_assos = (!empty($_POST['rules_assos'])) ? trim(strip_tags($_POST['rules_assos'])) : null;

    //xss partie admin
    $lastname   = (!empty($_POST['lastname'])) ? trim(strip_tags($_POST['lastname'])) : null;
    $firstname   = (!empty($_POST['firstname'])) ? trim(strip_tags($_POST['firstname'])) : null;
    $username   = (!empty($_POST['username'])) ? trim(strip_tags($_POST['username'])) : null;
    $email = (!empty($_POST['email'])) ? trim(strip_tags($_POST['email'])) : null;
    $password  = (!empty($_POST['password'])) ? trim(strip_tags($_POST['password'])) : null;
    $password_confirm  = (!empty($_POST['password_confirm'])) ? trim(strip_tags($_POST['password_confirm'])) : null;

    //Captcha du pauvre : cet input ne s'affiche pas dans le formulaire ;
    // s'il contient une valeur, c'est donc un bot qui a rempli le formulaire.
    if(!empty($_POST['antiBot'])){
      $error['antiBot'] = 'BIM';
    }


    // Verification des champs partie assos
    // verifier que le nom de l'asso est libre.
    $exist = $this->model_assos->assoExists($nom_assos);
    if($exist == true)
    {
      $error['name_asso'] = 'Ce nom d\'association est déjà pris';
    } else {
      $error['name_asso']   = $this->valid->textValid($nom_assos,'nom d\'association', 3, 50);
    }
    // verifier que le descriptif n'est pas trop long
    if(!empty($_POST['description_assos'])){
      $error['description_assos']   = $this->valid->textValid($description_assos,'description de l\'association', 0, 5000);
    }
    // verifier que le nom de la monnaie n'est ni trop court, ni trop long
    if(empty($_POST['money_name'])){
      $error['money_name'] = 'Veuillez donner un nom à votre monnaie';
    } else {
      $error['money_name']   = $this->valid->textValid($money_name,'nom de monnaie', 3, 50);
    }
    // verifier que le reglement n'est pas trop long
    if(!empty($_POST['rules_assos'])){
      $error['rules_assos']   = $this->valid->textValid($rules_assos,'regles de fonctionnement', 0, 5000);
    }


    // Verification des champs partie admin
    if (isset($_POST['checkbox'])){

    } else {
      $error['checkbox'] = 'Vous n\'avez pas validé les CGU.';
    }
    // verif que le pseudo de l'admin est libre
    $exist = $this->model_user->usernameExists($username,'username', 3, 50);
    if($exist == true)
    {
      $error['username'] = 'Ce pseudo est déjà pris';
    } else {
      $error['username']   = $this->valid->textValid($username,'username', 3, 50);
    }

    // verif que le mail de l'admin est libre
    $exist = $this->model_user->emailExists($email,'email', 3, 50);
    if($exist == true){
      $error['email'] = 'Ce mail est déjà pris';
    } else {
      $error['email'] = $this->valid->emailValid($email,'email', 3, 50);
    }

    if(empty($_POST['lastname'])){
      $error['lastname'] = 'Veuillez renseigner un prenom';
    } else {
      $error['lastname']   = $this->valid->textValid($lastname,'lastname', 3, 50);
    }

    if(empty($_POST['firstname'])){
      $error['firstname'] = 'Veuillez renseigner un nom';
    } else {
      $error['firstname']   = $this->valid->textValid($firstname,'firstname', 3, 50);
    }

    if(empty($_POST['password'])){
      $error['password'] = 'Veuillez renseginer le mot de passe';
    }

    if(empty($_POST['password_confirm'])){
      $error['password_confirm'] = 'Veuillez saisir votre mot de passe une seconde fois';
    }

    if($password == $password_confirm){

      $passwordHash = $this->authentificationmodel->hashPassword($password);

      if ($this->valid->IsValid($error)) {
        $token_asso = StringUtils::randomString(40);
        $slug_asso = $this->tools->slugify($nom_assos);
        $token_user = StringUtils::randomString(40);
        $slug_user = $firstname. ' ' .$username. ' ' .$lastname;
        $slug_user = $this->tools->slugify($slug_user);

        $data_asso = array(
          // Champs de la partie assos
          'name' => $nom_assos,
          'description' => $description_assos,
          'money_name' => $money_name,
          'rules' => $rules_assos,
          'created_at' => date('Y-m-d H:i:s'),
          'active' => 1,
          'slug' => $slug_asso,
          'token' => $token_asso,
        );
        $data_user = array(
          // Champs de la partie admin
          'firstname' => $firstname,
          'lastname' => $lastname,
          'username' => $username,
          'email' => $email,
          'token' => $token_user,
          'slug' => $slug_user,
          'password' => $passwordHash,
          'role' => 'admin',
          'active' => 1,
          'created_at' => date('Y-m-d H:i:s'),
        );

        // Insert dans la table assos
        $this->model_assos->insert($data_asso);
        // Insert dans la table users
        $this->model_user->insert($data_user);

        // Preparation de l'array $data_intermediaire
        $data_intermediaire = $this->model_intermediaire->getAssoAndAdmin($slug_asso, $username);
        // Insert dans la table intermediaire
        $this->model_intermediaire->insert($data_intermediaire);

        // redirection
        $flash = new FlashBags();
				$flash->setFlash('warning', 'Bravo vous etes inscrit et votre association a bien été créée');
        $this->show('users/login');

      } else {
        $this->show('admin/register_admin', array(
          'error' => $error,
        ));
      }

    }	else {
      $error['password'] = 'Les mots de passe ne sont pas identiques';
      $this->show('admin/register_admin', array(
        'error' => $error,
      ));
    }

  }
}
