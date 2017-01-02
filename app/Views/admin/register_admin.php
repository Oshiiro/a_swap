<?php $this->layout('layout', ['title' => 'Creez votre association']) ?>

<?php $this->start('main_content') ?>

	<h2>Creez la page de votre asso</h2>
  <!-- RESTE A PREVOIR/FAIRE : uploader le logo de l'assoc -->
  <div class="container">
    <form class="formulaire" action="" method="POST">
      <fieldset>
        <legend><h2>L'association :</h2></legend>
	        <!-- partie du formulaire pour la creation de l'asso -->
					<div class="form-group">

			      <div class="form-group">
			        <input type="text" name="nom_assos" class="form-control" placeholder="Nom de l'association" value="<?php if(!empty($_GET['nom_assos'])) { echo $_GET['nom_assos']; } elseif(!empty($_POST['nom_assos'])) { echo $_POST['nom_assos']; } ?>">
							<span class="errorMessage"><?php if(!empty($error['name_asso'])) { echo($error['name_asso']);} ?></span>
						</div>

		        <div class="form-group">
		          <textarea name="description_assos"  class="form-control" placeholder="Descriptif de votre association (facultatif)"><?php if(!empty($_POST['description_assos'])) { echo $_POST['description_assos']; } ?></textarea>
							<span class="errorMessage"><?php if(!empty($error['description_assos'])) { echo($error['description_assos']);} ?></span>
					  </div>

		        <div class="form-group">
		          <input type="text" name="money_name" class="form-control" placeholder="Nom de votre monnaie" value="<?php if(!empty($_POST['money_name'])) { echo $_POST['money_name']; } ?>">
							<span class="errorMessage"><?php if(!empty($error['money_name'])) { echo($error['money_name']);} ?></span>
					  </div>

		        <div class="form-group">
		          <textarea name="rules_assos" class="form-control" placeholder="Vous pouvez ici decrire la façon dont est gérée votre monnaie associative (facultatif)"><?php if(!empty($_POST['rules_assos'])) { echo $_POST['rules_assos']; } ?></textarea>
							<span class="errorMessage"><?php if(!empty($error['rules_assos'])) { echo($error['rules_assos']);} ?></span>
					  </div>

					</div>
      </fieldset>
			<br><br><br><br>
      <fieldset>
        <legend><h2>Le tresorier :</h2></legend>
      <!-- formulaire de creation de l'admin -->
    	  <div class="form-group">
    			<!-- Si le champ est remplie aucune données entre en BDD -->
    			<input type="text" name="antiBot" value="" class="hide">

					<div class="form-group">
						<input type="text" class="form-control" name="lastname" placeholder="Nom" value="<?php if(!empty($_POST['lastname'])) {echo $_POST['lastname'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['lastname'])) { echo($error['lastname']);} ?></span>
					</div>
					<div class="form-group">
			    	<input type="text" class="form-control" name="firstname" placeholder="Prenom" value="<?php if(!empty($_POST['firstname'])) {echo $_POST['firstname'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['firstname'])) { echo($error['firstname']);} ?></span>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="username" placeholder="Pseudo" value="<?php if(!empty($_POST['username'])) {echo $_POST['username'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['username'])) { echo($error['username']);} ?></span>
					</div>
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(!empty($_POST['email'])) {echo $_POST['email'];} ?>">
						<span class="errorMessage"><?php if(!empty($error['email'])) { echo($error['email']);} ?></span>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Mot de passe">
						<span class="errorMessage"><?php if(!empty($error['password'])) { echo($error['password']);} ?></span>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password_confirm" placeholder="Veuillez confirmer votre mot de passe">
						<span class="errorMessage"><?php if(!empty($error['password_confirm'])) { echo($error['password_confirm']);} ?></span>
					</div>
					<div class="form-group">
						<label><p class="acceptCGU"> <input type="checkbox" name="checkbox" value=""> J'accepte les <u><a href="<?php echo $this->url('cgu'); ?>">CGU</a></u></p></label>
						<span class="errorMessage"><br><?php if(!empty($error['checkbox'])) { echo($error['checkbox']);} ?></span>
					</div>
					<input type="submit" class="btn btn-default">
      </fieldset>
    </form>
  </div>

<?php $this->stop('main_content') ?>
