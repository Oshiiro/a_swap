<?php $this->layout('layout_admin_back', ['title' => 'Modif Assos', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>

<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
      <form class="formulaire" action="<?php echo $this->url('admin_association_update_action') ?>" method="POST">
        <h2>Editer votre Association</h2>

          <div class="field">
            <label for="name" class="field-label">Nom de l'association</label>
            <input type="text" name="name" class="field-input" value="<?php if(!empty($_POST['name'])) {echo $_POST['name'];}else{echo $dataAssos['name'];} ?>">
            <span class="errorMessage"><?php if(!empty($error['name'])) { echo($error['name']);} ?></span>
          </div>

          <div class="field textfield" style="margin-bottom: 60px;">
            <label for="" class="field-label">Descriptif de votre association (facultatif)</label>
            <textarea name="description"  class="field-input"><?php if (!empty($association['description'])) { echo $association['description'];} elseif (!empty($_POST['description'])) { echo $_POST['description']; } ?></textarea>
          </div>

          <div class="field">
            <label for="money_name" class="field-label">Nom de votre monnaie</label>
            <input type="text" name="money_name" class="field-input" value="<?php if (!empty($association['money_name'])) { echo $association['money_name'];} elseif (!empty($_POST['money_name'])) { echo $_POST['money_name']; } ?>">
            <span class="errorMessage"><?php if(!empty($error['money_name'])) { echo($error['money_name']);} ?></span>
          </div>

          <div class="field textfield" style="margin-bottom: 60px;">
            <label for="" class="field-label">Vous pouvez ici decrire la façon dont est gérée votre monnaie associative (facultatif)</label>
            <textarea name="rules" class="field-input"><?php if (!empty($association['rules'])) { echo $association['rules'];} elseif (!empty($_POST['rules'])) { echo $_POST['rules']; } ?></textarea>
          </div>

          <div class="center">
            <button class="btn btn-circle btn-lg validform" type="submit" name="submit" value=""><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
          </div>

      </form>
    </div>
  </div>
</div>


<?php $this->stop('main_content') ?>
