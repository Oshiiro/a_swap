<?php $this->layout('layout_admin_back', ['title' => 'Admin Association', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>
<button title="Envoyer une invitation"  class="btn btn-primary btn-circle sendMessage btn-lg" type="button"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i></button>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
      <h2>Gestion association</h2>
      <div class="formulaire" style="display : none;">
        <form class="field" action="<?php echo $this->url('admin_association_invite'); ?>"  method="POST" action="" name="mail_invite">
          <label class="field-label" for="email">Adresse mail de la personne a inviter</label>
          <input class="field-input" type="email" name="mail_invite"><br>
          <span class="errorMessage"><?php if(!empty($error['email'])) { echo($error['email']);} ?></span>

          <input type="submit" value="Inviter">
        </form>
      </div>
			<br><br><br>

      <?php   echo $pagination_adh; ?>
      <div class="table-responsive shadow-z-1">
        <table id="table" class="table table-hover table-mc-light-blue" >
          <thead>
						<tr>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Pseudo</th>
							<th>Adresse-mail</th>
							<th>Portefeuille</th>
              <th>Crediter</th>
              <th>Supprimer</th>
						</tr>
          </thead>
          <tbody>
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
          </tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php $this->stop('main_content') ?>
