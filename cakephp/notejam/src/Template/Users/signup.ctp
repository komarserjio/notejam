<?php $this->assign('title', 'Sign up'); ?>
<?php echo $this->Form->create($user, ['class' => 'offset-by-six sign-in']); ?>
    <?php echo $this->Form->input('email'); ?>
    <?php echo $this->Form->input('password', ['label' => 'Password']); ?>
    <?php echo $this->Form->input('confirm_password', ['label' => 'Confirm password', 'type' => 'password']); ?>
    <input type="submit" value="Sign Up"> or <a href='#'>Sign in</a>
<?php echo $this->Form->end(); ?>
