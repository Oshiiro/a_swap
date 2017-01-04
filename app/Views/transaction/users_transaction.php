<?php $this->layout('layout', ['title' => 'Transaction', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>


	<!-- /////////////////////// FAIRE TRANSACTION ////////////////////////// -->
		<form class="form-group newTransaction" name="newTransaction" method="POST" action="<?php echo $this->url('users_accueil_transac_valid', ['slug' => $this->e($slug)]) ?>">
			<h4>Faire une transaction</h4>
			<label for="">Destinataire</label>
			<select class="form-control" name="destinataire" >
				<?php foreach ($adherants as $adherant): ?>
					<option value="<?php echo $adherant['id_users'] ?>"><?php echo $adherant['username'];?></option>
				<?php endforeach; ?>
			</select><br>
			<div class="form-group">
				<label for="">Texte explicatif</label>
				<textarea name="description" class="form-control" placeholder="Votre message"></textarea>
			</div>
			<input type="number" class="number" name="sum" value=Montant>
			<input class="btn btn-default" type="submit" name="submit" value="envoyer">
		</form>
<?php $this->stop('main_content') ?>
