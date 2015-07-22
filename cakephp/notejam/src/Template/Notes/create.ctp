<?php $this->assign('title', 'New note'); ?>

<?php echo $this->Form->create($note, ['class' => 'note']); ?>
    <?php echo $this->Form->input('name'); ?>
    <?php echo $this->Form->textarea('text'); ?>
    <?php echo $this->Form->input('pad_id', ['type' => 'select', 'options' => array_merge(['0' => '------'], $pads )]); ?>
    <?php echo $this->Form->submit('Save'); ?>
<?php echo $this->Form->end(); ?>


