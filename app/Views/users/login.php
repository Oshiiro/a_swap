<?php $this->layout('layout', ['title' => 'Connexion', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>
<div class="extansion-head">
</div>
<div class="container block-message">
  <div class="row">
	  <div class="block col-xs-10 col-xs-push-1 col-lg-10">
			<form method="POST" action="<?php echo $this->url('try_login') ?>" class="form-horizontal">
				<h2>Connexion</h2>
				<!-- Si le champ est remplie aucune données entre en BDD -->
				<input type="text" name="antiBot" value="" class="hide">
				<div class="field">
					<label for="emailOrPseudo" class="field-label">E-mail ou Pseudo</label>
					<input type="text" class="field-input" name="emailOrPseudo" value="<?php if(!empty($_POST['emailOrPseudo'])) {echo $_POST['emailOrPseudo'];} ?>">
					<span class="errorMessage"><?php if(!empty($error)) { echo($error['emailOrPseudo']);} ?></span>
				</div>
				<div class="field">
					<label for="password" class="field-label">Mot de passe</label>
					<input type="password" class="field-input" name="password">
				</div>
				<div class="checkbox">
					<a href ="<?php echo $this->url('forgot_password') ?>">Mot de passe oublié</a>
				</div>
				<div class="center">
					<button class="btn btn-circle btn-lg validform" type="submit" name="submit" value=""><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php $this->stop('main_content') ?>
