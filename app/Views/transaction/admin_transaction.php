<?php $this->layout('layout', ['title' => 'Back']) ?>

<?php $this->start('main_content') ?>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">

			<form class="form-group newTransaction" name="newTransaction" method="POST" action="<?php echo $this->url('admin_back_transac_valid') ?>">
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
		</div>
	</div>
</div>
	
<?php $this->stop('main_content') ?>
