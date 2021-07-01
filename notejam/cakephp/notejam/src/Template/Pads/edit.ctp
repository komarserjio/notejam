<?php $this->assign('title', __('Edit ' .  $pad->name)); ?>

<?php echo $this->element('pads/form'); ?>
<?= $this->Html->link('Delete pad', ['id' => $pad->id, '_name' => 'delete_pad'], ['class' => 'small-red']) ?>
