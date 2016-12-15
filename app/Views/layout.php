<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="<?= $this->assetUrl('css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/font-awesome.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
</head>
<body>
		<header>
			<div class="container-fluid navbar">
				<div class="row">
					<img src="">
					<a href="<?php echo $this->url('login') ?>">Connexion</a>
					<a href="<?php echo $this->url('register_user') ?>">Inscription</a>
				</div>
			</div>
			<h1>W :: <?= $this->e($title) ?></h1>

		</header>

		<section>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>
	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery-3.1.0.min.js') ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>
</body>
</html>
