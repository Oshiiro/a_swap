<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>
	<div class="container">
		<form method="POST">
	  <div class="form-group">

			<!-- Si le champ est remplie aucune données entre en BDD -->
			<input type="text" name="antiBot" value="" class="hide">
			<div class="form-group">
	    	<label for="firstname">Nom</label>
	    	<input type="text" class="form-control" name="firstname">
			</div>
			<div class="form-group">
				<label for="lastname">Prenom</label>
				<input type="text" class="form-control" name="lastname">
			</div>
			<div class="form-group">
				<label for="username">Pseudo</label>
				<input type="text" class="form-control" name="username">
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" name="email">
			</div>
			<div class="form-group">
				<label for="password">Mot de passe</label>
				<input type="password" class="form-control" name="password">
			</div>
			<div class="form-group">
				<label for="password_confirm">Veuillez confirmer votre mot de passe</label>
				<input type="password" class="form-control" name="password_confirm">
			</div>
			<div class="form-group">
				<label><input type="checkbox" value="">J'accepte les <a href="<?php echo $this->url('cgu'); ?>">CGU</a></label>
			</div>
		</div>
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>
</div>
<?php $this->stop('main_content') ?>
