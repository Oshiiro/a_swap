<?php $this->layout('layout_admin_back', ['title' => 'Modif Assos', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>

<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
      <form class="formulaire" action="<?php echo $this->url('admin_association_update_action', ['slug' => $slug]) ?>" method="POST">
        <fieldset>
        <legend><h2>Editer Votre Association</h2></legend>

          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="" value="<?php if(!empty($_POST['name'])) {echo $_POST['name'];}else{echo $_SESSION['user']['nom_assos'];} ?>">
            <span class="errorMessage"><?php if(!empty($error['name'])) { echo($error['name']);} ?></span>
          </div>

          <div class="form-group">
            <textarea name="description"  class="form-control" placeholder="Descriptif de votre association (facultatif)"><?php if (!empty($association['description'])) { echo $association['description'];} elseif (!empty($_POST['description'])) { echo $_POST['description']; } ?></textarea>

          </div>

          <div class="form-group">
            <input type="text" name="money_name" class="form-control" placeholder="Nom de votre monnaie" value="<?php if (!empty($association['money_name'])) { echo $association['money_name'];} elseif (!empty($_POST['money_name'])) { echo $_POST['money_name']; } ?>">
            <span class="errorMessage"><?php if(!empty($error['money_name'])) { echo($error['money_name']);} ?></span>
          </div>

          <div class="form-group">
            <textarea name="rules" class="form-control" placeholder="Vous pouvez ici decrire la façon dont est gérée votre monnaie associative (facultatif)"><?php if (!empty($association['rules'])) { echo $association['rules'];} elseif (!empty($_POST['rules'])) { echo $_POST['rules']; } ?></textarea>

          </div>

          <input type="submit" class="btn btn-default">

        </fieldset>
      </form>
    </div>
  </div>
</div>


<?php $this->stop('main_content') ?>
