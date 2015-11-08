<?php $this->assign('title', __("All notes ({$notes->count()})")); ?>
<?php if ($notes->count()): ?>
    <table class="notes">
        <tr>
            <th class="note"><?= __("Note") ?> <?= $this->Html->link('↑', ['_name' => 'index', 'order' => '-name'], ['class' => 'sort_arrow']) ?><?= $this->Html->link('↓', ['_name' => 'index', 'order' => 'name'], ['class' => 'sort_arrow']) ?></th>
            <th><?= __("Pad") ?></th>
            <th class="date"><?= __("Last modified") ?> <?= $this->Html->link('↑', ['_name' => 'index', 'order' => '-updated_at'], ['class' => 'sort_arrow']) ?><?= $this->Html->link('↓', ['_name' => 'index', 'order' => 'updated_at'], ['class' => 'sort_arrow']) ?></th>
        </tr>
        <?php foreach($notes as $note): ?>
            <tr>
                <td><?= $this->Html->link($note->name, ['id' => $note->id, '_name' => 'view_note']) ?></td>
                <td class="pad"><?= h($note->pad) ? $this->Html->link($note->pad->name, ['id' => $note->pad->id, '_name' => 'view_pad']) : 'No pad'; ?></td>
                <td class="hidden-text date"><?= $note->getPrettyDate(); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p class="empty"><?= __("Create your first note") ?></p>
<?php endif; ?>
<?= $this->Html->link(__("New note"), ["_name" => "create_note"], ["class" => "button"]); ?>
