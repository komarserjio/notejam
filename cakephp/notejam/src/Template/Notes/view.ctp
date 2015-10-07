<?php $this->assign('title', h($note->name)); ?>
<p class="hidden-text">Last edited at <?= $note->getPrettyDate(); ?></p>
<div class="note">
    <p>
        <?= h($note->text); ?>
    </p>
</div>
<?= $this->Html->link('Edit note', ['id' => $note->id, '_name' => 'edit_note'], ['class' => 'button']) ?>
<?= $this->Html->link('Delete it', ['id' => $note->id, '_name' => 'delete_note'], ['class' => 'delete-note']) ?>
