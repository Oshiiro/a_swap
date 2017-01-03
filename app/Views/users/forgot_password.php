<?php $this->layout('layout', ['title' => 'Mot de passe oublié ?']) ?>

<?php $this->start('main_content') ?>
<div class="container">
	<div class="row">
		<form method="POST" action="" class="form-horizontal well formulaire">
			<fieldset>
				<legend><h2>Mot de passe oublié ?</h2></legend>

					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Merci d'indiquer votre adresse mail" value="<?php if(!empty($_POST['email'])) {echo $_POST['email'];} ?>">
						<span class="errorMessage"><?php if(!empty($error)) { echo($error['email']);} ?></span>
					</div>

					<input type="submit" class="btn btn-default">

			</fieldset>
		</form>
	</div>
</div>
<?php $this->stop('main_content') ?>
