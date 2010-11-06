<?php defined("SYSPATH") or die("No direct script access.") ?>

<div id="gHeaderTop">
  <a id="gHeaderLogo" href="<?= url::site("albums/1") ?>">
    <? $filename = $theme->url("images/logo.png", true); ?>
    <? $size = getimagesize($filename); ?>
    <img alt="<?= t("Go to the Gallery home") ?>" src="<?= $filename ?>" <?= $size[3] ?>/>
  </a>
  
  <a id="gHeaderTitle" href="<?= url::site("albums/1") ?>">
    <?= ($header_text = module::get_var("gallery", "header_text")) ? $header_text : "My Gallery" ?>
  </a>

  <?= $theme->header_top() ?>

</div>

<div id="gHeaderBottom">
  <? if (!empty($parents)): ?>
    <ul class="gBreadcrumbs">
      <? foreach ($parents as $parent): ?>
        <li>
          <a href="<?= url::site("albums/{$parent->id}?show=$item->id") ?>">
            <?= html::purify($parent->title) ?>
          </a>
        </li>
      <? endforeach ?>
      <li><?= html::purify($item->title) ?></li>
    </ul>
  <? endif ?>
  
  <div id="gSiteMenu" style="display: none">
    <?= $theme->site_menu() ?>
  </div>

  <?= $theme->header_bottom() ?>
</div>
