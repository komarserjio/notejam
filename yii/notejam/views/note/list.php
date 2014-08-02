<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'All notes()';
?>
  <table class="notes">
    <tr>
      <th class="note">Note <a href="#" class="sort_arrow" >&uarr;</a><a href="#" class="sort_arrow" >&darr;</a></th>
      <th>Pad</th>
      <th class="date">Last modified <a href="#" class="sort_arrow" >&uarr;</a><a href="#" class="sort_arrow" >&darr;</a></th>
    </tr>
    <tr>
      <td><a href="#">My sport activites</a></td>
      <td class="pad">No pad</td>
      <td class="hidden-text date">Today at 10:51</td>
    </tr>
    <tr>
      <td><a href="#">February reports</a></td>
      <td class="pad"><a href="#">Pad</a></td>
      <td class="hidden-text date">Yesterday</td>
    </tr>
    <tr>
      <td><a href="#">Budget plan</a></td>
      <td class="pad"><a href="#">Pad</a></td>
      <td class="hidden-text date">2 days ago</td>
    </tr>
    <tr>
      <td><a href="#">Visit Agenda for all customers</a></td>
      <td class="pad"><a href="#">Pad</a></td>
      <td class="hidden-text date">02 Feb. 2013</td>
    </tr>
    <tr>
      <td><a href="#">Gifts</a></td>
      <td class="pad"><a href="#">Pad</a></td>
      <td class="hidden-text date">29 Jan. 2013</td>
    </tr>
    <tr>
      <td><a href="#">Calendar events</a></td>
      <td class="pad"><a href="#">Pad</a></td>
      <td class="hidden-text date">29 Jan. 2013</td>
    </tr>
    <tr>
      <td><a href="#">TV series</a></td>
      <td class="pad"><a href="#">Pad</a></td>
      <td class="hidden-text date">01 Dec. 2012</td>
    </tr>
    <tr>
      <td><a href="#">Daily post</a></td>
      <td class="pad"><a href="#">Pad</a></td>
      <td class="hidden-text date">28 Nov. 2012</td>
    </tr>
  </table>
  <a href="#" class="button">New note</a>
