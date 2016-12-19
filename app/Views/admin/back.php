<?php $this->layout('layout', ['title' => 'Back']) ?>

<?php $this->start('main_content') ?>
	<h2>Back</h2>
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
					<td><?php echo $tran['id_assos']; ?></td>
				</tr>
			<?php } ?>
			</table>

	</div>
	<div class="container">
		<button id="invitation">Inviter un nouveau membre</button>
		<!-- A FAIRE : animation JS qui affiche le from ci-dessous lorqu'on clique sur le button si dessus -->
		<form class="" action="" method="POST">
			<input type="text" name="mail_invite" value="" placeholder="Adresse mail de la personne a inviter">
			<input type="submit" name="submit" value="Inviter">
		</form>
	</div>


<?php $this->stop('main_content') ?>
