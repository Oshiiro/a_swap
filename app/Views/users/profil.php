<?php $this->layout('layout', ['title' => 'Profil']) ?>

<?php $this->start('main_content') ?>

<?php debug($error); ?>

<div class="container">
  <div class="row">
    <form method="POST" action="<?php echo $this->url('update_profil') ?>" class="form-horizontal well formulaire">
      <fieldset>
        <legend><h2>Profil</h2></legend>

        <div class="col-md-3">
          <img src="<?= $this->assetUrl('img/imgprofiltest.jpg') ?>" alt=""><br>
        </div>

        <div class="col-md-9">
          <div class="form-group">
            <label for="photodeprofil">Photo de Profil</label>
            <input type="file" id="photodeprofil">
          </div>
          <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" class="form-control" name="firstname" placeholder="Nom" value="<?php if(!empty($_POST['firstname'])) {echo $_POST['firstname'];}else{echo $_SESSION['user']['firstname'];} ?>">
            <span class="errorMessage"><?php if(!empty($error['firstname'])) { echo($error['firstname']);} ?></span>
          </div>
          <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" class="form-control" name="lastname" placeholder="Prenom" value="<?php if(!empty($_POST['lastname'])) {echo $_POST['lastname'];}else{echo $_SESSION['user']['lastname'];} ?>">
            <span class="errorMessage"><?php if(!empty($error['lastname'])) { echo($error['lastname']);} ?></span>
          </div>
          <div class="form-group">
            <label for="lastname">Pseudo</label>
            <input type="text" class="form-control" name="username" placeholder="Pseudo" value="<?php if(!empty($_POST['username'])) {echo $_POST['username'];}else{echo $_SESSION['user']['username'];} ?>">
            <span class="errorMessage"><?php if(!empty($error['username'])) { echo($error['username']);} ?></span>
          </div>
          <br>
        </div>

        <div class="center">
          <input type="submit" value="Valider" class="btn btn-default">
        </div>

      </fieldset>
    </form>
  </div>
</div>

<?php $this->stop('main_content') ?>