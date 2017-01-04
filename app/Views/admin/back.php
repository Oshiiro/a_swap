<?php $this->layout('layout_admin_back', ['title' => 'Back A-Swap', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>
	<h2>Transaction</h2>
	<h3 style="text-align : center">Liste des dernières transaction au sein de votre association.</h3>
	<br>


	  <table class="col-md-offset-2 col-md-8">
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


<?php $this->stop('main_content') ?>
