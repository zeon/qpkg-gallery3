<?
class Theme_View extends Theme_View_Core {

  protected $photonav_position;
  protected $sidebarvisible;
  protected $sidebarallowed;
  protected $logopath;
  protected $is_thumbdescription_visible = TRUE;
  protected $is_thumbmetadata_visible = TRUE;
  protected $is_blockheader_visible = TRUE;
  protected $mainmenu_position = "";
  protected $copyright = null;
  protected $show_guest_menu = FALSE;

  protected function ensurevalue($value, $default) {
    if ((!isset($value)) or ($value == "")):
      return $default;
    else:
      return $value;
    endif;
  }

  protected function ensureoptionsvalue($key, $default) {
    return ($this->ensurevalue(module::get_var("th_greydragon", $key), $default));
  }

  public function load_sessioninfo() {
    $this->sidebarvisible = $_REQUEST['sb'];
    if (empty($this->sidebarvisible)):
      if (isset($_COOKIE['gd_sidebar'])):
        $this->sidebarvisible = $_COOKIE['gd_sidebar'];
      else:
        $this->sidebarvisible = $this->ensureoptionsvalue("sidebar_visible", "right");
      endif;
    else:
      // Sidebar position is kept for 360 days
      setcookie("gd_sidebar", $this->sidebarvisible, time() + 31536000);
    endif;

    $this->sidebarallowed = $this->ensureoptionsvalue("sidebar_allowed", "any");
    $this->sidebarvisible = $this->ensurevalue($this->sidebarvisible, "right");

    if ($this->sidebarallowed == "none")  { $this->sidebarvisible = $this->ensureoptionsvalue("sidebar_visible", "right"); };
    if ($this->sidebarallowed == "right") { $this->sidebarvisible = "right"; }
    if ($this->sidebarallowed == "left")  { $this->sidebarvisible = "left"; }

    if ($this->item()):
      if ($this->ensureoptionsvalue("sidebar_albumonly", FALSE)):
        if (!$this->item()->is_album()):
          $this->sidebarallowed = "none"; 
          $this->sidebarvisible = "none";
        endif;
      endif;
    endif;

    $this->logopath = $this->ensureoptionsvalue("logo_path", url::file("lib/images/logo.png"));
    $this->show_guest_menu = $this->ensureoptionsvalue("show_guest_menu", FALSE);
    $this->is_thumbdescription_visible = (!$this->ensureoptionsvalue("hide_thumbdesc", FALSE));
    $this->is_thumbmetadata_visible = (!$this->ensureoptionsvalue("hide_thumbmeta", FALSE));
    $this->is_blockheader_visible = (!$this->ensureoptionsvalue("hide_blockheader", FALSE));
    $this->mainmenu_position = ($this->ensureoptionsvalue("mainmenu_position", "default"));
    $this->copyright = ($this->ensureoptionsvalue("copyright", null));
    $this->photonav_position = module::get_var("th_greydragon", "photonav_position", "top");
  }

  public function is_sidebarallowed($align) {
    return (($this->sidebarallowed == "any") or ($this->sidebarallowed == $align));
  }

  protected function sidebar_menu_item($type, $url, $caption, $css) {
    if (!$this->is_sidebarallowed($type)):
      return "";
    endif;

    $iscurrent = ($this->sidebarvisible == $type);
    $content_menu = '<li>'; 
    if (!$iscurrent):
      $content_menu .= '<a title="' . $caption . '" href="' . $url . '?sb=' . $type . '">';
    endif;
    $content_menu .= '<span class="g-viewthumb-' . $css . ' ';
    if ($iscurrent):
      $content_menu .= 'g-viewthumb-current';
    endif;
    $content_menu .= '">' . $caption . '</span>';
    if (!$iscurrent):
      $content_menu .= '</a>';
    endif;

    return $content_menu . '</li>';
  }

  public function sidebar_menu($url) {
    if ($this->sidebarallowed != "any"):
      return "";
    endif;

    $content_menu = ($this->sidebar_menu_item("left", $url, "Sidebar Left", "left"));
    $content_menu .= ($this->sidebar_menu_item("none", $url, "No Sidebar", "full"));
    $content_menu .= ($this->sidebar_menu_item("right", $url, "Sidebar Right", "right"));
    return '<ul id="g-viewformat">' . $content_menu . '</ul>';
  }

