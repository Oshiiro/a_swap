<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>

<!-- Infographies -->
  <?php if(empty($_SESSION['user']['role'])) { ?>
    <h2 class="accroche">Petite phrase d'accroche trop stylé</h2>
    <div class="barreEmailInscription">
      <h3> Inscris ton assos'</h3>
      <div class="AdresseMail">
        <form class="formEmail" action="<?php echo $this->url('admin_assos_register'); ?>" method="GET">
          <input type="text" name="nom_assos" placeholder="Inscris ton assos' !" class="form-control inscripAssos">
          <button type="submit" class="check"><i class="fa fa-check-circle fa-2x" aria-hidden="true"></i></button>
        </form>
      </div>
    </div>
  <?php } ?>
    <div class="container textes">
      <div class="row">
        <div class="col-sm-6 col-md-4">
          <div class="thumbnail texteExplicatif">
            <img src="../public/assets/img/01swap.png" alt="...">
            <div class="caption">
              <p>Pour acceder aux nos services, il suffit de t'inscrire, suite à l'invitation du président de ton assos'</p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="thumbnail texteExplicatif">
            <img src="../public/assets/img/02swap.png" alt="...">
            <div class="caption">
              <p>Tu es ensuite connecté avec tout les membres de ton association, et tu peux facilement les contacter grâce à la messagerie</p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="thumbnail texteExplicatif">
            <img src="../public/assets/img/03swap.png" alt="...">
            <div class="caption">
              <p>Il ne te reste plus qu'à faire des échanges avec eux, et gérer ta monnaie virtuelle comme bon te semble</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid explications">
      <div class="row">
        <div class="col-md-6 col-md-push-3">
          <h3>A-Swap, c'est quoi ?</h3>
          <p>
            a-Swap : Késséssé ? <br>

            Le site a-Swap est une application web a destination des associations permettant de creer et gerer des monnaies virtuelles.
            Son utilisation est completement gratuite.
            L'appli permet par exemple, la création de Sytemes d'Echanges Locaux (SEL) ou de Systemes d'Echanges Associatifs.
            <br><br>

            a-Swap : Kommenkonfé ? <br>

            Chaque association créant sa monnaie via le service a-Swap est libre de l'utiliser et de la gerer comme bon lui semble.
            Pour chaque association un administrateur est designé (dans l'ideal, un membre du bureau de l'association). Celui-ci est libre de creer un reglement regissant le fonctionnement de
            sa monnaie associative, d'inviter des membres a rejoindre son association, d'ajouter des credits (appelé coins sur a-Swap) aux membres de son association, de restreindre l'accés a son association aux membres, etc.
            <br><br>

            a-Swap : Exemp' <br>

            L'association "Les Philatelistes du Roumois" decide de creer une monnaie utilisable par les membres de l'association (le "stamp coin") afin de pouvoir s'echanger des timbres
            lors de ses bourses d'echanges.
            Roger, le tresorier de l'association et administrateur de la section sur le site decide d'offrir a chaque nouvels inscrits un credit de 10 stamp coins.
            Regis souhaite echanger avec Bernard un timbre de collection, mais ce dernier n'a rien a lui proposer en retour. Regis fixe le prix du timbre a 3 stamp coins. Via l'appli accessible depuis son portable, Bernard se connecte a sa session, accede a la partie "effectuer un virement", selectionne Regis comme beneficiaire, indique un montant de 3 coins et valide la transaction.
            Le compte de Regis est debité de 3 coins, celui de Bernard est credité du meme montant.
          </p>
        </div>
      </div>
    </div>

<?php $this->stop('main_content') ?>
