<?php echo $this->Form->create($note, ['class' => 'note']); ?>
    <?php echo $this->Form->input('name'); ?>
    <?php echo $this->Form->textarea('text'); ?>
    <?php echo $this->Form->input('pad_id', ['type' => 'select', 'empty' => '---------', 'options' => $pads, 'default' => !empty($pad) ? $pad : 0]); ?>
    <?php echo $this->Form->submit(__('Save')); ?>
<?php echo $this->Form->end(); ?>
