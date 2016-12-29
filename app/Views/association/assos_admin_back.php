<?php $this->layout('layout_admin_back', ['title' => 'Admin Association']) ?>

<?php $this->start('main_content') ?>

<h2>Gestion association</h2>

<!-- ////////////////////// LISTE DES ADHERANTS /////////////////////////////-->

<div class="container">
	<button class='btn btn-default'><a href=1"<?php echo $this->url('admin_back_transac'); ?>">Faire une transaction</a></button>
	<button class='btn btn-default'><a href="<?php echo $this->url('admin_back_credite'); ?>">Crediter un membre</a></button>
	<button id="invitation" class="btn btn-default invitation" >Inviter un nouveau membre</button>

<!-- A FAIRE :  JS qui affiche le form ci-dessous lorqu'on clique sur le button si dessus -->
<!-- NE FONCTIONNE PAS  -->
		<form class="formInvit" action="<?php echo $this->url('admin_association_invite'); ?>" method="POST">
			<input type="text" name="mail_invite" value="" placeholder="Adresse mail de la personne a inviter">
			<input type="submit" value="Inviter">
		</form>
		<br><br><br>


		  <table class="col-md-12">
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
					<td><a href="<?php echo $this->url('admin_back_transac') ?>"> <i class="fa fa-exchange fa-2x" aria-hidden="true"></i></a>  </td>
					<td><a href="<?php echo $this->url('admin_back_credite') ?>"><i class="fa fa-money fa-2x" aria-hidden="true"> </i></a> </td>
					<td><a href="<?php echo $this->url('admin_back_delete', array('id' => $adherant['id_users'])) ; ?>"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a></td>
				</tr>
			<?php } ?>
			</table>

</div>




<?php $this->stop('main_content') ?>
