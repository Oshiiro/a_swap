<?php $this->layout('layout', ['title' => 'Connexion', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>
<div class="extansion-head">
</div>
		<form method="POST" action="<?php echo $this->url('try_login') ?>" class="form-horizontal">
			<div class="container block-message">
			  <div class="row">
			    <div class="block col-xs-10 col-xs-push-1 col-lg-10">
					<h2>Connexion</h2>
					<!-- Si le champ est remplie aucune données entre en BDD -->
					<input type="text" name="antiBot" value="" class="hide">
					<div class="field">
						<label for="emailOrPseudo" class="field-label">Mail ou Pseudo</label>
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
					<input type="submit" class="btn btn-default">
					</form>
				</div>
			</div>
		</div>

<?php $this->stop('main_content') ?>
