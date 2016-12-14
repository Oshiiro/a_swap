<?php
	$w_routes = array(

		// home / acceuil
		['GET', '/', 'Default#home', 'default_home'],

		// contact
		['GET', '/contact', 'Default#contact', 'contact'],

		// CGU
		['GET', '/cgu', 'Default#cgu', 'cgu'],

		// Inscription
		['GET', '/inscription', 'Default#register', 'register'],
		['POST', '/inscription', 'Default#tryRegister', 'try_register'],

		// Connexion
		['GET', '/connexion', 'Default#login', 'login'],
		['POST', '/connexion', 'Default#tryLogin', 'try_login'],

		


	);
