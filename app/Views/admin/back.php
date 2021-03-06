<?php $this->layout('layout_admin_back', ['title' => 'Transactions', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
			<h2>Les dernières transactions.</h2>
      <div class="table-responsive shadow-z-1">
        <table id="table" class="table table-hover" >
          <thead>
  					<tr>
              <th>De</th>
  						<th>Vers </th>
  						<th>Somme</th>
  						<th>Description</th>
  						<th>Date de la transaction</th>
  					</tr>
  					<?php foreach ($trans as $tran){ ?>
          </thead>
          <tbody>
  					<tr>
              <td><?php echo $tran['username_buyer']; ?></td>
              <td><?php echo $tran['username_seller']; ?></td>
  						<td><?php echo $tran['sum']; ?></td>
  						<td><?php echo $tran['description']; ?></td>
  						<td><?php echo $tran['created_at']; ?></td>
  					</tr>
  				 <?php } ?>
         </tbody>
				</table>
        <?php if(!empty($pagination)){
          echo $pagination;
        } ?>
		  </div>
	  </div>
  </div>
</div>




<?php $this->stop('main_content') ?>
