<?php defined("SYSPATH") or die("No direct script access.") ?>

<?= $theme->album_top() ?>

<div id="gTitleBar">
  <ul class="gTitle">
    <li><h2><?= html::purify($item->title) ?></h2></li>
    <li><?= nl2br(html::purify($item->description)) ?></li>
  </ul>
  <ul class="gDetails">
    <li> <?= $item->view_count . " " . (($item->view_count == 1) ? t("view") : t("views")) ?> </li>
    <li> <?= $children_count . " " . (($children_count == 1) ? t("item") : t("items")) ?> </li>
  </ul>
  <ul class="gDetails">
    <li><?= get_owner($item) ?></li>
    <li><?= date("M j, Y", $item->updated) ?></li>
  </ul>
</div>

<?= $theme->pager() ?>

<ul id="gAlbumGrid">
  <? if (count($children)): ?>
    <? foreach ($children as $i => $child): ?>
      <? $item_class = "gPhoto"; ?>
      <? if ($child->is_album()): ?>
        <? $item_class = "gAlbum"; ?>
      <? endif ?>
      
      <li class="gItem <?= $item_class ?>">
     
        <?= $theme->thumb_top($child) ?>
        
        <div class="gThumbImage">
          <a href="<?= $child->url() ?>">
            <? if ($child->has_thumb()): ?>
              <?= $child->thumb_img(array("class" => "gThumbnail")) ?>
            <? else: ?>
              <? $filename = $theme->url("images/missing.png", true); ?>
              <? $size = getimagesize($filename); ?>
              <img class="gThumbnail" src="<?= $filename ?>" <?= $size[3] ?>>
            <? endif ?>
          </a>
        </div>
       
        <div class="gThumbDetails">
          <ul class="gTitle">
            <li><h3><a href="<?= $child->url() ?>"><?= get_name($child) ?></a></h3></li>
          </ul>
          <ul class="gDetails">
            <li><?= get_owner($child) ?></li>
            <li><?= date("M j, Y", $child->updated) ?></li>
          </ul>
          <ul class="gDetails">
            <li><?= $child->view_count . " " . (($child->view_count == 1) ? t("view") : t("views")) ?></li>
            <li>
              <?php
              echo $child->is_album()
                      ? ($child->viewable()->children_count() . " " . t("items"))
                      : ($child->width . " x " . $child->height);
              ?>
            </li>
          </ul>
        </div>
  
        <?= $theme->thumb_bottom($child) ?>
        <?= $theme->context_menu($child, "#gItemId-{$child->id} .gThumbnail") ?>
      </li>
    <? endforeach ?>
    
  <? else: ?>
    <li id="gEmptyAlbum">
      <? if ($user->admin || access::can("add", $item)): ?>
        <? $addurl = url::file("index.php/simple_uploader/app/$item->id") ?>
        <?= t("There aren't any photos here yet! &nbsp;&nbsp;<b><a %attrs>Add some</a></b>.",
                  array("attrs" => html::mark_clean("href=\"$addurl\" class=\"gDialogLink\""))) ?>
      <? else: ?>
        <?= t("There aren't any photos here yet!") ?>
      <? endif ?>
    </li>
  <? endif ?>
</ul>

<?= $theme->album_bottom() ?>
