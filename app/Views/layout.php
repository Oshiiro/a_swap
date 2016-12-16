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
				<a href="<?php echo $this->url('default_home') ?>"><img src="<?php echo $this->assetUrl('img/logo.png') ?>" class="logo"></a>
				<div class="menu">
					<?php if(!empty($_SESSION['user']['role'])) { ?>
					<a href="<?php echo $this->url('message') ?>">Messagerie</a>
					<a href="">Association</a>
						<?php if ($_SESSION['user']['role'] == 'admin') { ?>
						<a href="">Back Office</a>
						<?php } ?>
					<?php } ?>

					<?php if(!empty($_SESSION['user'])) { ?>
					<a href="<?= $this->url('deconnexion') ?>">Deconnexion</a>
					<a><?php echo $_SESSION['user']['username'] ?></a>
					<?php } else { ?>
					<a href="<?php echo $this->url('login') ?>" class="connexion">Connexion</a>
					<a href="<?php echo $this->url('register_user') ?>" class="inscription">Inscription</a>
					<?php } ?>


				</div>
			</div>
		</header>

		<div class="container-fluid">
			<?= $this->section('main_content') ?>
		</div>

		<footer>
			<div class="container lienFooter">
				<div class="lienRedirectionSite col-sm-1">
					<p>Site :</p>
					<a>Accueil</a><br>
					<a>Connexion</a><br>
					<a>Inscription</a><br>
					<a>Contact</a>
				</div>
				<div class="lienUtiles col-sm-1">
					<p>Liens utiles :</p>
					<a>CGU</a><br>
					<a>Concept</a>
				</div>
				<div class="lienReseaux col-sm-1">
					<p>Rejoignez-nous :</p>
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
