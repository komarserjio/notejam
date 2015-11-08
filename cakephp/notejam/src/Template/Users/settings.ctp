<?php $this->assign('title', __('Account settings')); ?>

<?php echo $this->Form->create($settings, ['class' => 'offset-by-six sign-in']); ?>
    <?php echo $this->Form->input('current_password', ['type' => 'password']); ?>
    <?php echo $this->Form->input('new_password', ['type' => 'password']); ?>
    <?php echo $this->Form->input('confirm_new_password', ['type' => 'password']); ?>
    <?php echo $this->Form->submit(__('Save')); ?>
<?php echo $this->Form->end(); ?>
