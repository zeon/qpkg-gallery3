<?php defined("SYSPATH") or die("No direct script access.") ?>
<ul id="gLoginMenu">
  <? if ($user->guest): ?>
  <li class="first">
    <a href="<?= url::site("login/ajax") ?>"
       title="<?= t("Login to Gallery") ?>"
       id="gLoginLink"><?= t("Login") ?></a>
  </li>
  <? else: ?>
  <li>
    <a href="<?= url::site("logout?csrf=$csrf&continue=" . url::current(true)) ?>"
       id="gLogoutLink"><?= t("Logout") ?></a>
  </li>
  <? endif ?>
</ul>
