<?php $this->extend('/Layout/default'); ?>
<div class="thirteen columns content-area">
  <!--<div class="alert-area">-->
    <!--<div class="alert alert-success">Note is sucessfully saved</div>-->
  <!--</div>-->
  <?= $this->Flash->render() ?>

  <?= $this->fetch('content') ?>
</div>
