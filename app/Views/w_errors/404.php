<?php $this->layout('layout', ['title' => 'Perdu ?']) ?>

<?php $this->start('main_content'); ?>
<div class="container wError">
  <h1>Error 404</h1>
  <p>Cette page n'existe pas ou n'existe plus.</p>
  <p>Nous vous prions de nous excuser pour la gêne occasionnée.</p>
  <p>Nous vous invitons à revenir à la <a href="<?php echo $this->url('default_home') ?>">page d'accueil</a> de notre site</p>
</div>
<?php $this->stop('main_content'); ?>
