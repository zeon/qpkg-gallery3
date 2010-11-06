<?php defined("SYSPATH") or die("No direct script access.") ?>

<ul class="gPager">
  <li class="gPagerText">
    <?php
      if ($total_pages > 1) {
        $pageItems = t("Pages") . ": ";
        for ($i = 1; $i <= $total_pages; $i++) {
          if ($i == $current_page)
          {
            $pageItems .= "<span>$i</span>";
          }
          else {
            $pageItems .= "<a href = \"" . str_replace('{page}', $i, $url) . "\">" . $i . "</a>";
          }
        }
        echo $pageItems;
      }
    ?>
  </li>
  <li class="gPagerArrows">
    <? if ($first_page): ?>
      <a href="<?= str_replace('{page}', 1, $url) ?>" class="gButtonLink">
        <img src="<?= $theme->url("images/ico-first.png") ?>">
      </a>
    <? else: ?>
      <a class="gButtonLink">
        <img src="<?= $theme->url("images/ico-first-disabled.png") ?>">
      </a>
    <? endif ?>
    <? if ($previous_page): ?>
      <a href="<?= str_replace('{page}', $previous_page, $url) ?>" class="gButtonLink">
        <img src="<?= $theme->url("images/ico-prev.png") ?>">
      </a>
    <? else: ?>
      <a class="gButtonLink">
        <img src="<?= $theme->url("images/ico-prev-disabled.png") ?>">
      </a>
    <? endif ?>
    <? if ($next_page): ?>
      <a href="<?= str_replace('{page}', $next_page, $url) ?>" class="gButtonLink">
        <img src="<?= $theme->url("images/ico-next.png") ?>">
      </a>
    <? else: ?>
      <a class="gButtonLink">
        <img src="<?= $theme->url("images/ico-next-disabled.png") ?>">
      </a>
    <? endif ?>
    <? if ($last_page): ?>
      <a href="<?= str_replace('{page}', $last_page, $url) ?>" class="gButtonLink">
        <img src="<?= $theme->url("images/ico-last.png") ?>">
      </a>
    <? else: ?>
      <a class="gButtonLink">
        <img src="<?= $theme->url("images/ico-last-disabled.png") ?>">
      </a>
    <? endif ?>
  </li>
</ul>
