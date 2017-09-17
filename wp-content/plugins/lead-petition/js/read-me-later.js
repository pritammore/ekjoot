jQuery(document).ready( function(){	
	jQuery('#lp_content').on('click', 'a.lp_bttn', function(e) { 
		e.preventDefault();
		jQuery(this).addClass('loading disabled');
		var lp_post_id = jQuery(this).data( 'id' );
		jQuery.ajax({
			url : lp_obj.ajax_url,
			type : 'post',
			data : {
				action : 'read_me_later',
				security : lp_obj.check_nonce,
				post_id : lp_post_id
			},
			success : function( response ) {
				jQuery(this).removeClass('loading disabled');
				jQuery("#lp_content").html('<a href="#" class="ui large danger fluid button disabled"><i class="warning icon"></i>Request for Approval is send</a>');
			}
		});
	});	
	
});