<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2009 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
class Admin_Theme_Options_Controller extends Admin_Controller {

  protected function load_theme_info() {
    $file = THEMEPATH . "greydragon_w/theme.info";
    $theme_info = new ArrayObject(parse_ini_file($file), ArrayObject::ARRAY_AS_PROPS);
    return $theme_info;
  }

  protected function get_theme_version() {
    $theme_info = $this->load_theme_info();
    return ($theme_info->version);
  }

  protected function get_theme_name() {
    $theme_info = $this->load_theme_info();
    return ($theme_info->name);
  }

  protected function get_edit_form_admin() {
    $form = new Forge("admin/theme_options/save/", "", null, array("id" =>"g-theme-options-form"));

    $sidebar_allowed = module::get_var("th_greydragon", "sidebar_allowed");
    $sidebar_visible = module::get_var("th_greydragon", "sidebar_visible");
    $group = $form->group("edit_theme")->label(t("General Settings"));
    $group->input("page_size")
      ->label(t("Items per page"))->id("g-page-size")
      ->rules("required|valid_digit")
      ->value(module::get_var("gallery", "page_size"));
    $group->input("thumb_size")
      ->label(t("Thumbnail size (in pixels)"))->id("g-thumb-size")
      ->rules("required|valid_digit")
      ->value(module::get_var("gallery", "thumb_size"));
    $group->input("resize_size")
      ->label(t("Resized Image Size (in pixels)"))->id("g-resize-size")
      ->rules("required|valid_digit")
      ->value(module::get_var("gallery", "resize_size"));
    $group->input("logo_path")
      ->label(t("URL or Path to Alternative Logo Image"))->id("g-site-logo")
      ->value(module::get_var("th_greydragon", "logo_path"));
    $group->input("header_text")
      ->label(t("Header Text (will Hide Gallery Logo)"))->id("g-header-text")
      ->value(module::get_var("gallery", "header_text"));
    $group->input("footer_text")
      ->label(t("Footer Text"))->id("g-footer-text")
      ->value(module::get_var("gallery", "footer_text"));
    $group->input("copyright")
      ->label(t("Copyright Message to Display in Footer"))->id("g-theme-copyright")
      ->value(module::get_var("th_greydragon", "copyright"));

    $group = $form->group("edit_theme_adv")->label(t("Advanced Options"));
    $group->checkbox("show_credits")
      ->label(t("Show Site Credits"))->id("g-footer-text")
      ->checked(module::get_var("gallery", "show_credits"));
    $group->dropdown("photonav_position")
      ->label(t("Photo Navigator Position"))
      ->options(array("top" => t("Top"), "bottom" => t("Bottom"), "both" => t("Both"), "none" => t("None")))
      ->selected(module::get_var("th_greydragon", "photonav_position"));

    $group = $form->group("maintenance")->label("Maintenance");
    $group->checkbox("build_resize")->label(t("Mark all Image Resizes for Rebuild"))->checked(false);
    $group->checkbox("build_thumbs")->label(t("Mark all Thumbnails for Rebuild (200x200)"))->checked(false);
    $group->checkbox("reset_theme")->label(t("Reset Theme to a Default State"))->checked(false);

    module::event("theme_edit_form", $form);

    $form->submit("g-theme-options-save")->value(t("Save Changes"));
    return $form;
  }

  protected function get_edit_form_help() {
    $help = '<fieldset>';
    $help .= '<legend>Help</legend><ul>';
    $help .= '<li><h3>General Settings</h3>
      <p>Theme is designed to display items (thumbnails) in fixed 3 <? //+sidebar or 4 columns format. ?>
      <p>Default G3 logo can be replaced with your own by providing <b>URL/Logo Path</b>.
      When no logo is needed providing <b>Header Text</b> will substitute it.  
      <b>Footer Text</b> would simply be placed in middle section of the footer.
      <p>To indicate your rights for the artwork displayed <b>Copyright Message</b> can be placed in
      right top corner of the footer.
      </li>';
    $help .= '<li><h3>Advanced Options</h3>
      <p><b>Show Site Credits</b> simply shows appreciation for hard work of G3 team and Theme\'s author
      (you could do this also with few cups of nice Kona coffee by clicking <b>Donate</b> link above).
      <p><b>Show Main Menu for Guest Users</b> allows Main menu being displayed
      even for Guest Users.
      </li>';
    $help .= '<li><h3>Maintenance</h3>
      <p>There are extra 3 maintenance options available:
      <p>Without changing image size, you can <b>Mark all Resizes for Rebuild</b>.
      Then you need to visit Admin\Maintenance to initiate the process.
      <p>Same can be done for image thumbs with <b>Mark all Thumbnails for Rebuild</b>.
      <p>And just in case you think that something is not right, you can 
      always <b>Reset Theme to a Default State</b>.
      </li>';
    $help .= '</ul></fieldset>';
    return $help;
  }

