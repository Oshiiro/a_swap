<?php $this->layout('layout', ['title' => 'Modifiez votre mot de passe']) ?>

<?php $this->start('main_content') ?>
<div class="container">
	<div class="row">
		<form method="POST" action="" class="form-horizontal well formulaire">
			<fieldset>
				<legend><h2>Modifier votre mot de passe</h2></legend>

	        <div class="form-group">
            <span class="errorMessage"><?php if(!empty($error['token'])) { echo($error['token']);} ?></span>
          </div>
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Adresse e-mail" value="">
						<span class="errorMessage"><?php if(!empty($error['email'])) { echo($error['email']);} ?></span>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Mot de passe" value="">
						<span class="errorMessage"><?php if(!empty($error['password'])) { echo($error['password']);} ?></span>
					</div>
          <div class="form-group">
						<input type="password" class="form-control" name="repeat" placeholder="repetez votre mot de passe" value="">
						<span class="errorMessage"><?php if(!empty($error['repeat'])) { echo($error['repeat']);} ?></span>
					</div>

					<input type="submit" class="btn btn-default" value="Valider">

			</fieldset>
		</form>
	</div>
</div>
<?php $this->stop('main_content') ?>
