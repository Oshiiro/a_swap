<?php
	$w_routes = array(

		// home / acceuil
		['GET', '/', 'Default#home', 'default_home'],

		// contact
		['GET', '/contact', 'Default#contact', 'contact'],

		// CGU
		['GET', '/cgu', 'Default#cgu', 'cgu'],

		// Inscription
		['GET', '/inscription', 'User#register', 'register'],
		['POST', '/inscription', 'User#tryRegister', 'try_register'],

		// Connexion
		['GET', '/connexion', 'User#login', 'login'],
		['POST', '/connexion', 'User#tryLogin', 'try_login'],

		// AdminAssociation
		['GET', '/admin/association', 'AssociationAdmin#adminAssociation', 'admin_association'],

		// Formulaire pour mettre à jour son assos (changer logo, texte...)
		['GET', '/admin/association/update/[i:id]', 'AssociationAdmin#updateform', 'admin_association_update_form'],
		['POST', '/admin/association/update/[i:id]', 'AssociationAdmin#updateaction', 'admin_association_update_action'],

	);