  protected function save_item_state($statename, $state, $value) {
    if ($state) {
      module::set_var("th_greydragon", $statename, $value);
    } else {
      module::clear_var("th_greydragon", $statename);
    }
  }

  public function save() {
    access::verify_csrf();

    $form = self::get_edit_form_admin();
    $help = self::get_edit_form_help();

    if ($form->validate()) {
      if ($form->maintenance->reset_theme->value) {
        module::set_var("gallery", "page_size", 9);
        module::set_var("gallery", "resize_size", 640);
        module::set_var("gallery", "thumb_size", 200);

        module::set_var("gallery", "header_text", "");
        module::set_var("gallery", "footer_text", "");
        module::clear_var("th_greydragon", "copyright");
        module::clear_var("th_greydragon", "logo_path");
        
        module::set_var("gallery", "show_credits", FALSE);
        module::clear_var("th_greydragon", "photonav_position");

        module::event("theme_edit_form_completed", $form);
        message::success(t("Theme details are reset"));
      } else {
        /* General Settings ****************************************************/

        $resize_size  = $form->edit_theme->resize_size->value;
        $thumb_size   = $form->edit_theme->thumb_size->value;
        $build_resize = $form->maintenance->build_resize->value;
        $build_thumbs = $form->maintenance->build_thumbs->value;

        if ($build_resize) {
          graphics::remove_rule("gallery", "resize", "gallery_graphics::resize");
          graphics::add_rule("gallery", "resize", "gallery_graphics::resize",
            array("width" => $resize_size, "height" => $resize_size, "master" => Image::AUTO), 100);
        }
        if (module::get_var("gallery", "resize_size") != $resize_size) {
          module::set_var("gallery", "resize_size", $resize_size);
        }

        if ($build_thumbs) {
          graphics::remove_rule("gallery", "thumb", "gallery_graphics::resize");
          graphics::add_rule("gallery", "thumb", "gallery_graphics::resize",
            array("width" => $thumb_size, "height" => $thumb_size, "master" => Image::AUTO), 100);
        }
        if (module::get_var("gallery", "thumb_size") != $thumb_size) {
          module::set_var("gallery", "thumb_size", $thumb_size);
        }
        module::set_var("gallery", "header_text", $form->edit_theme->header_text->value);
        module::set_var("gallery", "footer_text", $form->edit_theme->footer_text->value);
        $this->save_item_state("copyright", $form->edit_theme->copyright->value, $form->edit_theme->copyright->value);
        $this->save_item_state("logo_path", $form->edit_theme->logo_path->value, $form->edit_theme->logo_path->value);

        /* Advanced Options ****************************************************/

        module::set_var("gallery", "show_credits",  $form->edit_theme_adv->show_credits->value);
        $this->save_item_state("photonav_position", $form->edit_theme_adv->photonav_position->value != "top", $form->edit_theme_adv->photonav_position->value);

        module::set_var("gallery", "page_size", $form->edit_theme->page_size->value);

        module::event("theme_edit_form_completed", $form);
        message::success(t("Updated theme details"));
      }

      url::redirect("admin/theme_options");
    } else {
      $view = new Admin_View("admin.html");
      $view->content = $form;
      print $view;
    }
  }

  public function index() {
    $view = new Admin_View("admin.html");
    $view->content = new View("admin_theme_options.html");
    $view->content->version = self::get_theme_version();
    $view->content->form = self::get_edit_form_admin();
    $view->content->help = self::get_edit_form_help();
    $view->content->name = self::get_theme_name();
    print $view;
  }
}
