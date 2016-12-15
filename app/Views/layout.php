<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="<?= $this->assetUrl('css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/icons/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
</head>
<body>
		<header>

			<div class="container-fluid navbar">
				<div class="row">
					<img src="<?php echo $this->assetUrl('img/logo.png') ?>" class="logo">
					<a href="<?php echo $this->url('login') ?>">Connexion</a>
					<a href="<?php echo $this->url('register_user') ?>">Inscription</a>
				</div>
			</div>

		</header>

		<section>
			<div class="container-fluid">
				<?= $this->section('main_content') ?>
			</div>
		</section>

		<footer>

			<div class="lienFooter">
				<div class="lienRedirectionSite">
					<p>Site :</p>
				<a>Accueil</a><br><a>Connexion</a><br><a>Inscription</a><br><a>Contact</a>
			</div>
			<div class="lienUtiles">
					<p>Liens utiles :</p>
				<a>CGU</a><br><a>Concept</a>
			</div>
			<div class="lienReseaux">
					<p>Rejoingez-nous :</p>
				<a>Facebook</a><br>
				<a>Instagram</a><br>
				<a>Twitter</a><br>
			</div>
			</div>


		</footer>
	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery-3.1.0.min.js') ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>
</body>
</html>
