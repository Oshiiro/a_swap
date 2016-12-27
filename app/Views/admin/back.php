<?php $this->layout('layout_admin_back', ['title' => 'Back A-Swap']) ?>

<?php $this->start('main_content') ?>
	<h2>Transaction</h2>
	<h3 style="text-align : center">Liste des dernières transaction au sein de votre association.</h3>
	<br>


	  <table class="col-md-offset-2 col-md-8">
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
				<td><?php echo $tran['id_user_seller']; ?></td>
				<td><?php echo $tran['sum']; ?></td>
				<td><?php echo $tran['description']; ?></td>
				<td><?php echo $tran['created_at']; ?></td>

			</tr>
		<?php } ?>
		</table>
	</div>
	<!-- <div class="container"> -->
		<!-- <button id="invitation">Inviter un nouveau membre</button> -->
		<!-- A FAIRE : animation JS qui affiche le form ci-dessous lorqu'on clique sur le button si dessus -->
		<!-- <form class="" action="<?php echo $this->url('admin_association_invite'); ?>" method="POST">
			<input type="text" name="mail_invite" value="" placeholder="Adresse mail de la personne a inviter">
			<input type="submit" value="Inviter"><br>
			<span class="errorMessage"><?php if(!empty($error['email'])) { echo($error['email']);} ?></span>
		</form>
	</div>
	<a href="<?php echo $this->url('admin_back_transac'); ?>">Faire une transaction</a> -->


<?php $this->stop('main_content') ?>
