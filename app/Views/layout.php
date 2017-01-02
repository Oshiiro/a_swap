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
			<nav class="navbar">
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
			        <?php if(!empty($_SESSION['user']['role'])) { ?>
			        <li><a href="<?php echo $this->url('message') ?>">Messagerie</a></li>

			          <?php if ($_SESSION['user']['role'] == 'admin') { ?>
							<li><a href="<?php echo $this->url('admin_assos') ?>">Association</a></li>
			        <li><a href="<?php echo $this->url('admin_back') ?>">Back Office</a></li>
			          <?php } else { ?> <li><a href="<?php echo $this->url('users_accueil') ?>">Association</a></li><?php }?>
			        <?php } ?>
			        <?php if(!empty($_SESSION['user'])) { ?>
			        <li><a href="<?php echo $this->url('profil') ?>"><?php echo $_SESSION['user']['username'] ?></a></li>
							<li><a href="<?= $this->url('deconnexion') ?>">Deconnexion</a></li>
			        <?php } else { ?>
								<li><a href="<?php echo $this->url('try_register') ?>" class="inscription">Inscription</a></li>
			        	<li><a href="<?php echo $this->url('login') ?>" class="connexion">Connexion</a></li>
			    		<?php } ?>
						</ul>
					</div>
			  </div>
			</nav>
		</header>

		<div class="container-fluid allContent">

			<?php if (!empty($_SESSION['flash']['message'])) { ?>
				<?php echo $this->getFlash(); ?>
			<?php } ?>

			<?= $this->section('main_content') ?>

		</div>

		<footer>
			<div class="container lienFooter">
				<div class="lienRedirectionSite col-sm-1">
					<p>Site :</p>
					<a href="<?php echo $this->url('default_home') ?>">Accueil</a><br>
					<a href="<?php echo $this->url('login') ?>">Connexion</a><br>
					<a href="<?php echo $this->url('register_user') ?>">Inscription</a><br>
					<a href="<?php echo $this->url('contact') ?>">Contact</a>
				</div>
				<div class="lienUtiles col-sm-1">
					<p>Liens utiles :</p>
					<a href="<?php echo $this->url('cgu') ?>">CGU</a><br>
					<a>Concept</a>
				</div>
				<div class="lienReseaux col-sm-1 navbar-right">
					<p>Rejoignez-nous :</p>
					<a><i class="fa fa-facebook-official" aria-hidden="true"></i></a><br>
					<a>Instagram</a><br>
					<a href="https://twitter.com/aswap" class="twitter-follow-button" data-show-count="false">Follow @a-swap</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script><br>
				</div>

			</div>
		</footer>


	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery-3.1.0.min.js') ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/app.js') ?>"></script>
</body>
</html>
