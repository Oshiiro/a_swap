<?php $this->layout('layout', ['title' => 'Nothing to see here']) ?>
<?php $this->start('main_content'); ?>
<style media="screen">
.allContent{top: 0;}
.extension_head{height:0px}
</style>
<div class="container wError">
  <h1>Error 403</h1>
  <p>Vous n'avez pas les droits pour accéder à cette page</p>
  <p>Nous vous invitons à revenir à la <a href="<?php echo $this->url('default_home') ?>">page d'accueil</a> de notre site</p>
</div>
<?php $this->stop('main_content'); ?>
