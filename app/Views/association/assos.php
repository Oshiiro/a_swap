<?php $this->layout('layout', ['title' => 'Association', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>
<button class='btn btn-primary btn-circle sendMessage btn-lg'><a href="<?php echo $this->url('users_accueil_transac',['slug' => $this->e($slug)]); ?>" title="Faire une transaction"><i class="fa fa-exchange" aria-hidden="true"></i></a></button>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
			<h2><?php echo $_SESSION['user']['nom_assos'] ?></h2>
<?php debug($dataAssos);?>
      <div class="panel panel-default container">
        <div class="panel-heading">Infos Associations</div>
          <table class="col-xs-10">
            <tr>
              <th>Acheteur</th>
              <th>Vendeur</th>
              <th>Somme</th>
              <th>Description</th>

            </tr>

            <tr>
              <td><?php echo $dataAssos['name']; ?></td>
              <td><?php echo $dataAssos['money_name']; ?></td>
              <td><?php echo $dataAssos['description']; ?></td>
              <td><?php echo $dataAssos['rules']; ?></td>

            </tr>

          </table>
      </div>

			<div class="panel panel-default container">
				<div class="panel-heading">Vos transactions</div>
				  <table class="col-xs-10">
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
        <?php if(!empty($pagination_trans)) { echo $pagination_trans;} ?>
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
