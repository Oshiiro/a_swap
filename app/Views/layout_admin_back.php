<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="<?= $this->assetUrl('css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/icons/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style_back.css') ?>">
</head>
<body>
		<header>
			<div class="container-fluid navbar">
				<a href="<?php echo $this->url('default_home') ?>"><img src="<?php echo $this->assetUrl('img/logo.png') ?>" class="logo"></a>
				<div class="menu">
					<a href="<?php echo $this->url('admin_back') ?>">Transactions</a>
					<a href="<?php echo $this->url('admin_back_assos') ?>">Gestion</a>
					<a href="<?php echo $this->url('default_home') ?>">Front Office</a>
					<a href="<?= $this->url('deconnexion') ?>">Deconnexion</a>
					<a href="<?php echo $this->url('profil') ?>"><?php echo $_SESSION['user']['username'] ?></a>
				</div>
			</div>
		</header>

		<div class="container-fluid">

			<?php echo $this->getFlash(); ?>
			<?= $this->section('main_content') ?>
		</div>

		<footer>

		</footer>


	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery-3.1.0.min.js') ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/app.js') ?>"></script>
</body>
</html>
