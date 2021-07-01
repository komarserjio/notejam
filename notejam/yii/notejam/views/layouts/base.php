<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
    <title><?= Html::encode($this->title) ?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/base.min.css">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/skeleton.min.css">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/layout.css">
	<link rel="stylesheet" href="/css/style.css">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
  <div class="container">
    <div class="sixteen columns">
      <div class="sign-in-out-block">
        <?php if (Yii::$app->user->isGuest): ?>
            <a href="<?= Url::toRoute('user/signin') ?>">Sign in</a>&nbsp;&nbsp;&nbsp;<a href="<?= Url::toRoute('user/signup') ?>">Sign up</a>
        <?php else: ?>
            <?= Html::encode(Yii::$app->user->identity->email) ?>:&nbsp; <a href="<?= Url::toRoute('user/settings') ?>">Account settings</a>&nbsp;&nbsp;&nbsp;<a href="<?= Url::toRoute('user/signout') ?>">Sign out</a>
        <?php endif; ?>
      </div>
    </div>
    <div class="sixteen columns">
      <h1 class="bold-header">
          <a href="<?= Url::toRoute('note/list'); ?>" class="header">note<span class="jam">jam: </span></a> <span><?= Html::encode($this->title) ?></span>
      </h1>
    </div>
    <?= $this->blocks['pads'] ?>

    <?= $content ?>

    <hr class="footer" />
    <div class="footer">
      <div>Notejam: <strong>Yii</strong> application</div>
      <div><a href="https://github.com/komarserjio/notejam">Github</a>, <a href="https://twitter.com/komarserjio">Twitter</a>, created by <a href="https://github.com/komarserjio/">Serhii Komar</a></div>
    </div>
  </div><!-- container -->
</body>
</html>
