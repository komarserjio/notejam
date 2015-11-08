<p><?= __("Are you sure you want to delete {$note->name};") ?></p>
<?= $this->Form->create(); ?>
    <!-- cake's post link should be used -->
    <input type="submit" class="red" value="<?= __("Yes, I want to delete this note") ?>" ?>
    &nbsp;
    <?= $this->Html->link(__('Cancel'), ['_name' => 'view_note', 'id' => $note->id]) ?>
<?= $this->Form->end(); ?>
