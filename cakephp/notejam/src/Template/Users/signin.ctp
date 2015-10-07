<?php $this->assign('title', __('Sign in')); ?>

<?php echo $this->Form->create(null, ['class' => 'offset-by-six sign-in']); ?>
    <?php echo $this->Form->input('email'); ?>
    <?php echo $this->Form->input('password', ['label' => __('Password')]); ?>
    <input type="submit" value="Sign In"> or <?= $this->Html->link(__('Sign Up'), ['_name' => 'signup']) ?>
<?php echo $this->Form->end(); ?>
