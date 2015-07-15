<?php $this->extend('/Layout/default'); ?>

<div class="three columns">
  <h4 id="logo">My pads</h4>
  <nav>
  <ul>
    <li><a href="#whatAndWhy">Business</a></li>
    <li><a href="#grid">Personal</a></li>
    <li><a href="#typography">Sport</a></li>
    <li><a href="#buttons">Diary</a></li>
    <li><a href="#forms">Drafts</a></li>
  </ul>
  <hr />
  <a href="#">New pad</a>
  </nav>
</div>

<div class="thirteen columns content-area">
  <?= $this->Flash->render() ?>
  <?= $this->fetch('content') ?>
</div>

