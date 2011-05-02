<?php defined("SYSPATH") or die("No direct script access.") ?>
<?
  $view = new View("admin_include.html");

  $view->admin_link_support  = "http://gallery.menalto.com/node/94713";
  $view->admin_link_download = "http://codex.gallery2.org/Gallery3:Themes:greydragon_w";
  $view->admin_link_vote     = "http://gallery.menalto.com/gallery/g3demosites/";
  $view->name = $name;
  $view->version = $version;
  $view->form = $form;
  $view->help = $help;                        
  print $view;
?>   

