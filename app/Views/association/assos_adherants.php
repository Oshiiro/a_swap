<?php $this->layout('layout', ['title' => 'Association', 'slug' => $slug, 'page' => $page]) ?>

<?php $this->start('main_content') ?>
<button class='btn btn-primary btn-circle sendMessage btn-lg'><a href="<?php echo $this->url('users_accueil_transac',['slug' => $this->e($slug)]); ?>" title="Faire une transaction"><i class="fa fa-exchange" aria-hidden="true"></i></a></button>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
			<h2><?php echo $_SESSION['user']['nom_assos'] ?></h2>

      <button type="button" class="btn btn-default" name="button"><a href="<?php echo $this->url('association',['slug' => $this->e($slug), 'page' => 1]); ?>" title="Transactions">Transactions</a></button>
      <button type="button" class="btn btn-default" name="button"><a href="<?php echo $this->url('association_infos',['slug' => $this->e($slug)]); ?>" title="Infos de l'association">Infos<a/></button>
      <button type="button" class="btn btn-default" name="button"><a href="<?php echo $this->url('association_adherants',['slug' => $this->e($slug), 'page' => 1]); ?>" title="Liste des adhérants">Adhérants</a></button>


			<!-- ////////////////////// LISTE DES ADHERANTS /////////////////////////////-->

			<div class="panel panel-default container">
				<div class="panel-heading">Liste des adhérents</div>
			  <table>
					<tr>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Pseudo</th>
						<th>Adresse-mail</th>
						<th>Portefeuille</th>
					</tr>

					<?php foreach ($adherants as $adherant){ ?>
					<tr>
						<td><?php echo $adherant['lastname']; ?></td>
						<td><?php echo $adherant['firstname']; ?></td>
						<td><?php echo $adherant['username']; ?></td>
						<td><?php echo $adherant['email']; ?></td>
						<td><?php echo $adherant['wallet']; ?></td>
					</tr>
				<?php } ?>
				</table>
        <?php if(!empty($pagination_adh)) { echo $pagination_adh;} ?>
			</div>
		</div>
	</div>
</div>


<?php $this->stop('main_content') ?>
