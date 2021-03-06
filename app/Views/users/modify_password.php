<?php $this->layout('layout', ['title' => 'Modifiez votre mot de passe']) ?>

<?php $this->start('main_content') ?>
<div class="container block-message">
  <div class="row">
	  <div class="block col-xs-10 col-xs-push-1 col-lg-10">
			<form method="POST" action="" class="form-horizontal">
				<h2>Modifier votre mot de passe</h2>

        <div class="form-group">
          <span class="errorMessage"><?php if(!empty($error['token'])) { echo($error['token']);} ?></span>
        </div>
				<div class="field">
          <label for="email" class="field-label"></label>
					<input type="email" class="field-input" name="email" placeholder="Adresse e-mail" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; }?>">
					<span class="errorMessage"><?php if(!empty($error['email'])) { echo($error['email']);} ?></span>
				</div>
				<div class="field">
          <label for="password" class="field-label"></label>
					<input type="password" class="field-input" name="password" placeholder="Mot de passe" value="">
					<span class="errorMessage"><?php if(!empty($error['password'])) { echo($error['password']);} ?></span>
				</div>
        <div class="field">
          <label for="repeat" class="field-label"></label>
					<input type="password" class="field-input" name="repeat" placeholder="repetez votre mot de passe" value="">
					<span class="errorMessage"><?php if(!empty($error['repeat'])) { echo($error['repeat']);} ?></span>
				</div>

				<div class="center">
					<button class="btn btn-circle btn-lg validform" type="submit" name="submit" value=""><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php $this->stop('main_content') ?>
