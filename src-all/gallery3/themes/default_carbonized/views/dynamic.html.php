<?php defined("SYSPATH") or die("No direct script access.") ?>
<div id="gAlbumHeader">
  <div id="gAlbumHeaderButtons">
    <?= $theme->dynamic_top() ?>
  </div>
  <h1><?= html::clean($title) ?></h1>
</div>

<ul id="gAlbumGrid">
  <? foreach ($children as $i => $child): ?>
  <li class="gItem <?= $child->is_album() ? "gAlbum" : "" ?>">
    <?= $theme->thumb_top($child) ?>
    <a href="<?= $child->url() ?>">
      <img id="gPhotoId-<?= $child->id ?>" class="gThumbnail"
           alt="photo" src="<?= $child->thumb_url() ?>"
           width="<?= $child->thumb_width ?>"
           height="<?= $child->thumb_height ?>" />
    </a>
    <h2><?= html::purify($child->title) ?></h2>
    <?= $theme->thumb_bottom($child) ?>
    <ul class="gMetadata">
      <?= $theme->thumb_info($child) ?>
    </ul>
  </li>
  <? endforeach ?>
</ul>
<?= $theme->dynamic_bottom() ?>

<?= $theme->pager() ?>
