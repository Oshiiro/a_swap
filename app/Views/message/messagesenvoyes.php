<?php $this->layout('layout', ['title' => 'Messagerie', 'slug' => $slug, 'page_sen' => 1]) ?>

<?php $this->start('main_content') ?>
<button title="Envoyer un message" class="btn btn-primary btn-circle sendMessage btn-lg" type="button"><i class="fa fa-envelope-o" aria-hidden="true"></i></button>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-2 col-sm-10 col-sm-push-1 col-md-push-1 col-md-10">
      <form class="form-group formulaire" style="display : none;" name="class" method="POST" action="">
        <h4>Envoyer un message</h4>
        <label for="">Destinataire</label>
        <select class="form-control" name="destinataire" >
          <?php foreach ($users as $user): ?>
            <option value="<?php echo $user['id_users'] ?>"><?php echo $user['username'];?></option>
          <?php endforeach; ?>
        </select><br>
        <div class="field">
          <label for="message" class="field-label">Votre message</label>
          <textarea name="message" class="field-input"></textarea>
        </div>
        <input class="btn btn-default" type="submit" name="submit" value="envoyer">
        <br><br>
        <legend></legend>
      </form>

      <!-- Messages envoyés -->
      <a href="<?php echo $this->url('message',['page_rec'=>1])  ?>"><button type ="button" title="Afficher messages reçus" class="btn btn-primary messagesEnvoyes btn-lg" type="button">Messages reçus</button></a>
      <a href="<?php echo $this->url('messages_envoyes',['page_sen'=>1])  ?>"><button type ="button" title="Afficher messages envoyés" class="btn btn-primary messagesEnvoyes btn-lg" type="button">Messages envoyés</button></a>
      <div class="envoyes"style="display : none;">
        <table>
          <br>
          <?php if(!empty($messagesenvoyes)) {
            foreach ($messagesenvoyes as $messagesenvoye) { ?>
              <th>Envoyé à :<?php echo ' ' .$messagesenvoye['username'];?></th>
              <tr>
                <td><?php echo 'Envoyé le ' .date('d-m-Y', strtotime($messagesenvoye['created_at'])).
                               ' à ' .date('H\hi', strtotime($messagesenvoye['created_at']));?></td>
                <td><a href="<?php echo $this->url('delete_message_envoye', array( 'page_sen' => $page_sen,'id' => $messagesenvoye['id'])) ?>" title='Supprimer message'><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
              </tr>
              <tr>
                <td><?php echo $messagesenvoye['content'];?></td>
              </tr>
          <?php  }
          } else { echo 'Vous n\'avez aucun message envoyé.'; }?>
        </table>
      </div>
      <?php echo $pagination2; ?>
    </div>
  </div>
</div>
<!--
<script src="appMessage.js"></script> ??????? ne semble pas necessaire-->
<?php $this->stop('main_content') ?>