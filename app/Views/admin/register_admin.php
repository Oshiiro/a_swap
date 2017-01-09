<?php $this->layout('layout', ['title' => 'Créez votre association']) ?>

<?php $this->start('main_content') ?>
  <!-- RESTE A PREVOIR/FAIRE : uploader le logo de l'assoc -->
  <div class="container block-message">
    <div class="row">
					<div class="block col-xs-9 col-xs-push-2 col-md-push-1 col-lg-10">
            <form class="" action="" method="POST">
                  <!-- partie du formulaire pour la creation de l'asso -->
						<h2>Créez la page de votre assos'</h2>
						<h3>L'association :</h3>
			      <div class="field">
              <label for="nom_assos"class="field-label">Nom de l'association</label>
			        <input type="text" name="nom_assos" class="field-input" value="<?php if(!empty($_GET['nom_assos'])) { echo $_GET['nom_assos']; } elseif(!empty($_POST['nom_assos'])) { echo $_POST['nom_assos']; } ?>">
							<span class="errorMessage"><?php if(!empty($error['name_asso'])) { echo($error['name_asso']);} ?></span>
						</div>

		        <div class="textfield field" style="margin-bottom: 60px;">
							<label for="description_assos" class="field-label">Descriptif de votre association (facultatif)</label>
		          <textarea name="description_assos"  class="field-input"><?php if(!empty($_POST['description_assos'])) { echo $_POST['description_assos']; } ?></textarea>
							<span class="errorMessage"><?php if(!empty($error['description_assos'])) { echo($error['description_assos']);} ?></span>
					  </div>

		        <div class="field">
              <label for="money_name" class="field-label">Nom de votre monnaie</label>
		          <input type="text" name="money_name" class="field-input" value="<?php if(!empty($_POST['money_name'])) { echo $_POST['money_name']; } ?>">
							<span class="errorMessage"><?php if(!empty($error['money_name'])) { echo($error['money_name']);} ?></span>
					  </div>

		        <div class="textfield field" style="margin-bottom: 60px;">
              <label for="rules_assos" class="field-label">Vous pouvez ici decrire la façon dont est gérée votre monnaie associative</label>
		          <textarea name="rules_assos" class="field-input"><?php if(!empty($_POST['rules_assos'])) { echo $_POST['rules_assos']; } ?></textarea>
							<span class="errorMessage"><?php if(!empty($error['rules_assos'])) { echo($error['rules_assos']);} ?></span>
					  </div>
			<br><br><br><br>
        <h3>Le tresorier :</h3>
      <!-- formulaire de creation de l'admin -->
      	  <div class="">
      			<!-- Si le champ est remplie aucune données entre en BDD -->
      			<input type="text" name="antiBot" value="" class="hide">
  					<div class="field">
              <label for="lastname" class="field-label">Nom</label>
  						<input type="text" class="field-input" name="lastname" value="<?php if(!empty($_POST['lastname'])) {echo $_POST['lastname'];} ?>">
  						<span class="errorMessage"><?php if(!empty($error['lastname'])) { echo($error['lastname']);} ?></span>
  					</div>
  					<div class="field">
              <label for="firstname" class="field-label">Prenom</label>
  			    	<input type="text" class="field-input" name="firstname" value="<?php if(!empty($_POST['firstname'])) {echo $_POST['firstname'];} ?>">
  						<span class="errorMessage"><?php if(!empty($error['firstname'])) { echo($error['firstname']);} ?></span>
  					</div>
  					<div class="field">
              <label for="username" class="field-label">Pseudo</label>
  						<input type="text" class="field-input" name="username" value="<?php if(!empty($_POST['username'])) {echo $_POST['username'];} ?>">
  						<span class="errorMessage"><?php if(!empty($error['username'])) { echo($error['username']);} ?></span>
  					</div>
  					<div class="field">
              <label for="email" class="field-label">E-mail</label>
  						<input type="email" class="field-input" name="email" value="<?php if(!empty($_POST['email'])) {echo $_POST['email'];} ?>">
  						<span class="errorMessage"><?php if(!empty($error['email'])) { echo($error['email']);} ?></span>
  					</div>
  					<div class="field">
              <label for="password" class="field-label">Mot de passe</label>
  						<input type="password" class="field-input" name="password">
  						<span class="errorMessage"><?php if(!empty($error['password'])) { echo($error['password']);} ?></span>
  					</div>
  					<div class="field">
              <label for="password_confirm" class="field-label">Veuillez confirmer votre mot de passe</label>
  						<input type="password" class="field-input" name="password_confirm">
  						<span class="errorMessage"><?php if(!empty($error['password_confirm'])) { echo($error['password_confirm']);} ?></span>
  					</div>
  					<div class="form-group center">
  						<label><p class="acceptCGU"> <input type="checkbox" name="checkbox" value=""> J'accepte les <u><a href="<?php echo $this->url('cgu'); ?>">CGU</a></u></p></label>
  						<span class="errorMessage"><br><?php if(!empty($error['checkbox'])) { echo($error['checkbox']);} ?></span>
  					</div>
            <div class="center">
              <button class="btn btn-circle btn-lg validform" type="submit" name="submit" value=""><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
            </div>
        </form>
      </div>
  	</div>
  </div>
</div>

<?php $this->stop('main_content') ?>
