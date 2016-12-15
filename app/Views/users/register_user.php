<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>
	<div class="container">
		<form method="POST" action="<?php echo $this->url('try_register') ?>" class="form-horizontal well">
			<fieldset>
				<legend>Créer votre compte</legend>
	  		<div class="form-group col-md-12">
					<!-- Si le champ est remplie aucune données entre en BDD -->
					<input type="text" name="antiBot" value="" class="hide">
					<div class="form-group">
			    	<input type="text" class="form-control" name="firstname" placeholder="Nom" value="<?php if(!empty($_POST['firstname'])) {echo $_POST['firstname'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['firstname'])) { echo($error['firstname']);} ?></span>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="lastname" placeholder="Prenom" value="<?php if(!empty($_POST['lastname'])) {echo $_POST['lastname'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['lastname'])) { echo($error['lastname']);} ?></span>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="username" placeholder="Pseudo" value="<?php if(!empty($_POST['username'])) {echo $_POST['username'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['username'])) { echo($error['username']);} ?></span>
					</div>
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(!empty($_POST['email'])) {echo $_POST['email'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['email'])) { echo($error['email']);} ?></span>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Mot de passe">
						<span class="errorMessage"><?php if(!empty($error['password'])) { echo($error['password']);} ?></span>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password_confirm" placeholder="Veuillez confirmer votre mot de passe">
						<span class="errorMessage"><?php if(!empty($error['password_confirm'])) { echo($error['password_confirm']);} ?></span>
					</div>
					<div class="form-group">
						<label><input type="checkbox" name="checkbox" value="">J'accepte les <a href="<?php echo $this->url('cgu'); ?>">CGU</a></label>
						<span class="errorMessage"><br><?php if(!empty($error['checkbox'])) { echo($error['checkbox']);} ?></span>
					</div>
					<input type="submit" class="btn btn-default">
				</div>
		</fieldset>
	</form>
</div>
<?php $this->stop('main_content') ?>
