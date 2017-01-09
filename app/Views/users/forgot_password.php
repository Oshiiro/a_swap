<?php $this->layout('layout', ['title' => 'Mot de passe oublié ?']) ?>

<?php $this->start('main_content') ?>
<div class="container block-message">
  <div class="row">
	  <div class="block col-xs-10 col-xs-push-1 col-lg-10">
			<form method="POST" action="" class="form-horizontal">
				<h2>Mot de passe oublié ?</h2>
				<div class="field">
          <label for="email" class="field-label">Merci d'indiquer votre adresse mail</label>
					<input type="email" class="field-input" name="email" value="<?php if(!empty($_POST['email'])) {echo $_POST['email'];} ?>">
					<span class="errorMessage"><?php if(!empty($error)) { echo($error['email']);} ?></span>
				</div>
				<div class="center">
					<button class="btn btn-circle btn-lg validform" type="submit" name="submit" value=""><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php $this->stop('main_content') ?>
