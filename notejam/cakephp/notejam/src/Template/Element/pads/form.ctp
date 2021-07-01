<?php echo $this->Form->create($pad, ['class' => 'pad']); ?>
    <?php echo $this->Form->input('name'); ?>
    <?php echo $this->Form->submit(__('Save')); ?>
<?php echo $this->Form->end(); ?>
