<?php $this->assign('title', $note->name); ?>
<p class="hidden-text">Last edited at <?= $note->updated_at; ?></p>
<div class="note">
    <p>
        <?= $note->text; ?>
    </p>
</div>
<?= $this->Html->link('Edit note', ['id' => $note->id, '_name' => 'edit_note'], ['class' => 'button']) ?>
<?= $this->Html->link('Delete it', ['id' => $note->id, '_name' => 'delete_note'], ['class' => 'delete-note']) ?>
