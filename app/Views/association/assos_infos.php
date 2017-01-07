<?php $this->layout('layout', ['title' => 'Association', 'slug' => $slug, 'page' => $page]) ?>

<?php $this->start('main_content') ?>
<button class='btn btn-primary btn-circle sendMessage btn-lg'><a href="<?php echo $this->url('users_accueil_transac',['slug' => $this->getValueInArray($dataAssos, 'slug')]); ?>" title="Faire une transaction"><i class="fa fa-exchange" aria-hidden="true"></i></a></button>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
			<h2><?php echo $_SESSION['user']['nom_assos'] ?></h2>

      <a href="<?php echo $this->url('association',['slug' => $this->getValueInArray($dataAssos, 'slug'), 'page' => 1]); ?>" title="Transactions"><button type="button" class="btn btn-perso" name="button">Transactions</button></a>
      <a href="<?php echo $this->url('association_infos',['slug' => $this->getValueInArray($dataAssos, 'slug')]); ?>" title="Infos de l'association"><button type="button" class="btn btn-perso" name="button">Infos</button></a>
      <a href="<?php echo $this->url('association_adherants',['slug' => $this->getValueInArray($dataAssos, 'slug'), 'page' => 1]); ?>" title="Liste des adhérants"><button type="button" class="btn btn-perso" name="button">Adhérants</button></a>

      <div class="table-responsive shadow-z-1">
        <h3>Infos Associations</h3>
          <table id="table" class="table table-hover">
            <thead>
              <tr>
                <th>Nom de l'association</th>
                <th>Nom de la monnaie</th>
                <th>Description</th>
                <th>Règles</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $dataAssos['name']; ?></td>
                <td><?php echo $dataAssos['money_name']; ?></td>
                <td><?php echo $dataAssos['description']; ?></td>
                <td><?php echo $dataAssos['rules']; ?></td>
              </tr>
            </tbody>
        </table>
      </div>
		</div>
	</div>
</div>


<?php $this->stop('main_content') ?>
