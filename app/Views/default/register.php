<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>
	<h2>Let's code.</h2>
	<p>Vous avez atteint la page d'inscription. Bravo.</p>
	<div class="container">
		<form method="POST">
	  <div class="form-group">
	    <label for="email">Email</label>
	    <input type="email" class="form-control" name="email">
	  </div>
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
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>
</div>
<?php $this->stop('main_content') ?>
