<?php defined("SYSPATH") or die("No direct script access.") ?>
<div id="g-search-results">
  <h1><?= t("Search Results for \"%term\"", array("term" => $q)) ?> </h1>

  <? if (count($items)): ?>
<?= $theme->add_paginator("top"); ?>

  <ul id="g-album-grid">
    <? foreach ($items as $item): ?>
      <? $item_class = $item->is_album() ? "g-album" : "g-photo" ?>
    <li class="g-item <?= $item_class ?>">
      <p class="g-thumbcrop"><a href="<?= $item->url() ?>"><?= $item->thumb_img() ?></a></p>
      <h2><a href="<?= $item->url() ?>"><?= html::purify(text::limit_chars($item->title, 32, "…")) ?></a></h2>
    </li>
    <? endforeach ?>
  </ul>
<?= $theme->add_paginator("bottom"); ?>

  <? else: ?>
  <p>&nbsp;</p>
  <p><?= t("No results found for <b>%term</b>", array("term" => $q)) ?></p>

  <? endif; ?>
</div>