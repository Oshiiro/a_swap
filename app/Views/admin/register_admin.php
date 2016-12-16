<?php $this->layout('layout', ['title' => 'Contact']) ?>

<?php $this->start('main_content') ?>

	<h2>Creez la page de votre asso</h2>
  <!-- RESTE A PREVOIR/FAIRE : uploader le logo de l'assoc -->
<?php debug($data); ?>

  <div class="container">
    <form class="" action="" method="POST">
      <fieldset>
        <legend>L'association :</legend>
        <!-- partie du formulaire pour la creation de l'asso -->
        <div class="form-group">
          <input type="text" name="nom_assos" placeholder="Nom de l'association" value="<?php if(!empty($_GET['nom_assos'])) { echo $_GET['nom_assos']; } ?>">
        </div>

        <div class="form-group">
          <textarea name="description_assos" placeholder="Descriptif de votre association" rows="8" cols="80"></textarea>
        </div>

        <div class="form-group">
          <input type="text" name="money_name" placeholder="Nom de votre monnaie" value="">
        </div>

        <div class="form-group">
          <textarea name="rules_assos" placeholder="Vous pouvez ici decrire la façon dont est gérée votre monnaie associative" rows="8" cols="80"></textarea>
        </div>
      </fieldset>

      <fieldset>
        <legend>Le tresorier :</legend>
      <!-- formulaire de creation de l'admin -->
    	  <div class="form-group">
    			<!-- Si le champ est remplie aucune données entre en BDD -->
    			<input type="text" name="antiBot" value="" class="hide">

    			<div class="form-group">
    	    	<input type="text" class="form-control" name="firstname" placeholder="Nom">
    			</div>
    			<div class="form-group">
    				<input type="text" class="form-control" name="lastname" placeholder="Prenom">
    			</div>
    			<div class="form-group">
    				<input type="text" class="form-control" name="username" placeholder="Pseudo">
    			</div>
    			<div class="form-group">
    				<input type="email" class="form-control" name="email" placeholder="Adresse mail">
    			</div>
    			<div class="form-group">
    				<input type="password" class="form-control" name="password" placeholder="Mot de passe">
    			</div>
    			<div class="form-group">
    				<input type="password" class="form-control" name="password_confirm" placeholder="Veuillez confirmer votre mot de passe">
    			</div>
    			<div class="form-group">
    				<label><input type="checkbox" value="">J'accepte les <a href="<?php echo $this->url('cgu'); ?>" target="_blank">CGU</a></label>
    			</div>
    		</div>
    	  <button type="submit" class="btn btn-default">Submit</button>
      </fieldset>
    </form>
  </div>

<?php $this->stop('main_content') ?>
