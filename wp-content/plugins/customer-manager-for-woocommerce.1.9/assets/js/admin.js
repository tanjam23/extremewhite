
jQuery(document).ready(function(){
	
	 jQuery('.phoen_select_order_num').select2();
	  jQuery( document.body ).on( "click", function() {
       jQuery('.phoen_select_order_num').select2(); 
     });
	 
jQuery('.phoen_select_order_num').change(function()
{
	var val=jQuery(this).val();
	if(val!=="select")
	{
	// var ajaxurl='<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>'; // shop page url
	var newurl = window.location.protocol + "//" + window.location.host+'/wp-admin/post.php?post='+val+'&action=edit';
	//var url_new='<?php echo admin_url(); ?>'+'post.php?post='+val+'&action=edit';
	//console.log(url_new);
	//console.log(newurl);
	window.location.href = newurl;
	}
});

/* 
jQuery('.name_desc').click(function(){
	jQuery(this).hide();
	jQuery('.name_asc').show();
});

jQuery('.name_asc').click(function(){
	jQuery(this).hide();
	jQuery('.name_desc').show();
});


jQuery('.uname_desc').click(function(){
	jQuery(this).hide();
	jQuery('.uname_asc').show();
});

jQuery('.uname_asc').click(function(){
	jQuery(this).hide();
	jQuery('.uname_desc').show();
});



jQuery('.loc_desc').click(function(){
	jQuery(this).hide();
	jQuery('.loc_asc').show();
});

jQuery('.loc_asc').click(function(){
	jQuery(this).hide();
	jQuery('.loc_desc').show();
});


jQuery('.email_desc').click(function(){
	jQuery(this).hide();
	jQuery('.email_asc').show();
});

jQuery('.email_asc').click(function(){
	jQuery(this).hide();
	jQuery('.email_desc').show();
});


jQuery('.order_desc').click(function(){
	jQuery(this).hide();
	jQuery('.order_asc').show();
});

jQuery('.order_asc').click(function(){
	jQuery(this).hide();
	jQuery('.order_desc').show();
});

jQuery('.lorder_desc').click(function(){
	jQuery(this).hide();
	jQuery('.lorder_asc').show();
});

jQuery('.lorder_asc').click(function(){
	jQuery(this).hide();
	jQuery('.lorder_desc').show();
});


jQuery('.spent_desc').click(function(){
	jQuery(this).hide();
	jQuery('.spent_asc').show();
});

jQuery('.spent_asc').click(function(){
	jQuery(this).hide();
	jQuery('.spent_desc').show();
});
 */
});