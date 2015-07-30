<?php $this->assign('title', 'Sign in'); ?>

<?php echo $this->Form->create(null, ['class' => 'offset-by-six sign-in']); ?>
    <?php echo $this->Form->input('email'); ?>
    <?php echo $this->Form->input('password', ['label' => 'Password']); ?>
    <input type="submit" value="Sign In"> or <?= $this->Html->link('Sign Up', ['_name' => 'signup']) ?>
<?php echo $this->Form->end(); ?>
