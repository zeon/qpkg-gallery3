<?php defined("SYSPATH") or die("No direct script access.") ?>

<?= $theme->footer() ?>

<? if ($footer_text = module::get_var("gallery", "footer_text")): ?>
  <div class="gFooterText">
	<?= $footer_text ?>
  </div>
<? endif ?>

<? if (module::get_var("gallery", "show_credits")): ?>
  <ul id="gCredits">
	<?= $theme->credits() ?>
  </ul>
<? endif ?>

<? if (!$user->guest): ?>
  <div class="gLoggedInAs">
	<?= t('Logged in as %name', array('name' => html::mark_clean(
	  '<a href="' . url::site("form/edit/users/{$user->id}") .
	  '" title="' . t("Edit Your Profile")->for_html_attr() .
	  '" id="gUserProfileLink" class="gDialogLink">' .
	  html::clean($user->display_name()) . '</a>'))) ?>
  </div>
<? endif ?>
