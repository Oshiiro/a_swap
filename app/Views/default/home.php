<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>

<!-- Infographies -->
<div class="container">
  <div class="row base">

    <h2 class="accroche">Petite phrase d'accroche trop styléééééé</h2>
    <div class="barreEmailInscription">
      <h3> Inscris ton assos'</h3>
        <div class="AdresseMail">
          <form class="" action="<?php echo $this->url('admin_assos_register'); ?>" method="POST">
            <input type="text" name="nom_assos" placeholder="Inscris ton assos' !" class="form-control inscripAssos">
            <button type="submit" class="check"><i class="fa fa-check-circle fa-4x" aria-hidden="true"></i></button>
          </form>
        </div>
    </div>


    <div class="infographieDiv">
      <img src="../public/assets/img/infographie.png" alt="" >
    </div>

  </div>
</div>
<?php $this->stop('main_content') ?>
