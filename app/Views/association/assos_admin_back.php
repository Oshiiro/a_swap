<?php $this->layout('layout_admin_back', ['title' => 'Admin Association', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
      <h2>Gestion association</h2>
<!-- ////////////////////// LISTE DES ADHERANTS /////////////////////////////-->
<button title="Envoyer une invitation"  class="btn btn-default sendMessage" >Inviter un nouveau membre</button>
<!-- A FAIRE :  JS qui affiche le form ci-dessous lorqu'on clique sur le button si dessus -->
<!-- NE FONCTIONNE PAS  -->
<form class="formulaire" style="display : none;" action="<?php echo $this->url('admin_association_invite'); ?>"  method="POST">
  <input type="email" name="mail_invite" value="" placeholder="Adresse mail de la personne a inviter">
  <input type="submit" value="Inviter">
</form>
			<div class="container">
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
								<td><a href="<?php echo $this->url('admin_back_credite', array('id' => $adherant['id_users'])) ?>" title="Créditer le portefeuille"><i class="fa fa-money fa-2x" aria-hidden="true"> </i></a></td>
								<td><a href="<?php echo $this->url('admin_back_delete', array('id' => $adherant['id_users'])) ; ?>" title="Exclure ce membre"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a></td>
							</tr>
						<?php } ?>
						</table>
            <div class="pagination" >  <?php if(!empty($pagination)){
              echo $pagination;
            } ?></div>
			</div>

		</div>
	</div>
</div>




<script type="text/javascript" src="<?= $this->assetUrl('js/jquery-3.1.0.min.js') ?>"></script>
<script type="text/javascript" src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?= $this->assetUrl('js/app.js') ?>"></script>
<?php $this->stop('main_content') ?>
