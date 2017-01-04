<?php $this->layout('layout_admin_back', ['title' => 'Modif Assos', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>

<h2>Editer Votre Association</h2>
<div class="container">
  <form class="formulaire" action="<?php echo $this->url('admin_association_update_action') ?>" method="POST">
    <fieldset>
      <legend><h2>L'association :</h2></legend>

          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="" value="<?php echo $association['name']; ?>">
            <span class="errorMessage"><?php if(!empty($error['name'])) { echo($error['name']);} ?></span>
          </div>

          <div class="form-group">
            <textarea name="description"  class="form-control" placeholder="Descriptif de votre association (facultatif)"><?php echo $association['description'];  if(!empty($_POST['description'])) { echo $_POST['description']; } ?></textarea>
            <span class="errorMessage"><?php if(!empty($error['description'])) { echo($error['description']);} ?></span>
          </div>

          <div class="form-group">
            <input type="text" name="money_name" class="form-control" placeholder="Nom de votre monnaie" value="<?php echo $association['money_name']; if(!empty($_POST['money_name'])) { echo $_POST['money_name']; } ?>">
            <span class="errorMessage"><?php if(!empty($error['money_name'])) { echo($error['money_name']);} ?></span>
          </div>

          <div class="form-group">
            <textarea name="rules" class="form-control" placeholder="Vous pouvez ici decrire la façon dont est gérée votre monnaie associative (facultatif)"><?php echo $association['rules']; if(!empty($_POST['rules'])) { echo $_POST['rules']; } ?></textarea>
            <span class="errorMessage"><?php if(!empty($error['rules'])) { echo($error['rules']);} ?></span>
          </div>
            <input type="submit" class="btn btn-default">
        </div>
    </fieldset>



<?php $this->stop('main_content') ?>
