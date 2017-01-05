<?php $this->layout('layout', ['title' => 'Contact']) ?>

<?php $this->start('main_content') ?>
<div class="container block-message">
	<div class="block col-xs-9 col-xs-push-2 col-md-push-1 col-lg-10">
		<form class="formulaire" action="" method="POST">
			<h2>Contact</h2>
			<div class="field">
				<label for="email" class="field-label">Email</label>
				<input type="text" name="email" class="field-input" value="">
			</div>
			<div class="field">
				<label for="objet" class="field-label">Objet</label>
				<input type="text" name="objet" class="field-input" value="">
			</div>
			<div class="field">
				<label for="objet" class="field-label">Objet</label>
				<textarea name="objet"  class="materialize-textarea field-input"></textarea>
			</div>
			<input type="submit" class="btn btn-default">
		</form>
	</div>
</div>
<?php $this->stop('main_content') ?>
