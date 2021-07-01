<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <title><?= $this->fetch('title') ?></title>

    <?= $this->Html->css('http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/base.min.css') ?>
    <?= $this->Html->css('http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/skeleton.min.css') ?>
    <?= $this->Html->css('http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/layout.css') ?>
    <?= $this->Html->css('style.css') ?>

    <?= $this->fetch('css') ?>
</head>
<body>
    <div class="container">
        <div class="sixteen columns">
            <div class="sign-in-out-block">
                <?php if ($this->request->session()->read('Auth.User')): ?>
                    <?= $this->request->session()->read('Auth.User.email') ?>:&nbsp; <?= $this->Html->link(__('Account settings'), ['_name' => 'settings'])?>&nbsp;&nbsp;&nbsp;<?= $this->Html->link(__('Sign out'), ['_name' => 'signout'])?>
                <?php else: ?>
                    <?= $this->Html->link(__('Sign up'), ['_name' => 'signup'])?>&nbsp;&nbsp;&nbsp;<?= $this->Html->link(__('Sign in'), ['_name' => 'signin'])?>
                <?php endif; ?>
            </div>
        </div>
        <div class="sixteen columns">
            <h1 class="bold-header"><a href="/" class="header">note<span class="jam">jam: </span></a> <span><?= $this->fetch('title') ?></span></h1>
        </div>

        <?= $this->fetch('content') ?>

        <hr class="footer" />
        <div class="footer">
            <div>Notejam: <strong>CakePHP</strong> application</div>
            <div><a href="https://github.com/komarserjio/notejam">Github</a>, <a href="https://twitter.com/komarserjio">Twitter</a>, created by <a href="https://github.com/komarserjio/">Serhii Komar</a></div>
        </div>
    </div><!-- container -->
    <a href="https://github.com/komarserjio/notejam"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png" alt="Fork me on GitHub"></a>
</body>
</html>
