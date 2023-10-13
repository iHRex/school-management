/**
 * Display thumb when set as featured.
 *
 * Overwritess built in function.
 */
function WPSetThumbnailID( id ) {
	tb_remove();
	jQuery.post( ajaxurl, {
		action: "nmi_added_thumbnail",
		thumbnail_id: id,
		post_id: window.clicked_item_id
	}, function( response ) {
		jQuery("li#menu-item-"+window.clicked_item_id+" .nmi-current-image").html( response );
		tb_remove();
	}
	);
};

function WPSetThumbnailHTML( html ) {
};

jQuery( document ).ready( function( $ ) {
	// Get all menu items
	var items = $("ul#menu-to-edit li.menu-item");

	// Go through all items and display link & thumb
	for ( var i = 0; i < items.length; i++ ) {
		var id = $(items[i]).children("#nmi_item_id").val();

		var sibling   = $("#edit-menu-item-attr-title-"+id).parent().parent();
		var image_div = $("li#menu-item-"+id+" .nmi-current-image");
		var link_div  = $("li#menu-item-"+id+" .nmi-upload-link");

		if ( image_div ) {
			sibling.after( image_div );
			image_div.show();
		}
		if ( link_div ) {
			sibling.after( link_div );
			link_div.show();
		}
	}

	// Save item ID on click on a link
	$(".nmi-upload-link").click( function() {
		window.clicked_item_id = $(this).parent().parent().children("#nmi_item_id").val();
	} );

	// Display alert when not added as featured
	window.send_to_editor = function( html ) {
		alert(nmi_vars.alert);
		tb_remove();
	};
} );