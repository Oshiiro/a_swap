<?php $this->layout('layout', ['title' => 'Connexion']) ?>

<?php $this->start('main_content') ?>
<div class="container">
	<form method="POST" action="<?php echo $this->url('try_login') ?>" class="form-horizontal well">
		<fieldset>
			<legend>Connexion</legend>
			<div class="form-group col-md-12">
				<!-- Si le champ est remplie aucune données entre en BDD -->
				<input type="text" name="antiBot" value="" class="hide">
				<div class="form-group">
					<?php if(!empty($error['emailOrPseudo'])) { echo $error['emailOrPseudo']; }?>
					<input type="text" class="form-control" name="emailOrPseudo" placeholder="Nom ou pseudo">
				</div>
				<div class="form-group">
					<?php if(!empty($error['mdp'])) { echo $error['mdp']; }?>
					<input type="password" class="form-control" name="mdp" placeholder="Mot de Passe">
				</div>
				<div class="checkbox">
					<a href ="#">Mot de passe oublié</a>
				</div>
				<input type="submit" class="btn btn-default">
			</div>
		</fieldset>
	</form>
</div>
<?php $this->stop('main_content') ?>
