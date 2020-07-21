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
	
	var newurl = window.location.protocol + "//" + window.location.host+'/wp-admin/post.php?post='+val+'&action=edit';
	
	window.location.href = newurl;
	}
});

});