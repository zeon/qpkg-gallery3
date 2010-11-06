<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2010 Bharat Mediratta
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
class server_add_theme_Core {
  static function head($theme) {
    if (identity::active_user()->admin) {
      $theme->css("server_add.css");
      $theme->script("server_add.js");
    }
  }

  static function admin_head($theme) {
    $head = array();
    if (strpos(Router::$current_uri, "admin/server_add") !== false) {
      $theme->css("server_add.css");
      $theme->css("jquery.autocomplete.css");
      $base = url::site("__ARGS__");
      $csrf = access::csrf_token();
      $head[] = "<script type=\"text/javascript\"> var base_url = \"$base\"; var csrf = \"$csrf\";</script>";

      $theme->script("jquery.autocomplete.js");
      $theme->script("admin.js");
    }

    return implode("\n", $head);
  }
}