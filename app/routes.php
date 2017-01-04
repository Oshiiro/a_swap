<?php
	$w_routes = array(

		// home / accueil
		['GET', '/', 'Default#home', 'default_home'],

		// contact
		['GET', '/contact/', 'Default#contact', 'contact'],
		['POST', '/contact/', 'Default#sendMailContact', 'send_mail_contact'],

		// profil
		['GET', '/profil/', 'User#profil', 'profil'],
		['POST', '/profil/', 'User#updateProfil', 'update_profil'],
		['POST', '/profil/img/', 'User#updateProfilImg', 'update_profil_img'],

		// CGU
		['GET', '/cgu/', 'Default#cgu', 'cgu'],

		// Deconnexion
		['GET', '/deconnexion/', 'User#deconnexion', 'deconnexion'],

		// Inscription User
		['GET', '/inscription/user/[:token_asso]/[:token_invit]', 'User#registerUserFromInvite', 'register_user_from_invite'],
		['GET', '/inscription/user/', 'User#registerUser', 'register_user'],
		['POST', '/inscription/user/', 'User#tryRegister', 'try_register'],

		// Inscription Admin
		['GET', '/inscription/admin_assos/', 'UserAdmin#registerAdmin', 'admin_assos_register'],
		['POST', '/inscription/admin_assos/', 'UserAdmin#tryRegisterAdmin', 'admin_assos_try_register'],

		// Forgot password
		['GET', '/connexion/forgot_password/', 'User#forgotPassword', 'forgot_password'],
		['POST', '/connexion/forgot_password/', 'User#tryForgotPassword', 'try_forgot_password'],

		// Modify password
		['GET', '/connexion/modify_password/', 'User#modifyPassword', 'modify_password'],
		['POST', '/connexion/modify_password/', 'User#tryModifyPassword', 'try_modify_password'],

		// Connexion
		['GET', '/connexion/', 'User#login', 'login'],
		['POST', '/connexion/', 'User#tryLogin', 'try_login'],


		// Association
		['GET', '/association/[:slug]', 'User#association', 'association'], // A faire page detransaction


		// Messagerie
		['GET', '/messagerie/', 'Message#message', 'message'],
		['GET', '/messagerie/reception/', 'Message#getMessage', 'get_message'],
		['POST', '/messagerie/', 'Message#sendMessage', 'send_message'], // surement des parametre a passer en URL, ne pas oublier de changer dans les $this->show concerné
		['POST', '/messagerie/confirmation/', 'Message#confirmAssosInvit', 'confirm_assos_invit'],


		// Admin Back
		// ['GET', '/admin/association/[:slug]', 'UserAdmin#adminAssos', 'admin_assos'],
		['GET', '/admin/nostransactions/[:slug]/[:page]', 'UserAdmin#back', 'admin_back'],
		// ['GET', '/admin/transaction/', 'TransactionAdmin#ShowFormTransaction', 'admin_back_transac'],
		// ['POST', '/admin/transaction/', 'TransactionAdmin#makeTransactionAdmin', 'admin_back_transac_valid'],
		['GET', '/admin/deleteuser/[i:id]', 'AssociationAdmin#deleteUser', 'admin_back_delete'], // Delete user
		['GET', '/admin/crediter/[i:id]', 'TransactionAdmin#ShowFormCredit', 'admin_back_credite'], //credite de l'admin
		['POST', '/admin/crediter/', 'TransactionAdmin#makeCreditAdmin', 'admin_back_credite_valid'], //credite de l'admin

		// Admin Association Back
		['GET', '/admin/back/association/[:slug]/[:page]', 'AssociationAdmin#backAssos', 'admin_back_assos'],
		['GET', '/admin/back/association/modification/[:slug]', 'AssociationAdmin#backAssosModif', 'admin_back_modifassos'],

		// Formulaire pour mettre à jour son assos (changer logo, texte...)
		['GET', '/admin/back/association/modification/', 'AssociationAdmin#backAssosModif', 'admin_association_update_form'],
		['POST', '/admin/back/association/modification/', 'AssociationAdmin#updateaction', 'admin_association_update_action'],
		// ['POST', '/admin/back/association/', 'AssociationAdmin#addCoinToUser', 'admin_back_assos_addcoinuser'],

		// Page accueil users connecté
		['GET', '/accueil/[:slug]', 'User#usersAccueil', 'users_accueil'], // Afficher la page d'accueil du user avec liste des adhérants et bouton transaction
		['GET', '/transaction/[:slug]', 'Transaction#ShowFormTransaction', 'users_accueil_transac'], // Page de transaction, formulaire
		['POST', '/transaction/', 'Transaction#makeTransactionUser', 'users_accueil_transac_valid'], // Post de la transaction user

		// Formulaire pour inviter un nouveau membre
		['GET', '/admin/back/invite/', 'UserAdmin#back', 'admin_association_invite'],
		['POST', '/admin/back/invite/', 'AssociationAdmin#inviteNewMemberByMail', 'admin_association_invite_action'],

		// Action pour accepter une invitation reçu en MP
		['GET', '/acceptinvitation/[:token_asso]/[:token_invit]', 'Invitation#accept', 'accept_invitation'],

		//Super Admin Back
		['GET', '/superadmin/back/', 'SuperAdmin#superAccueil', 'super_admin_back'],
		// Super Admin route user
		// super Admin route asso
		// Super Admin route messagerie.


	);
