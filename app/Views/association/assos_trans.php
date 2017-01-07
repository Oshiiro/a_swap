<?php $this->layout('layout', ['title' => 'Association', 'slug' => $slug, 'page' => $page]) ?>

<?php $this->start('main_content') ?>
<a href="<?php echo $this->url('users_accueil_transac',['slug' => $this->getValueInArray($dataAssos, 'slug')]); ?>" title="Faire une transaction"><button class='btn btn-primary btn-circle sendMessage btn-lg'><i class="fa fa-exchange" aria-hidden="true"></i></button></a>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
			<h2><?php echo $_SESSION['user']['nom_assos'] ?></h2>

      <a href="<?php echo $this->url('association',['slug' => $this->getValueInArray($dataAssos, 'slug'), 'page' => 1]); ?>" title="Transactions"><button type="button" class="btn btn-perso" name="button">Transactions</button></a>
      <a href="<?php echo $this->url('association_infos',['slug' => $this->getValueInArray($dataAssos, 'slug')]); ?>" title="Infos de l'association"><button type="button" class="btn btn-perso" name="button">Infos</button></a>
      <a href="<?php echo $this->url('association_adherants',['slug' => $this->getValueInArray($dataAssos, 'slug'), 'page' => 1]); ?>" title="Liste des adhérants"><button type="button" class="btn btn-perso" name="button">Adhérants</button></a>


      <div class="table-responsive shadow-z-1">
				<h3>Vos transactions</h3>
        <table id="table" class="table table-hover" >
          <thead>
						<tr>
							<th>De </th>
							<th>Vers </th>
							<th>Somme</th>
							<th>Description</th>
							<th>Date de la transaction</th>
						</tr>
          </thead>
          <tbody>
						<?php foreach ($trans as $tran){ ?>
						<tr>
							<td><?php echo $tran['username_buyer']; ?></td>
							<td><?php echo $tran['username_seller']; ?></td>
							<td><?php echo $tran['sum']; ?></td>
							<td><?php echo $tran['description']; ?></td>
							<td><?php echo $tran['created_at']; ?></td>
						</tr>
          </tbody>
					<?php } ?>
				</table>
			</div>
      <?php if(!empty($pagination_trans)) { echo $pagination_trans;} ?>
		</div>
	</div>
</div>


<?php $this->stop('main_content') ?>
