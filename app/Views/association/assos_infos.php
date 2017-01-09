<?php $this->layout('layout', ['title' => 'Informations sur l\'association', 'slug' => $slug, 'page' => $page]) ?>

<?php $this->start('main_content') ?>
<button class='btn btn-circle sendMessage btn-lg'><a href="<?php echo $this->url('users_accueil_transac',['slug' => $this->getValueInArray($dataAssos, 'slug')]); ?>" title="Faire une transaction"><i class="fa fa-exchange" aria-hidden="true"></i></a></button>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10 center">
			<h2><?php echo $_SESSION['user']['nom_assos'] ?></h2>
      <div class="center">
        <a href="<?php echo $this->url('association',['slug' => $this->getValueInArray($dataAssos, 'slug'), 'page' => 1]); ?>" title="Transactions"><button type="button" class="btn btn-perso" name="button">Transactions</button></a>
        <a href="<?php echo $this->url('association_infos',['slug' => $this->getValueInArray($dataAssos, 'slug')]); ?>" title="Infos de l'association"><button type="button" class="btn btn-perso2" name="button">Infos</button></a>
        <a href="<?php echo $this->url('association_adherants',['slug' => $this->getValueInArray($dataAssos, 'slug'), 'page' => 1]); ?>" title="Liste des adhérants"><button type="button" class="btn btn-perso" name="button">Adhérants</button></a>
      </div>
      <div class="row">
        <span class="col-md-12 ligneVide"></span>
        <div class="col-md-12">
          <h3 class="center">Description</h3>
        </div>
        <span class="col-md-12 col-xs-12 ligne2"></span>
        <div class="col-md-12">
          <p class="center">Nom de la monnaie : <?php echo $dataAssos['money_name']; ?></p>
          <p class="center"><?php echo $dataAssos['description']; ?></p>
        </div>

        <span class="col-md-12 ligneVide"></span>
        <div class="col-md-12">
          <h3 class="center">Règles</h3>
        </div>

        <span class="col-md-12 ligne2 col-xs-12"></span>
        <div class="col-md-12">
          <p class="center col-md-12"><?php echo $dataAssos['rules']; ?></p>
        </div>

      </div>
		</div>
	</div>
</div>


<?php $this->stop('main_content') ?>
