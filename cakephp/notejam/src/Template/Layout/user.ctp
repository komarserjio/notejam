<?php $this->extend('/Layout/default'); ?>

<div class="sixteen columns content-area">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</div>
