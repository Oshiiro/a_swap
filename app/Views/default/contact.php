<?php $this->layout('layout', ['title' => 'Contact', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>

<div class="container block-message">
	<div class="block col-xs-9 col-xs-push-2 col-md-push-1 col-lg-10">
		<form class="" action="" method="POST">
			<h2>Contact</h2>
			<div class="field">
				<label for="email" class="field-label">Votre e-mail</label>
				<input type="email" name="email" class="field-input" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
				<span class="errorMessage"><?php if(!empty($error['email'])) { echo($error['email']);} ?></span>
			</div>
			<div class="field">
				<label for="objet" class="field-label">Objet</label>
				<input type="text" name="objet" class="field-input" value="<?php if(!empty($_POST['objet'])) { echo $_POST['objet']; } ?>">
				<span class="errorMessage"><?php if(!empty($error['objet'])) { echo($error['objet']);} ?></span>
			</div>
			<div class="textfield field" style="margin-bottom: 60px;">
				<label for="content" class="field-label">Message</label>
				<textarea name="content"  class="materialize-textarea field-input"><?php if(!empty($_POST['content'])) { echo $_POST['content']; } ?></textarea>
				<span class="errorMessage"><?php if(!empty($error['content'])) { echo($error['content']);} ?></span>
			</div>
			<input type="submit" class="btn btn-default">
		</form>
	</div>
</div>

<?php $this->stop('main_content') ?>
