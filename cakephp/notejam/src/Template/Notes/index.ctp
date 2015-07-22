  <table class="notes">
    <tr>
      <th class="note">Note <a href="#" class="sort_arrow" >&uarr;</a><a href="#" class="sort_arrow" >&darr;</a></th>
      <th>Pad</th>
      <th class="date">Last modified <a href="#" class="sort_arrow" >&uarr;</a><a href="#" class="sort_arrow" >&darr;</a></th>
    </tr>
    <?php foreach($notes as $note): ?>
        <tr>
          <td><a href="#"><?= $note->name; ?></a></td>
          <td class="pad"><?= $note->pad ? $note->pad->name : 'No pad'; ?></td>
          <td class="hidden-text date"><?= $note->updated_at; ?></td>
        </tr>
    <?php endforeach; ?>
  </table>
  <?= $this->Html->link("New note", ["_name" => "create_note"], ["class" => "button"]); ?>