  public function add_paginator($position) {
    if (($this->photonav_position == "both") or ($this->photonav_position == $position)):
      return ($this->paginator());
    else:
      return "";
    endif;
  }

  // $mode: bit 1 - use mix mode ($mode in [1, 3]), bit 2 - strips bbcode ($mode in [2, 3])
  public function bb2html($text, $mode) {
    // Syntax Sample:
    // --------------
    // [img]http://elouai.com/images/star.gif[/img]
    // [url="http://elouai.com"]eLouai[/url]
    // [size="25"]HUGE[/size]
    // [color="red"]RED[/color]
    // [b]bold[/b]
    // [i]italic[/i]
    // [u]underline[/u]
    // [list][*]item[*]item[*]item[/list]
    // [code]value="123";[/code]
    // [quote]John said yadda yadda yadda[/quote]
  
    static $bbcode_mappings = array(
      "#\\[b\\](.*?)\\[/b\\]#" => "<strong>$1</strong>",
      "#\\[i\\](.*?)\\[/i\\]#" => "<em>$1</em>",
      "#\\[u\\](.*?)\\[/u\\]#" => "<u>$1</u>",
      "#\\[s\\](.*?)\\[/s\\]#" => "<strike>$1</strike>",
      "#\\[o\\](.*?)\\[/o\\]#" => "<overline>$1</overline>",
      "#\\[url\\](.*?)\[/url\\]#" => "<a href=\"$1\">$1</a>",
      "#\\[url=(.*?)\\](.*?)\[/url\\]#" => "<a href=\"$1\" target=\"_blank\">$2</a>",
      "#\\[mail=(.*?)\\](.*?)\[/mail\\]#" => "<a href=\"mailto:$1\" target=\"_blank\">$2</a>",
      "#\\[img\\](.*?)\\[/img\\]#" => "<img src=\"$1\" alt=\"\" />",
      "#\\[img=(.*?)\\](.*?)\[/img\\]#" => "<img src=\"$1\" alt=\"$2\" />",
      "#\\[quote\\](.*?)\\[/quote\\]#" => "<blockquote><p>$1</p></blockquote>",
      "#\\[code\\](.*?)\\[/code\\]#" => "<pre>$1</pre>",
      "#\\[size=([^\\[]*)\\]([^\\[]*)\\[/size\\]#" => "<span style=\"font-size: $1;\">$2</span>",
      "#\\[color=([^\\[]*)\\]([^\\[]*)\\[/color\\]#" => "<span style=\"color: $1;\">$2</span>",
      "#\\[class=([^\\[]*)\\]([^\\[]*)\\[/class\\]#" => "<span class=\"$1\">$2</span>",
      "#\\[center\\](.*?)\\[/center\\]#" => "<div style=\"text-align: center;\">$1</div>",
      "#\\[list\\](.*?)\\[/list\\]#" => "<ul>$1</ul>",
      "#\\[ul\\](.*?)\\[/ul\\]#" => "<ul>$1</ul>",
      "#\\[li\\](.*?)\\[/li\\]#" => "<li>$1</li>",
    );
  
    static $bbcode_strip = '|[[\/\!]*?[^\[\]]*?]|si'; 

    // Replace any html brackets with HTML Entities to prevent executing HTML or script 
    // Don't use strip_tags here because it breaks [url] search by replacing & with amp
    if (($mode == 1) or ($mode == 3))
    {
      $newtext = str_replace("&lt;", "<", $text); 
      $newtext = str_replace("&gt;", ">", $newtext); 
      $newtext = str_replace("&quot;", "\"", $newtext); 
    } else {
      $newtext = str_replace("<", "&lt;", $text); 
      $newtext = str_replace(">", "&gt;", $newtext); 
      $newtext = str_replace("&amp;quot;", "&quot;", $newtext); 
    }

    // Convert new line chars to html <br /> tags 
    $newtext = nl2br($newtext);  

    if (strpos($text, "[") !== false) {
      if (($mode == 2) or ($mode == 3)) {
        $newtext = preg_replace($bbcode_strip, '', $newtext);
      } else {
        $newtext = preg_replace(array_keys($bbcode_mappings), array_values($bbcode_mappings), $newtext);
      }
    }

    return stripslashes($newtext);  //stops slashing, useful when pulling from db
  }
}

?>