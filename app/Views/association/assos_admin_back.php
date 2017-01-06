<?php $this->layout('layout_admin_back', ['title' => 'Admin Association', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
      <h2>Gestion association</h2>
      <button title="Envoyer une invitation"  class="btn btn-default sendMessage" type="button">Inviter un nouveau membre</button>
      <div class="formulaire" style="display : none;">
        <form class="field" action="<?php echo $this->url('admin_association_invite'); ?>"  method="POST" action="" name="mail_invite">
          <label class="field-label" for="email">Adresse mail de la personne a inviter</label>
          <input class="field-input" type="email" name="mail_invite"><br>
          <input type="submit" value="Inviter">
        </form>
      </div>
			<div class="">
					<br><br><br>

          <?php   echo $pagination_adh; ?>
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
								<td><a href="<?php echo $this->url('admin_back_credite', array('id' => $adherant['id_users'], 'slug' => $slug)) ?>"  title="Créditer le portefeuille"><i class="fa fa-money fa-2x" aria-hidden="true"> </i></a></td>
								<td><a onclick="return confirm('Etes-vous sûr de vouloir le supprimer?')" href="<?php echo $this->url('admin_back_delete', array('id' => $adherant['id_users'])) ; ?>" title="Exclure ce membre"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a></td>
							</tr>
						<?php } ?>
						</table>


			</div>

		</div>
	</div>
</div>

<?php $this->stop('main_content') ?>
