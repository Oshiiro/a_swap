<?php

namespace Controller;

use \Controller\AppController;
use \Services\Tools\ValidationTools;
use \Services\Tools\Tools;
use \W\Model\UsersModel;
use \W\Security\AuthentificationModel;
use \W\Security\StringUtils;


class UserAdminController extends AppController
{

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
    $this->show('admin/Back');
  }

// ===================================================================================================================
// 																						TRAITEMENT DES FORMULAIRES
// ===================================================================================================================
  /**
	 * Page d'inscription Admin traitement
	 */
	public function tryRegisterAdmin()
	{
    $tools = new ValidationTools();
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
    // verifier que le nom de l'asso est dispo.




    // Verification des champs partie admin
    if (isset($_POST['checkbox'])){

    } else {
      $error['checkbox'] = 'Vous n\'avez pas valider les CGU.';;
    }
    // verif que le pseudo de l'admin est libre
    // $exist = $this->model->usernameExists($username,'username', 3, 50);
    // if($exist == true)
    // {
    //   $error['username'] = 'Ce pseudo est déjà pris';
    // } else {
    //   $error['username']   = $this->valid->textValid($username,'username', 3, 50);
    // }

    // verif que le mail de l'admin est libre
    // $exist = $this->model->emailExists($email,'email', 3, 50);
    // if($exist == true){
    //   $error['email'] = 'le mail et deja prit';
    // } else {
    //   $error['email'] = $this->valid->emailValid($email,'email', 3, 50);
    // }

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


    // if (count($error) == 0)
    // => insert table assos
    // => insert table users
    // => insert table intermediaire


    if($password == $password_confirm){

      $passwordHash = AuthentificationModel::hashPassword($password);

      if (count($error) != 0) {
        $token = StringUtils::randomString();
        $slug = Tools::slugify($nom_assos);


        $data = array(
          // Champs de la partie assos
          'nom_assos' => $nom_assos,
          'description_assos' => $description_assos,
          'money_name' => $money_name,
          'rules_assos' => $rules_assos,
          'asso_created_at' => date('Y-m-d H:i:s'),
          'slug' => $slug,
          // Champs de la partie admin
          'firstname' => $firstname,
          'lastname' => $lastname,
          'username' => $username,
          'email' => $email,
          'token' => $token,
          'password' => $passwordHash,
          'role' => 'admin',
          'user_created_at' => date('Y-m-d H:i:s'),
        );

        // $this->model->insert($data);

        // redirection
        $this->show('admin/register_admin', array(
          'data' => $data,
        ));

      } else {
        $this->show('admin/register_admin', array(
          'error' => $error,
        ));
      }

    }	else {
      $error['password'] = 'Les mot de passe ne sont pas identique';
      $this->show('users/register_admin', array(
        'error' => $error
      ));
    }
  }
}
