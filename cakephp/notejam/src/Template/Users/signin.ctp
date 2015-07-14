<?php $this->assign('title', 'Sign in'); ?>

<?php echo $this->Form->create(null, ['class' => 'offset-by-six sign-in']); ?>
    <?php echo $this->Form->input('email'); ?>
    <?php echo $this->Form->input('password', ['label' => 'Password']); ?>
    <input type="submit" value="Sign Up"> or <a href='#'>Sign up</a>
<?php echo $this->Form->end(); ?>
