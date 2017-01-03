<?php $this->layout('layout', ['title' => 'Association']) ?>

<?php $this->start('main_content') ?>
<button class='btn-primary btn-circle btn-lg sendMessage' style="text-align : center,"><a href="<?php echo $this->url('admin_back_transac'); ?>" title="Faire une transaction"><i class="fa fa-exchange" aria-hidden="true" style="color : white"></i></a></button>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
				<h2>Votre association</h2>


				<div class="panel panel-default container">
					<div class="panel-heading">Vos transactions</div>
					  <table>
							<tr>
								<th>Acheteur</th>
								<th>Vendeur</th>
								<th>Somme</th>
								<th>Description</th>
								<th>Date de la transaction</th>
							</tr>
							<?php foreach ($trans as $tran){ ?>
							<tr>
								<td><?php echo $tran['username_buyer']; ?></td>
								<td><?php echo $tran['username_seller']; ?></td>
								<td><?php echo $tran['sum']; ?></td>
								<td><?php echo $tran['description']; ?></td>
								<td><?php echo $tran['created_at']; ?></td>
							</tr>
						<?php } ?>
						</table>
				</div>


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
					</div>
		</div>
	</div>
</div>


<?php $this->stop('main_content') ?>
