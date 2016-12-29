<?php $this->layout('layout', ['title' => 'Nothing to see here']) ?>

<?php $this->start('main_content'); ?>
<div class="container wError">
  <h1>Error 403</h1>
  <p>Vous n'avez pas les droits pour accédé à cette page</p>
  <p>Nous vous invitons à revenir à la <a href="<?php echo $this->url('default_home') ?>">page d'accueil</a> de notre site</p>
</div>
<?php $this->stop('main_content'); ?>
