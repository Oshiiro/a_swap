<?php $this->layout('layout', ['title' => 'Connexion']) ?>

<?php $this->start('main_content') ?>
<div class="container">
	<div class="row">
	<form method="POST" action="<?php echo $this->url('try_login') ?>" class="form-horizontal well formulaire">
		<fieldset>
			<legend><h2>Connexion</h2></legend>

				<!-- Si le champ est remplie aucune données entre en BDD -->
				<input type="text" name="antiBot" value="" class="hide">
				<div class="form-group col-sm-6">
					<input type="text" class="form-control" name="emailOrPseudo" placeholder="Nom ou pseudo" value="<?php if(!empty($_POST['emailOrPseudo'])) {echo $_POST['emailOrPseudo'];} ?>">
					<span class="errorMessage"><?php if(!empty($error)) { echo($error['emailOrPseudo']);} ?></span>
				</div>
				<div class="form-group col-sm-6">
					<input type="password" class="form-control" name="password" placeholder="Mot de Passe">

				</div>
				<div class="checkbox">
					<a href ="#">Mot de passe oublié</a>
				</div>
				<input type="submit" class="btn btn-default">

		</fieldset>
	</form>
</div>
</div>
<?php $this->stop('main_content') ?>
