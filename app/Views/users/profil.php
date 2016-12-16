<?php $this->layout('layout', ['title' => 'Profil']) ?>

<?php $this->start('main_content') ?>

<div class="container">
	<div class="row">
    <form method="POST" action="<?php echo $this->url('try_login') ?>" class="form-horizontal well formulaire">
			<fieldset>
				<legend><h2>Profil</h2></legend>
        <img src="<?= $this->assetUrl('img/imgprofiltest.jpg') ?>" alt="">
      </fieldset>
    </form>
  </div>
</div>

<?php $this->stop('main_content') ?>
