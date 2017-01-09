<?php $this->layout('layout_admin_back', ['title' => 'Back', 'slug' => $slug]) ?>

<?php $this->start('main_content') ?>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">

			<form class="form-group newCredit" name="newCredit" method="POST" action="<?php echo $this->url('admin_back_credite_valid')?>">
				<h4>Crediter un membre</h4>
        <?php if (!empty($adherants)) {?>
        <div class="field">
				<label for="" class="field-label">Destinataire</label>
				<select class="field-input" name="destinataire" >
					<?php foreach ($adherants as $adherant): ?>
						<option value="<?php echo $adherant['id'] ?>"><?php echo $adherant['username'];?></option>
					<?php endforeach; ?>
				</select><br>
        <?php } else { ?>
          <div class="field field-select">
  				<label for="" class="field-label-select">Destinataire</label>
  				<select class="field-imput-select" name="destinataire" >
  					<?php foreach ($adherants as $adherant): ?>
  						<option value="<?php echo $adherant['id'] ?>"><?php echo $adherant['username'];?></option>
  					<?php endforeach; ?>
  				</select><br>
        <?php } ?>
        </div>
				<div class="textfield field" style="margin-bottom: 60px;">
					<label for="" class="field-label" >Votre message</label>
					<textarea name="description" class="field-input"></textarea>
				</div>

        <div class="field col-md-3">
          <label for="sum" class="field-label">Somme à crediter</label>
				  <input type="number" class="number field-input" name="sum" value=Montant>
        </div>
        <div class="center">
          <button class="btn btn-circle btn-lg validform" type="submit" name="submit" value=""><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
        </div>
			</form>

		</div>
	</div>
</div>
<?php $this->stop('main_content') ?>
