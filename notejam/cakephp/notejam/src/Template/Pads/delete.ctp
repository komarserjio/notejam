<p><?= __("Are you sure you want to delete {$pad->name};") ?></p>
<?= $this->Form->create(); ?>
    <input type="submit" class="red" value="<?= __("Yes, I want to delete this pad") ?>" ?>
    &nbsp;
    <?= $this->Html->link(__('Cancel'), ['_name' => 'index']) ?>
<?= $this->Form->end(); ?>
