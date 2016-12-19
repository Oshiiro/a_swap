<?php $this->layout('layout', ['title' => 'Messagerie']) ?>

<?php $this->start('main_content') ?>

<div class="container">
  <div class="row">
    <h2>Messagerie</h2>
    <h5>Liste des derniers messages</h5>

    <button class="btn btn-default sendMessage">Envoyer un message</button>
    <table>
      <th>Pseudo</th>
      <th>Message</th>
      <th>Reçu le</th>
      <th>Lu le</th>

      <?php foreach ($messages as $message): ?>
      <tr>
        <td><b><?php echo $message['username'];?></b></td>
        <td><?php echo $message['content'];?></td>
        <td><?php echo $message['created_at'];?></td>
        <td><?php echo $message['read_at'];?></td>
      </tr>
      <?php endforeach; ?>
    </table>




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
    </form>
  </div>
</div>

<script src="appMessage.js"></script>
<?php $this->stop('main_content') ?>
