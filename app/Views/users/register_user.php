<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>
<div class="extansion-head">
</div>
	<div class="container block-message">
		<div class="row">
			<div class="block col-xs-10 col-xs-push-1 col-lg-10">
				<form method="POST" action="<?php echo $this->url('try_register') ?>" class="">
					<h2>Créer votre compte</h2>

					<!-- Si le champ est remplie aucune données entre en BDD -->
					<input type="text" name="antiBot" value="" class="hide">
					<input type="text" class="hide" name="token_asso" value="<?php if(!empty($token_asso)) { echo $token_asso; } elseif(!empty($_POST['token_asso'])) { echo($_POST['token_asso']);} ?>">
					<input type="text" class="hide" name="token_invit" value="<?php if(!empty($token_invit)) { echo $token_invit; } elseif(!empty($_POST['token_invit'])) { echo($_POST['token_invit']);} ?>">

					<!-- Affichage d'erreur(s) si un des (les) token(s) sont erronés -->
					<span class="errorMessage"><?php if(!empty($error['tokens'])) { echo($error['tokens']);} ?></span>

					<div class="field">
						<label for="lastname" class="field-label">Nom</label>
						<input type="text" class="field-input" name="lastname" value="<?php if(!empty($_POST['lastname'])) {echo $_POST['lastname'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['lastname'])) { echo($error['lastname']);} ?></span>
					</div>
					<div class="field">
						<label for="" class="field-label">Prénom</label>
			    	<input type="text" class="field-input" name="firstname" value="<?php if(!empty($_POST['firstname'])) {echo $_POST['firstname'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['firstname'])) { echo($error['firstname']);} ?></span>
					</div>
					<div class="field">
						<label for="" class="field-label">Pseudo</label>
						<input type="text" class="field-input" name="username" value="<?php if(!empty($_POST['username'])) {echo $_POST['username'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['username'])) { echo($error['username']);} ?></span>
					</div>
					<div class="field">
						<label for="" class="field-label">E-mail</label>
						<input type="email" class="field-input" name="email" value="<?php if(!empty($_POST['email'])) {echo $_POST['email'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['email'])) { echo($error['email']);} ?></span>
					</div>
					<div class="field">
						<label for="" class="field-label">Mot de passe</label>
						<input type="password" class="field-input" name="password">
						<span class="errorMessage"><?php if(!empty($error['password'])) { echo($error['password']);} ?></span>
					</div>
					<div class="field">
						<label for="" class="field-label">Veuiller confirmer votre mot de passe</label>
						<input type="password" class="field-input" name="password_confirm">
						<span class="errorMessage"><?php if(!empty($error['password_confirm'])) { echo($error['password_confirm']);} ?></span>
					</div>
					<div class="form-group center">
						<label><p class="acceptCGU"> <input type="checkbox" name="checkbox" value=""> J'accepte les <u><a href="<?php echo $this->url('cgu'); ?>">CGU</a></u></p></label>
						<span class="errorMessage"><br><?php if(!empty($error['checkbox'])) { echo($error['checkbox']);} ?></span>
					</div>
					<div class="center">
						<button class="btn btn-circle btn-lg validform" type="submit" name="submit" value=""><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php $this->stop('main_content') ?>
