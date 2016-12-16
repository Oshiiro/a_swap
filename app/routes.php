<?php
	$w_routes = array(

		// home / acceuil
		['GET', '/', 'Default#home', 'default_home'],

		// contact
		['GET', '/contact', 'Default#contact', 'contact'],
		['POST', '/contact', 'Default#sendMailContact', 'send_mail_contact'],

		// CGU
		['GET', '/cgu', 'Default#cgu', 'cgu'],

		// Deconnexion
		['GET', '/deconnexion', 'User#deconnexion', 'deconnexion'],

		// Inscription User
		['GET', '/inscription/user', 'User#registerUser', 'register_user'],
		['POST', '/inscription/user', 'User#tryRegister', 'try_register'],

		// Inscription Admin
		['POST', '/inscription/admin_assos', 'UserAdmin#registerAdmin', 'admin_assos_register'],
		['POST', '/inscription/admin_assos', 'UserAdmin#tryRegisterAdmin', 'admin_assos_try_register'],

		// Connexion
		['GET', '/connexion', 'User#login', 'login'],
		['POST', '/connexion', 'User#tryLogin', 'try_login'],

		// Association
		['GET', '/association', 'Association#assos', 'association'],

		// Messagerie
		['GET', '/messagerie', 'Message#message', 'message'],
		['GET', '/messagerie/reception', 'Message#getMessage', 'get_message'],
		['POST', '/messagerie', 'Message#sendMessage', 'send_message'], // surement des parametre a passer en URL, ne pas oublier de changer dans les $this->show concerné
		['POST', '/messagerie/confirmation', 'Message#confirmAssosInvit', 'confirm_assos_invit'],

		// Admin Back
		['GET', '/admin/back', 'UserAdmin#back', 'admin_back'],

		// Admin Association Back
		['GET', '/admin/back/association', 'AssociationAdmin#backAssos', 'admin_back_assos'],
		['POST', '/admin/back/association', 'AssociationAdmin#backAssosModify', 'admin_back_assos_modified'],

		// Formulaire pour mettre à jour son assos (changer logo, texte...)
		['GET', '/admin/association/update/[i:id]', 'AssociationAdmin#updateform', 'admin_association_update_form'],
		['POST', '/admin/association/update/[i:id]', 'AssociationAdmin#updateaction', 'admin_association_update_action'],

	);
