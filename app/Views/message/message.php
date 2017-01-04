<?php $this->layout('layout', ['title' => 'Messagerie', 'slug' => $slug]) ?>

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
        <div class="form-group">
          <label for="">Message</label>
          <textarea name="message" class="form-control" placeholder="Votre message"></textarea>
        </div>
        <input class="btn btn-default" type="submit" name="submit" value="envoyer">
        <br><br>
        <legend></legend>
      </form>

<!-- Messages reçus -->
        <table>
          <?php if(!empty($messages)) {
          foreach ($messages as $message) { ?>
              <th>Message de :<?php echo ' ' .$message['username'];?></th>
              <tr>
                <td><?php echo 'Envoyé le ' .date('d-m-Y', strtotime($message['created_at'])).
                               ' à ' .date('H\hi', strtotime($message['created_at']));?></td>
                <td><a href="<?php echo $this->url('delete_message', array('page_rec'=> $page_rec, 'page_sen' => $page_sen, 'id' => $message['id'])) ?>" title="Supprimer le message"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
              </tr>
              <tr>
                <td><?php echo $message['content'];?></td>
              </tr>
          <?php } } else {
            echo '<div class="block-message-1">Vous n\'avez aucun message</div>';
          }?>
        </table>
        <?php echo $pagination_receiver; ?>

<!-- Messages envoyés -->
<button type ="button" title="Afficher message envoyé" class="btn btn-primary messagesEnvoyes btn-lg" type="button">Messages envoyés</button>
      <div class="envoyes"style="display : none;">
        <table>
          <br>
          <?php debug($messagesenvoyes); ?>
          <?php if(!empty($messagesenvoyes)) {
            foreach ($messagesenvoyes as $messagesenvoye) { ?>
              <th>Envoyé à :<?php echo ' ' .$messagesenvoye['username'];?></th>
              <tr>
                <td><?php echo 'Envoyé le ' .date('d-m-Y', strtotime($messagesenvoye['created_at'])).
                               ' à ' .date('H\hi', strtotime($messagesenvoye['created_at']));?></td>
                <td><a href="<?php echo $this->url('delete_message', array('id' => $messagesenvoye['id'])) ?>" title='Supprimer message'><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
              </tr>
              <tr>
                <td><?php echo $messagesenvoye['content'];?></td>
              </tr>
          <?php  }
        } else { echo 'Vous n\'avez aucun message envoyé.'; }?>
      </table>
      <?php echo $pagination_sender; ?>
      </div>
    </div>
  </div>
</div>
<!--
<script src="appMessage.js"></script> ??????? ne semble pas necessaire-->
<?php $this->stop('main_content') ?>
