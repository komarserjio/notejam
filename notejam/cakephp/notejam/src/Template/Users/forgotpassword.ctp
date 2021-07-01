<?php $this->assign('title', __('Forgot password?')); ?>

<?php echo $this->Form->create($form, ['class' => 'offset-by-six sign-in']); ?>
    <?php echo $this->Form->input('email', ['type' => 'text']); ?>
    <?php echo $this->Form->submit(__('Generate password')); ?>
<?php echo $this->Form->end(); ?>
