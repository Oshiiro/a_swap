<?php $this->layout('layout', ['title' => 'Messagerie']) ?>

<?php $this->start('main_content') ?>
<div class="extansion-head">
<button title="Envoyer un message" class="btn btn-primary btn-circle sendMessage btn-lg col-xs-1" type="button"><i class="fa fa-envelope-o" aria-hidden="true"></i></button> 
</div>
<div class="container block-message">
  <div class="row">
    <div class="block col-xs-8 col-xs-push-1 col-lg-10">
      <form class="form-group formulaire" style="display : none;" name="class" method="POST" action="">
        <h4>Envoyer un message</h4>
        <label for="">Destinataire</label>
        <select class="form-control" name="destinataire" >
          <?php foreach ($users as $user): ?>
            <option value="<?php echo $user['id'] ?>"><?php echo $user['username'];?></option>
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
      <table>
        <?php if(!empty($messages)) {
          foreach ($messages as $message) { ?>
            <tr>
              <td><?php echo $message['username'];?></td><br>
              <td><?php echo $message['content'];?></td>
              <td><?php echo $message['created_at'];?></td>
              <td><?php echo $message['read_at'];?></td>
            </tr>
          <?php } } else {
            echo 'Vous n\'avez aucun message';
          }?>
      </table>
    </div>
  </div>
</div>
<!--
<script src="appMessage.js"></script> ??????? ne semble pas necessaire-->
<?php $this->stop('main_content') ?>
