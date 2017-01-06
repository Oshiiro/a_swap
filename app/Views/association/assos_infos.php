<?php $this->layout('layout', ['title' => 'Association', 'slug' => $slug, 'page' => $page]) ?>

<?php $this->start('main_content') ?>
<button class='btn btn-primary btn-circle sendMessage btn-lg'><a href="<?php echo $this->url('users_accueil_transac',['slug' => $this->getValueInArray($dataAssos, 'slug')]); ?>" title="Faire une transaction"><i class="fa fa-exchange" aria-hidden="true"></i></a></button>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
			<h2><?php echo $_SESSION['user']['nom_assos'] ?></h2>

      <button type="button" class="btn btn-default" name="button"><a href="<?php echo $this->url('association',['slug' => $this->getValueInArray($dataAssos, 'slug'), 'page' => 1]); ?>" title="Transactions">Transactions</a></button>
      <button type="button" class="btn btn-default" name="button"><a href="<?php echo $this->url('association_infos',['slug' => $this->getValueInArray($dataAssos, 'slug')]); ?>" title="Infos de l'association">Infos<a/></button>
      <button type="button" class="btn btn-default" name="button"><a href="<?php echo $this->url('association_adherants',['slug' => $this->getValueInArray($dataAssos, 'slug'), 'page' => 1]); ?>" title="Liste des adhérants">Adhérants</a></button>

      <div class="panel panel-default container">
        <div class="panel-heading">Infos Associations</div>
          <div class="col-xs-10">
            <h4>Nom de l'association</h4>
            <p><?php echo $dataAssos['name']; ?></p>
            <h4>Nom de la monnaie</h4>
            <p><?php echo $dataAssos['money_name']; ?></p>
            <h4>Description</h4>
            <p><?php echo $dataAssos['description']; ?></p>
            <h4>Règles</h4>
            <p><?php echo $dataAssos['rules']; ?></p>
        </div>
      </div>


		</div>
	</div>
</div>


<?php $this->stop('main_content') ?>