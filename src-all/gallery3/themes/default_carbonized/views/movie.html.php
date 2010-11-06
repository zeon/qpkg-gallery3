<?php defined("SYSPATH") or die("No direct script access.") ?>
<div id="gItem">
  <?= $theme->photo_top() ?>

  <ul class="gPager">
    <li>
      <? if ($previous_item): ?>
      <a href="<?= $previous_item->url() ?>" class="gButtonLink ui-icon-left ui-state-default ui-corner-all">
      <span class="ui-icon ui-icon-triangle-1-w"></span><?= t("previous") ?></a>
      <? else: ?>
      <a class="gButtonLink ui-icon-left ui-state-disabled ui-corner-all">
      <span class="ui-icon ui-icon-triangle-1-w"></span><?= t("previous") ?></a>
      <? endif; ?>
    </li>
    <li class="gInfo"><?= t("%position of %total", array("position" => $position, "total" => $sibling_count)) ?></li>
    <li class="txtright">
      <? if ($next_item): ?>
      <a href="<?= $next_item->url() ?>" class="gButtonLink ui-icon-right ui-state-default ui-corner-all">
      <span class="ui-icon ui-icon-triangle-1-e"></span><?= t("next") ?></a>
      <? else: ?>
      <a class="gButtonLink ui-icon-right ui-state-disabled ui-corner-all">
      <span class="ui-icon ui-icon-triangle-1-e"></span><?= t("next") ?></a>
      <? endif ?>
    </li>
  </ul>


  <?= $item->movie_img(array("class" => "gMovie", "id" => "gMovieId-{$item->id}")) ?>

  <div id="gInfo">
    <h1><?= html::purify($item->title) ?></h1>
       <div><?= nl2br(html::purify($item->description)) ?></div>
  </div>

  <?= $theme->photo_bottom() ?>
  <?= $theme->context_menu($item, "#gMovieId-{$item->id}") ?>
</div>
