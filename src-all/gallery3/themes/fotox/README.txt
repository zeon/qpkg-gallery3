This is a theme for gallery3 based on the three-nids theme (thanks man).
It uses jquery lightbox slideshow (fancybox) to display images.

*********
Demo : install it and you'll see

*********
Requirements:
- Gallery 3 last experimental version @ http://github.com/gallery/gallery3
- Tag and tagsmap modules activated (optional)

*********
Installation:

1. Copy the theme folder (fotox) into gallery3/themes directory.
2. Copy the tagsmap module into the gallery3/modules folder.
3. Activate tagsmap module and fotox theme.

*********
Configuration:
Go to Admin -> Appearance -> Theme Options to configure the theme properly.

*********
Use:
This theme displays full size images. So be carefull to upload not too large images!
The theme optionally uses the tagsmap module.

For advanced users:
If you want to separate geotag from others, name those with the "map." prefix., the "map." prefix will not be displayed on the map.
If you want to remove the prefix in the tag cloud sidebar, wou will have to update in gallery3/modules/tag/helpers/tag.php the popular_tags function:
  static function popular_tags($count) {
    return ORM::factory("tag")
      ->orderby("count", "DESC")
      ->notregex("name","map\.")
      ->limit($count)
      ->find_all();
  }
  
If you want to use your own logo in your gallery :
Go to your "gallery3" folder -> lib -> image and change the logo.png by our own
I put on in the "extra" folder
