<?php $this->layout('layout_superadmin_back', ['title' => 'Super Back']) ?>

<?php $this->start('main_content') ?>
	<h2>Super Admin</h2>

  <div class="panel panel-default container">
    <div class="panel-heading"></div>
      <table class="col-md-offset-1 col-md-9">
        <tr>
          <td>Nombre d'association inscrite sur le site :</td>
          <td>Nombre de user inscrit sur le site :</td>
        </tr>
        <tr>
          <td><?php echo $nombreAsso; ?></td>
          <td><?php echo $nombreUsers; ?></td>
        </tr>
      </table>
    </div>
  </div>

  <div class="panel panel-default container">
    <div class="panel-heading"></div>
      <table class="col-md-offset-1 col-md-9">
        <tr>
          <td>Derniere asso inscrite :</td>
          <td>Dernier user inscrit :</td>
        </tr>
        <tr>
          <td><?php echo $lastAsso; ?></td>
          <td><?php echo $lastUser; ?></td>
        </tr>
      </table>
    </div>
  </div>

  <div class="panel panel-default container">
    <div class="panel-heading"></div>
      <table class="col-md-offset-1 col-md-9">
        <tr>
          <td>Asso la plus active (nombre transaction/jour en moyenne) :</td>
        </tr>
      </table>
    </div>
  </div>

  <div class="panel panel-default container">
    <div class="panel-heading">Liste des users (max 20 + pagination) :</div>
      <table class="col-md-offset-1 col-md-9">
        <?php foreach ($allUsers as $user) {
          echo '<tr><td>' .$user['username']. '</td></tr>';
        } ?>
      </table>
    </div>
  </div>

  <div class="panel panel-default container">
    <div class="panel-heading">  Liste des assos (idem) :</div>
      <table class="col-md-offset-1 col-md-9">
        <?php foreach ($allAssos as $asso) {
          echo '<tr><td>' .$asso['name']. '</td></tr>';
        } ?>
      </table>
    </div>
  </div>

	<div class="panel panel-default container">
    <div class="panel-heading">  L'association avec le plus de coins actuellement en circulation est :</div>
      <table class="col-md-offset-1 col-md-9">
				<tr>
          <td><?php echo $most_money_asso['name']. ' avec ' .$most_money_asso['money']['SUM(wallet)']. ' ' .$most_money_asso['money_name']. ' en cours' ?></td>
        </tr>
      </table>
    </div>
  </div>
















<?php $this->stop('main_content') ?>
