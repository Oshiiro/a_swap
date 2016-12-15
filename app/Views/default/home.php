<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>

<!-- Infographies -->
<div class="container">
  <div class="row base">

    <h2 class="accroche">Petite phrase d'accroche trop styléééééé</h2>
    <div class="barreEmailInscription">
      <h3> Inscris ton assos'</h3>
        <div class="AdresseMail">
          <input type="email" name="email" value="Inscrit ton assos'!" class="form-control inscripAssos">
          <a href="#" class="check"><i class="fa fa-check-circle fa-4x" aria-hidden="true"></i></a>
        </div>
    </div>


    <div class="infographieDiv">
      <img src="../public/assets/img/infographie.png" alt="" >
    </div>

  </div>
</div>
<?php $this->stop('main_content') ?>
