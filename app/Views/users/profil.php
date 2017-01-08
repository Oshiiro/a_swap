<?php $this->layout('layout', ['title' => 'Profil', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-10 col-xs-push-1 col-lg-10">
      <form method="POST" action="<?php echo $this->url('update_profil') ?>" enctype="multipart/form-data">
        <legend><h2>Profil</h2></legend>

        <div class="col-md-3">
          <img class ="img-circle img-profil" src="<?php echo $this->assetUrl($avatar) ?>" alt=""><br>
        </div>

        <div class="col-md-9">
          <div class="form-group">
            <label for="photodeprofil">Photo de Profil</label>
            <input type="file" name="foo">
            <span class="errorMessage"><?php if(!empty($error['img'])) { echo($error['img']);} ?></span>
          </div>
          <div class="form-group field">
            <label for="firstname" class="field-label">Prénom</label>
            <input type="text" class="field-input" name="firstname" value="<?php if(!empty($_POST['firstname'])) {echo $_POST['firstname'];}else{echo $_SESSION['user']['firstname'];} ?>">
            <span class="errorMessage"><?php if(!empty($error['firstname'])) { echo($error['firstname']);} ?></span>
          </div>
          <div class="form-group field">
            <label for="lastname" class="field-label">Nom</label>
            <input type="text" class="field-input" name="lastname" value="<?php if(!empty($_POST['lastname'])) {echo $_POST['lastname'];}else{echo $_SESSION['user']['lastname'];} ?>">
            <span class="errorMessage"><?php if(!empty($error['lastname'])) { echo($error['lastname']);} ?></span>
          </div>
          <div class="field">
            <label for="lastname" class="field-label">Pseudo</label>
            <input type="text" class="field-input" name="username" value="<?php if(!empty($_POST['username'])) {echo $_POST['username'];}else{echo $_SESSION['user']['username'];} ?>">
            <span class="errorMessage"><?php if(!empty($error['username'])) { echo($error['username']);} ?></span>
          </div>
          <br>
        </div>

        <div class="center">
          <input type="submit" value="Valider" class="btn btn-default">
        </div>
      </form>
    </div>
  </div>
</div>
<?php $this->stop('main_content') ?>
