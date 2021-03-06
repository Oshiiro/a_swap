<?php $this->layout('layout', ['title' => 'Mes messages envoyés', 'slug' => $slug, 'page_sen' => 1]) ?>

<?php $this->start('main_content') ?>
<button title="Envoyer un message" class="btn btn-circle sendMessage btn-lg" type="button"><i class="fa fa-envelope-o" aria-hidden="true"></i></button>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">

      <h2>Messagerie</h2>

      <form class="form-group formulaire" style="display : none;" name="class" method="POST" action="">
        <h4>Envoyer un message</h4>
        <?php if (!empty($users)) {?>
        <div class="field">
          <label for="destinataire" class="field-label">Destinataire</label>
          <select class="field-input" name="destinataire" >
            <?php foreach ($users as $user): ?>
              <option value="<?php echo $user['id_users'] ?>"><?php echo $user['username'];?></option>
            <?php endforeach; ?>
          </select>
        </div><br>
        <?php } else { ?>
        <div class="field field-select">
          <label for="destinataire" class="field-label-select">Destinataire</label>
          <select class="field-input-select" name="destinataire" >
            <option value=""></option>
          </select>
        </div><br>
        <?php } ?>

        <div class="textfield field" style="margin-bottom: 60px;">
          <label for="message" class="field-label">Votre message</label>
          <textarea name="message" class="field-input"></textarea>
        </div>
        <div class="center">
          <button class="btn btn-circle btn-lg validform" type="submit" name="submit" value=""><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
        </div>
      </form>
      <div class="row">
        <div class="col-md-12">
          <a href="<?php echo $this->url('message',['page'=>1])  ?>"><button type ="button" title="Afficher messages reçus" class="btn btn-perso  " >Messages reçus</button></a>
          <a href="<?php echo $this->url('messages_envoyes',['page'=>1])  ?>"><button type ="button" title="Afficher messages envoyés" class="btn btn-perso2 ">Messages envoyés</button></a>
        </div>
      </div>

      <?php if(!empty($messagesenvoyes)) { ?>
        <div class="ligne col-md-12"></div>
        <?php foreach ($messagesenvoyes as $messageenvoye) { ?>
          <div class="row messagerieRow">

            <div class="col-md-1 col-xs-2">
              <?php if (!empty($avatar)) { ?>
              <img class="img-circle img-messagerie" src="<?php echo $this->assetUrl($avatar) ?>" alt="avatar aswap">
              <?php } else { ?>
              <img class="img-circle img-messagerie" src="<?php echo $this->assetUrl('img/profil/default-avatar.jpg') ?>" alt="default-avatar">
              <?php } ?>

            </div>

            <div class="col-md-10 col-xs-9">
              <p>
                <?php echo 'Envoyé le : ' .date('d-m-Y', strtotime($messageenvoye['created_at'])). ' à ' .date('H\hi', strtotime($messageenvoye['created_at']));?>
                <br>
                <?php echo '<b>' . $messageenvoye['username'] . ' -</b>';?>
                <?php echo '<span class="message">' . $messageenvoye['content'] . '</span>';?>
              </p>
            </div>

            <div class="col-md-1 col-xs-1">
              <a class="" href="<?php echo $this->url('delete_message_envoye', array( 'page' => $page,'id' => $messageenvoye['id'])) ?>" title="Supprimer le message"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            </div>

            <br>
          </div>
          <div class="ligne col-md-12"></div>
        <?php } ?>
      <?php } else { ?>
        <div class="block-message-1 col-md-12">Vous n'avez aucun message.</div>
      <?php }?>
      <?php echo $pagination2; ?>
    </div>
  </div>
</div>
<!--
<script src="appMessage.js"></script> ??????? ne semble pas necessaire-->
<?php $this->stop('main_content') ?>
