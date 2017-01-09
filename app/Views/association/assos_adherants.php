<?php $this->layout('layout', ['title' => 'Liste des adhérants', 'slug' => $slug, 'page' => $page]) ?>

<?php $this->start('main_content') ?>
<button class='btn btn-circle sendMessage btn-lg'><a href="<?php echo $this->url('users_accueil_transac',['slug' => $this->getValueInArray($dataAssos, 'slug')]); ?>" title="Faire une transaction"><i class="fa fa-exchange" aria-hidden="true"></i></a></button>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
			<h2><?php echo $_SESSION['user']['nom_assos'] ?></h2>
      <div class="center">
        <a href="<?php echo $this->url('association',['slug' => $this->getValueInArray($dataAssos, 'slug'), 'page' => 1]); ?>" title="Transactions"><button type="button" class="btn btn-perso" name="button">Transactions</button></a>
        <a href="<?php echo $this->url('association_infos',['slug' => $this->getValueInArray($dataAssos, 'slug')]); ?>" title="Infos de l'association"><button type="button" class="btn btn-perso" name="button">Infos</button></a>
        <a href="<?php echo $this->url('association_adherants',['slug' => $this->getValueInArray($dataAssos, 'slug'), 'page' => 1]); ?>" title="Liste des adhérants"><button type="button" class="btn btn-perso2" name="button">Adhérants</button></a>
      </div>
			<!-- ////////////////////// LISTE DES ADHERANTS /////////////////////////////-->

      <div class="table-responsive shadow-z-1">
        <table id="table" class="table table-hover" >
          <thead>
  					<tr>
  						<th>Nom</th>
  						<th>Prénom</th>
  						<th>Pseudo</th>
  						<th>Adresse e-mail</th>
  						<th>Portefeuille</th>
  					</tr>
          </thead>
          <tbody>
  					<?php foreach ($adherants as $adherant){ ?>
  					<tr>
  						<td><?php echo $adherant['lastname']; ?></td>
  						<td><?php echo $adherant['firstname']; ?></td>
  						<td><?php echo $adherant['username']; ?></td>
  						<td><?php echo $adherant['email']; ?></td>
  						<td><?php echo $adherant['wallet']; ?></td>
  					</tr>
  				  <?php } ?>
          </tbody>
				</table>
        <?php if(!empty($pagination_adh)) { echo $pagination_adh;} ?>
			</div>
		</div>
	</div>
</div>


<?php $this->stop('main_content') ?>
