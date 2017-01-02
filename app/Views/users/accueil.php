<?php $this->layout('layout', ['title' => 'Users']) ?>

<?php $this->start('main_content') ?>

<button><a href="<?php echo $this->url('users_accueil_transac') ?>">Faire une transaction</a></button>
	<div class="panel panel-default container">
		<div class="panel-heading">Transaction</div>
		  <table class="col-md-offset-1 col-md-9">
				<tr>
					<th>Buyer</th>
					<th>Seller</th>
					<th>Sum</th>
					<th>Description</th>
					<th>Created_at</th>
				</tr>
				<?php foreach ($trans as $tran){ ?>
				<tr>
					<td><?php echo $tran['username']; ?></td>
					<td><?php echo $tran['username']; ?></td>
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
		  <table class="col-md-offset-1 col-md-9">
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



<?php $this->stop('main_content') ?>
