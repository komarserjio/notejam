<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'All notes(' . count($notes) . ')';
?>
<?php if ($notes): ?>
  <table class="notes">
    <tr>
    <th class="note">Note <a href="<?= Url::toRoute('note/list') ?>?order=-name" class="sort_arrow" >&uarr;</a><a href="<?= Url::toRoute('note/list') ?>?order=name" class="sort_arrow" >&darr;</a></th>
      <th>Pad</th>
      <th class="date">Last modified <a href="<?= Url::toRoute('note/list') ?>?order=-updated_at" class="sort_arrow" >&uarr;</a><a href="<?= Url::toRoute('note/list') ?>?order=updated_at" class="sort_arrow" >&darr;</a></th>
    </tr>
    <?php foreach($notes as $note): ?>
        <tr>
          <td><a href="<?= Url::toRoute(['note/view', 'id' => $note->id]) ?>"><?= Html::encode($note->name); ?></a></td>
          <td class="pad">
            <?php if ($note->pad): ?>
                <a href="<?= Url::toRoute(['pad/view', 'id' => $note->pad->id]) ?>"><?= Html::encode($note->pad->name); ?></a>
            <?php else: ?>
                No pad
            <?php endif; ?>
          </td>
          <td class="hidden-text date"><?= $note->getSmartDate(); ?></td>
        </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <p class="empty">Create your first note.</p>
<?php endif; ?>
<a href="<?= Url::toRoute('note/create') ?>" class="button">New note</a>
