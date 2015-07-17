<p>Are you sure you want to delete <?= $pad->name; ?>?</p>
<?= $this->Form->create(); ?>
    <input type="submit" class="red" value="Yes, I want to delete this pad" ?>
    &nbsp;
    <?= $this->Html->link('Cancel', '#') ?>
<?= $this->Form->end(); ?>
