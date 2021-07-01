<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $pad->name . ' (' . count($notes) . ')';
?>
<?php if ($notes): ?>
  <table class="notes">
    <tr>
      <th class="note">Note <a href="<?= Url::toRoute(['pad/view', 'id' => $pad->id, 'order' => '-name']) ?>" class="sort_arrow" >&uarr;</a><a href="<?= Url::toRoute(['pad/view', 'id' => $pad->id, 'order' => 'name']) ?>" class="sort_arrow" >&darr;</a></th>
      <th class="date">Last modified <a href="<?= Url::toRoute(['pad/view', 'id' => $pad->id, 'order' => '-updated_at']) ?>" class="sort_arrow" >&uarr;</a><a href="<?= Url::toRoute(['pad/view', 'id' => $pad->id, 'order' => 'updated_at']) ?>" class="sort_arrow" >&darr;</a></th>
    </tr>
    <?php foreach($notes as $note): ?>
        <tr>
          <td><a href="<?= Url::toRoute(['note/view', 'id' => $note->id]) ?>"><?= Html::encode($note->name); ?></a></td>
          <td class="hidden-text date"><?= $note->getSmartDate(); ?></td>
        </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <p class="empty">Create first note in the pad.</p>
<?php endif; ?>
<a href="<?= Url::toRoute(['note/create', 'pad' => $pad->id])?>" class="button">New note</a>&nbsp;
<a href="<?= Url::toRoute(['pad/edit', 'id' => $pad->id])?>">Pad settings</a>


