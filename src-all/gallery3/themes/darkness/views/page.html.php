<?php defined("SYSPATH") or die("No direct script access.") ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>
      <? if ($page_title): ?>
        <?= $page_title ?>
      <? else: ?>
        <? $title = module::get_var("gallery", "header_text") ?>
        <? if ($title): ?>
          <?= t(html::clean($title)) ?>
        <? else: ?>
          <?= t("Gallery") ?>
        <? endif ?>
      <? endif ?>
    </title>
    <link rel="shortcut icon" href="<?= $theme->url("images/favicon.ico") ?>" type="image/x-icon" />
    <?= $theme->css("yui/reset-fonts-grids.css") ?>
    <?= $theme->css("superfish/css/superfish.css") ?>
    <?= $theme->css("themeroller/ui.base.css") ?>
    <?= $theme->css("screen.css") ?>
    <!--[if lt IE 8]>
      <link rel="stylesheet" type="text/css" href="<?= $theme->url("css/fix-ie.css") ?>"
            media="screen,print,projection" />
    <![endif]-->
    <?= $theme->script("jquery.js") ?>
    <?= $theme->script("jquery.form.js") ?>
    <?= $theme->script("jquery-ui.js") ?>
    <?= $theme->script("gallery.common.js") ?>
    <? /* MSG_CANCEL is required by gallery.dialog.js */ ?>
    <script type="text/javascript">
      var MSG_CANCEL = <?= t('Cancel')->for_js() ?>;
      var THUMB_SIZE = <?= module::get_var("gallery", "thumb_size") ?>;
      var PROPERTIES_ICON = "<?= $theme->url("images-unused/toggle-expand.png") ?>";
    </script>
    <?= $theme->script("gallery.ajax.js") ?>
    <?= $theme->script("gallery.dialog.js") ?>
    <?= $theme->script("gallery.form.js") ?>
    <?= $theme->script("superfish/js/superfish.js") ?>
    <?= $theme->script("jquery.localscroll.js") ?>
    <?= $theme->script("ui.init.js") ?>

    <? /* These are page specific, but if we put them before $theme->head() they get combined */ ?>
    <? if ($theme->page_type == "photo"): ?>
      <?= $theme->script("jquery.scrollTo.js") ?>
      <?= $theme->script("gallery.show_full_size.js") ?>
    <? elseif ($theme->page_type == "movie"): ?>
      <?= $theme->script("flowplayer.js") ?>
    <? endif ?>

    <?= $theme->head() ?>
  </head>

  <body <?= $theme->body_attributes() ?>>
    <?= $theme->page_top() ?>
    <div id="gView">
      <?= $theme->site_status() ?>
      <div id="gHeader">
        <?= new View("header.html") ?>
      </div>
      <div id="gContentOuterBox">
        <div id="gContentInnerBox">
            <div id="gContent">
              <?= $theme->messages() ?>
              <?= $content ?>
            </div>
        </div>
      </div>
      <div id="gFooter">
        <?= new View("footer.html") ?>
      </div>
    </div>
    <?= $theme->page_bottom() ?>
  </body>
</html>

<?php
  /*********************************
   *  get_name
   ********************************/
  function get_name($item)
  {
    return html::purify($item->title ? $item->title : $item->name);
  }
  
  /*********************************
   *  get_owner
   ********************************/
  function get_owner($item)
  {
    if ($item->owner) {
      return $item->owner->url
                ? "<a href=\"" . $item->owner->url . "\" target=\"_blank\">" . $item->owner->display_name() . "</a>"
                : $item->owner->display_name();
    }
    else
    {
      return "";
    }
  }
?>
