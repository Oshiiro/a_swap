<?php $this->layout('layout', ['title' => 'Messagerie']) ?>

<?php $this->start('main_content') ?>

<div class="container">
  <div class="row">
    <h2>Messagerie</h2>
    <h5>Liste des derniers messages</h5>

    <table>
      <?php foreach ($messages as $message): ?>
      <tr>
        <td><?php echo $message['username'];?></td>
        <td><?php echo $message['content'];?></td>
        <td><?php echo $message['created_at'];?></td>
        <td><?php echo $message['read_at'];?></td>
      </tr>
      <?php endforeach; ?>
    </table>

    <button>Envoyer un message</button>

    <select>
      <?php foreach ($users as $user): ?>
        <option> <?php echo $user['username'];?></option>
      <?php endforeach; ?>
    </select>

    <h3>Envoyer un message</h3>

    <form class="form-group">
      <div class="form-group">
        <label for="">Message</label>
        <textarea name="rules_assos" class="form-control" placeholder="Votre message"></textarea>
      </div>
      <input type="submit" name="submit" value="envoyer">
    </form>
  </div>
</div>


<?php $this->stop('main_content') ?>
