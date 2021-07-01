<?php $this->assign('title', __('Sign up')); ?>
<?php echo $this->Form->create($user, ['class' => 'offset-by-six sign-in']); ?>
    <?php echo $this->Form->input('email'); ?>
    <?php echo $this->Form->input('password', ['label' => __('Password')]); ?>
    <?php echo $this->Form->input('confirm_password', ['label' => __('Confirm password'), 'type' => 'password']); ?>
    <input type="submit" value="Sign up" /> or <?= $this->Html->link(__('Sign In'), ['_name' => 'signin']) ?>
<?php echo $this->Form->end(); ?>
