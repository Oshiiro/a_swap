<?php $this->layout('layout', ['title' => 'Transaction', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>


	<!-- /////////////////////// FAIRE TRANSACTION ////////////////////////// -->
	<div class="container block-message">
		<div class="row">
			<div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
				<form class="form-group newTransaction" name="newTransaction" method="POST" action="<?php echo $this->url('users_accueil_transac_valid', ['slug' => $this->getValueInArray($dataAssos, 'slug')]) ?>">
					<h4>Faire une transaction</h4>
					<label for="">Destinataire</label>
					<select class="form-control" name="destinataire" >
						<?php foreach ($adherants as $adherant): ?>
							<option value="<?php echo $adherant['id_users'] ?>"><?php echo $adherant['username'];?></option>
						<?php endforeach; ?>
					</select><br>
					<div class="field">
						<label for="" class="field-label">Votre message</label>
						<textarea name="description" class="field-input"></textarea>
					</div>
					<input type="number" class="number" name="sum" value=Montant>
					<div class="center">
            <button class="btn btn-circle btn-lg validform" type="submit" name="submit" value=""><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
          </div>
				</form>
			</div>
		</div>
	</div>
<?php $this->stop('main_content') ?>
