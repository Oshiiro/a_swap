<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>
	<div class="container">
		<form method="POST" class="form-horizontal well">
			<fieldset>
				<legend>Créer votre compte</legend>
	  		<div class="form-group col-md-12">
					<!-- Si le champ est remplie aucune données entre en BDD -->
					<input type="text" name="antiBot" value="" class="hide">
					<div class="form-group">
			    	<input type="text" class="form-control" name="firstname" placeholder="Nom">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="lastname" placeholder="Prenom">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="username" placeholder="Pseudo">
					</div>
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Mot de passe">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password_confirm" placeholder="Veuillez confirmer votre mot de passe">
					</div>
					<div class="form-group">
						<label><input type="checkbox" value="">J'accepte les <a href="<?php echo $this->url('cgu'); ?>">CGU</a></label>
					</div>
					<input type="submit" class="btn btn-default">
				</div>
		</fieldset>
	</form>
</div>
<?php $this->stop('main_content') ?>
