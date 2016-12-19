<?php $this->layout('layout', ['title' => 'Messagerie']) ?>

<?php $this->start('main_content') ?>

<div class="container">
  <div class="row">
    <h2>Messagerie</h2>
    <h5>Liste des derniers messages</h5>

    <button class="btn btn-default">Envoyer un message</button>
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



    <h4>Envoyer un message</h4>

    <form class="form-group formulaire">
      <label for="">Destinataire</label>
      <select class="form-control">
        <?php foreach ($users as $user): ?>
          <option value="<?php echo $user['slug'] ?>"><?php echo $user['username'];?></option>
        <?php endforeach; ?>
      </select><br>
      <div class="form-group">
        <label for="">Message</label>
        <textarea name="rules_assos" class="form-control" placeholder="Votre message"></textarea>
      </div>
      <button class="btn btn-default" type="submit" name="submit" value="">envoyer</button>
    </form>
  </div>
</div>


<?php $this->stop('main_content') ?>
