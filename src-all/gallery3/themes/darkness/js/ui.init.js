/**
 * Initialize jQuery UI and Plugin elements
 */

var shortForms = new Array(
  "#gQuickSearchForm",
  "#gAddTagForm",
  "#gSearchForm"
);

$(document).ready(function() {

  // Initialize Superfish menus
  $("ul.gMenu").addClass("sf-menu");
  $('ul.sf-menu').superfish({
    delay: 500,
    animation: {
      opacity:'show',
      height:'show'
    },
    speed: 'fast'
  });
  $("#gSiteMenu").css("display", "block");

  // Initialize status message effects
  $("#gMessage li").gallery_show_message();

  // Initialize dialogs
  $("#gLoginLink").addClass("gDialogLink");
  $(".gDialogLink").gallery_dialog();

  // Initialize view menu
  if ($("#gViewMenu").length) {
    $("#gViewMenu ul").removeClass("gMenu").removeClass("sf-menu");
    $("#gViewMenu a").addClass("ui-icon");
  }

  // Initialize short forms
  handleShortFormEvent(shortForms);
  $(".gShortForm input[type=text]").addClass("ui-corner-left");
  $(".gShortForm input[type=submit]").addClass("ui-state-default ui-corner-right");

  // Apply jQuery UI button css to submit inputs
  $("input[type=submit]:not(.gShortForm input)").addClass("ui-state-default ui-corner-all");

  // Apply styles and icon classes to gContextMenu
  if ($(".gContextMenu").length) {
    $(".gContextMenu").width(THUMB_SIZE);
    $(".gContextMenu > li > a").html("&nbsp;<img src=\"" + PROPERTIES_ICON + "\"> Operations");
    $(".gContextMenu li").addClass("ui-state-default");
    $(".gContextMenu ul li a").addClass("gButtonLink ui-icon-left");
    $(".gContextMenu ul li a").prepend("<span class=\"ui-icon\"></span>");
    $(".gContextMenu ul li a span").each(function() {
      var iconClass = $(this).parent().attr("class").match(/ui-icon-.[^\s]+/).toString();
      $(this).addClass(iconClass);
    });
  }

  // Organize things in the header
  $('#gQuickSearchForm').insertAfter('#gHeaderTitle');
  $('#gLoginMenu').insertBefore('#gSiteMenu');
  var h = $("#gHeaderTop").height();
  var hl = $("#gHeaderLogo").height();
  var ht = $("#gHeaderTitle").height();
  var hs = $("#gQuickSearchForm").height();
  $("#gHeaderTop").height(Math.max(Math.max(hl, h), 40));
  h = $("#gHeaderTop").height();
  $("#gHeaderLogo").css("position", "relative").css("top", (h - hl) / 2);
  $("#gHeaderTitle").css("position", "relative").css("top", (h - ht) / 2);
  $("#gQuickSearchForm").css("position", "relative").css("top", (h - hs) / 2);

  // Album view only
  if ($("#gAlbumGrid").length) {
	
    // Make all thumbnails the width of the widest thumbnail
	var maxItemWidth = 0;
	var gItem = $(".gItem");
	gItem.each(function(index, o) {
	  oo = $(o);
	  if (oo.width() > maxItemWidth) {
		maxItemWidth = (oo.width() <= THUMB_SIZE) ? oo.width() : THUMB_SIZE;
	  }
	})
	.each(function(index, o) {
	  $(o).width(maxItemWidth);
	});

	// Make the image containers within each row the same height
	// Center all the images within their containers
	var top = -1;
	var maxItemHeight = 0;
	var maxImageHeight = 0;
	gItem.each(function(index, o) {
	  var oo = $(o);
	  ooTop = oo.position().top;
	  if (ooTop != top) {
		if (top != -1) {
		  adjustRowThumbnails(gItem, top, maxImageHeight, maxItemWidth, maxItemHeight);
		}
		top = oo.position().top;
		maxImageHeight = 0;
	  }
	  if (oo.height() > maxItemHeight) {
		maxItemHeight = oo.height();
	  }
	  var h = $(oo.find(".gThumbImage")[0]).height();
	  if (h > maxImageHeight) {
		maxImageHeight = h;
	  }
	})
	if (top != -1) {
	  adjustRowThumbnails(gItem, top, maxImageHeight, maxItemWidth, maxItemHeight);
	}

    // Initialize context menus
    $(".gItem").hover(
      function(){
        $(this).addClass("gHoverItem");
        $(this).gallery_context_menu();
      },
      function() {
        $(this).removeClass("gHoverItem");
      }
    );
  }

  // Photo/Item item view only
  if ($("#gItem").length) {
    // Ensure the resized image fits within its container
    $("#gItem").gallery_fit_photo();

    // Initialize context menus
    var resize = $("#gItem").gallery_get_photo();
    $(resize).hover(function(){
      $(this).gallery_context_menu();
    });

    // Add scroll effect for links to named anchors
    $.localScroll({
      queue: true,
      duration: 1000,
      hash: true
    });
  }

  // Initialize button hover effect
  $.fn.gallery_hover_init();
});

/**
 * Adjusts the thumbnails in a row to make them uniformly sized and centered
 */
function adjustRowThumbnails(gItem, top, maxImageHeight, maxItemWidth, maxItemHeight) {
  gItem.filter(function () {
		  return $(this).position().top == top;
		})
	.each(function(index, o) {
	  $(o).height(maxItemHeight);
	})
	.find(".gThumbImage")
	.each(function(index, o) {
	  var oo = $(o);
	  var image = oo.find(".gThumbnail");
	  var h = oo.height();
	  var w = image.width();
	  image.css("position", "relative").css("top", (maxImageHeight - h) / 2).css("left", (maxItemWidth - w) / 2);
	  oo.height(maxImageHeight);
	});
}
