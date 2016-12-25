<?php $this->layout('layout_admin_back', ['title' => 'Back A-Swap']) ?>

<?php $this->start('main_content') ?>
	<h2>Transaction</h2>

	<!-- <div class="panel panel-default container">
>>>>>>> bc177c2549d661055158f2fecb54f3c0ae9807db
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
	</div> -->

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
					<td> <i class="fa fa-money" aria-hidden="true"> <a href=""></a> </i> </td>
					<td> <a href="<?php echo $this->url('admin_back_delete', array('id' => $adherant['id_users'])) ; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>


				</tr>
			<?php } ?>
			</table>

	</div>
	<div class="container">
		<button id="invitation">Inviter un nouveau membre</button>
		<!-- A FAIRE : animation JS qui affiche le form ci-dessous lorqu'on clique sur le button si dessus -->
		<form class="" action="<?php echo $this->url('admin_association_invite'); ?>" method="POST">
			<input type="text" name="mail_invite" value="" placeholder="Adresse mail de la personne a inviter">
			<input type="submit" value="Inviter"><br>
			<span class="errorMessage"><?php if(!empty($error['email'])) { echo($error['email']);} ?></span>
		</form>
	</div>
	<a href="<?php echo $this->url('admin_back_transac'); ?>">Faire une transaction</a>

<?php $this->stop('main_content') ?>
