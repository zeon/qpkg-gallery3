<?php defined("SYSPATH") or die("No direct script access.") ?>

<? if (access::can("view_full", $theme->item())): ?>
  <!-- Use javascript to show the full size as an overlay on the current page -->
  <script>
    $(document).ready(function() {
      $(".gFullSizeLink").click(function() {
        show_full_size("<?= $theme->item()->file_url() ?>", "<?= $theme->item()->width ?>", "<?= $theme->item()->height ?>");
        return false;
      });
    });
  </script>
<? endif ?>

<div id="gItem">
  <?= $theme->photo_top() ?>

  <div id="gTitleBar">
    <ul class="gTitle">
      <li><h2><?= get_name($item) ?></h2></li>
      <li><?= nl2br(html::purify($item->description)) ?></li>
    </ul>
    <ul class="gDetails">
      <li> <?= $item->view_count . " " . (($item->view_count == 1) ? t("view") : t("views")) ?> </li>
      <li> <?= $item->width . " x " . $item->height ?> </li>
    </ul>
    <ul class="gDetails">
      <li> <?= get_owner($item) ?> </li>
      <li><?= date("M j, Y", $item->updated) ?></li>
    </ul>
  </div>

  <ul class="gPager">
    <li class="gPagerText"><?= t("Photo") . " $position " . t("of") . " " . $sibling_count ?></li>
    <li class="gPagerArrows">
      <? if ($previous_item): ?>
        <a href="<?= first_photo_url($item) ?>" class="gButtonLink">
          <img src="<?= $theme->url("images/ico-first.png") ?>" alt="<?= t("First photo") ?>">
        </a>
      <? else: ?>
        <a class="gButtonLink">
          <img src="<?= $theme->url("images/ico-first-disabled.png") ?>">
        </a>
      <? endif ?>
      <? if ($previous_item): ?>
        <a href="<?= $previous_item->url() ?>" class="gButtonLink">
          <img src="<?= $theme->url("images/ico-prev.png") ?>" alt="<?= t("Previous photo") ?>">
        </a>
      <? else: ?>
        <a class="gButtonLink">
          <img src="<?= $theme->url("images/ico-prev-disabled.png") ?>">
        </a>
      <? endif ?>
      <? if ($next_item): ?>
        <a href="<?= $next_item->url() ?>" class="gButtonLink" alt="<?= t("Next photo") ?>">
          <img src="<?= $theme->url("images/ico-next.png") ?>">
        </a>
      <? else: ?>
        <a class="gButtonLink">
          <img src="<?= $theme->url("images/ico-next-disabled.png") ?>">
        </a>
      <? endif ?>
      <? if ($next_item): ?>
        <a href="<?= last_photo_url($item) ?>" class="gButtonLink">
          <img src="<?= $theme->url("images/ico-last.png") ?>" alt="<?= t("Last photo") ?>">
        </a>
      <? else: ?>
        <a class="gButtonLink">
          <img src="<?= $theme->url("images/ico-last-disabled.png") ?>">
        </a>
      <? endif ?>
    </li>
  </ul>

  <div id="gPhoto">
    <?= $theme->resize_top($item) ?>
    <? if (access::can("view_full", $item)): ?>
      <a href="<?= $item->file_url() ?>" class="gFullSizeLink" title="<?= t("View full size") ?>">
    <? endif ?>
    <?= $item->resize_img(array("id" => "gPhotoId-{$item->id}", "class" => "gResize")) ?>
    <? if (access::can("view_full", $item)): ?>
      </a>
    <? endif ?>
    <?= $theme->resize_bottom($item) ?>
  </div>

  <script type="text/javascript">
    var ADD_A_COMMENT = "<?= t("Add a comment") ?>";
  </script>
  <!-- <?= $theme->photo_bottom() ?> -->
</div>

<?php
  function first_photo_url($photo) {
    $children = $photo->parent()->children(1, 0);
    return $children ? $children[0]->url() : "#";
  }

  function last_photo_url($photo) {
    $children = $photo->parent()->children(1, $photo->parent()->children_count() - 1);
    return $children ? $children[0]->url() : "#";
  }
?>