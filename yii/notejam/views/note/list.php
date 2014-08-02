<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'All notes()';
?>
  <table class="notes">
    <tr>
      <th class="note">Note <a href="#" class="sort_arrow" >&uarr;</a><a href="#" class="sort_arrow" >&darr;</a></th>
      <th>Pad</th>
      <th class="date">Last modified <a href="#" class="sort_arrow" >&uarr;</a><a href="#" class="sort_arrow" >&darr;</a></th>
    </tr>
    <?php foreach(Yii::$app->user->identity->notes as $note): ?>
        <tr>
          <td><a href="#"><?= $note->name; ?></a></td>
          <td class="pad"></td>
          <td class="hidden-text date">Today at 10:51</td>
        </tr>
    <?php endforeach; ?>
  </table>
  <a href="#" class="button">New note</a>
