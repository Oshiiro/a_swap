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
			<nav class="navbar">
				<div class="wrap">
					<div class="container-fluid">
						<div class="navbar-header">
							<div class="navbar-default">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
						<a href="<?php echo $this->url('default_home') ?>"><img src="<?php echo $this->assetUrl('img/logo.png') ?>" class="logo"></a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="<?php echo $this->url('admin_back', ['slug' => $this->e($slug), 'page'=>1]) ?>">Transactions</a></li>
								<li><a href="<?php echo $this->url('admin_back_assos', ['slug' => $this->e($slug), 'page' => 1]) ?>">Gestion</a></li>
								<li><a href="<?php echo $this->url('association', ['slug' => $this->e($slug), 'page' => 1]) ?>">Front Office</a></li>
								<li><a href="<?php echo $this->url('admin_back_modifassos', ['slug' => $this->e($slug)]) ?>"><?php echo $_SESSION['user']['nom_assos'] ?></a></li> <!-- possibilité de modifier l'assos -->
								<li><a href="<?= $this->url('deconnexion') ?>">Deconnexion</a><li>
							</ul>
						</div>
					</div>
					<div class="extension_head"></div>
				</div>
			</nav>
		</header>

		<div class="allContent">
			<?php echo $this->getFlash(); ?>
			<?= $this->section('main_content') ?>
		</div>

		<footer>
			<div class="lienFooter">
				<div class="wrap">
					<div class="container">
						<div class="row">
							<div class="lienRedirectionSite col-md-4">
								<p>Site :</p>
								<a href="<?php echo $this->url('default_home') ?>">Accueil</a><br>
								<a href="<?php echo $this->url('login') ?>">Connexion</a><br>
								<a href="<?php echo $this->url('register_user') ?>">Inscription</a><br>
								<a href="<?php echo $this->url('contact') ?>">Contact</a>
							</div>
							<div class="lienUtiles col-md-4">
								<p>Liens utiles :</p>
								<a href="<?php echo $this->url('cgu') ?>">CGU</a><br>
								<a>Concept</a>
							</div>
							<div class="lienReseaux col-md-4 navbar-right">
								<p>Rejoignez-nous :</p>
								<a><i class="fa fa-facebook-official" aria-hidden="true"></i></a><br>
								<a>Instagram</a><br>
								<a href="https://twitter.com/aswap" class="twitter-follow-button" data-show-count="false">Follow @a-swap</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script><br>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>


	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery-3.1.0.min.js') ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/app.js') ?>"></script>
</body>
</html>
