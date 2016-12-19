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
<?php $this->stop('main_content') ?>
