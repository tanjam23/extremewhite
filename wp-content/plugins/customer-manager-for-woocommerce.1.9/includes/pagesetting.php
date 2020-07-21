<?php if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! empty( $_POST ) && check_admin_referer( 'phoe_Customer_manager_form_action', 'phoe_phoe_Customer_manager_form_action_form_nonce_field'  ) ) {

	if(sanitize_text_field( $_POST['cust_submit'] ) == 'Save'){
		
		$enable_cust=sanitize_text_field($_POST['enable_cust']);
		
		
		
		$phoe_cust_manager_value = array(
		
		'enable_cust'=>$enable_cust,
		
	
		
		
		);
		
		update_option('phoe_cust_manager_value',$phoe_cust_manager_value);
		
	}
	
}


	$gen_settings = get_option('phoe_cust_manager_value');

	$enable_cust=isset($gen_settings['enable_cust'])?$gen_settings['enable_cust']:'';
			
		
 ?>

	<div id="phoe_Ajax_Product_Filter_profile-page" class="phoe_Ajax_Product_Filter_wrap ajax_setting">
	
		<div class="phoe_video_main">
			<h3>How to set up plugin</h3> 
			<iframe width="800" height="360"src="https://www.youtube.com/embed/GgO45--eXCo" allowfullscreen></iframe>
		</div>

		<form method="post" id="phoe_Ajax_Product_Filter_form" action="" >
		
			<?php wp_nonce_field( 'phoe_Customer_manager_form_action', 'phoe_phoe_Customer_manager_form_action_form_nonce_field' ); ?>
			
			<table class="form-table">
				
				<tbody>	
		
					<tr class="phoeniixx_phoe_Ajax_Product_Filter_wrap">
				
						<th>
						
							<label><?php _e('Enable Customer Manager','Phoeniixx_Customer_Manager'); ?> </label>
							
						</th>
						
						<td>
						
							<input type="checkbox"  name="enable_cust" id="enable_cust" value="1" <?php echo(isset($gen_settings['enable_cust']) && $gen_settings['enable_cust'] == '1')?'checked':'';?>>
							
						</td>
						
					</tr>
		
					
					<tr class="phoeniixx_phoe_Ajax_Product_Filter_wrap">
					
						<td colspan="2">
						
							<input type="submit" value="Save" name="cust_submit" id="submit" class="button button-primary">
						
						</td>
						
					</tr>
		
				</tbody>
				
			</table>
			
		</form>
		
	</div>
	
	<style>
	.phoe_video_main {
		padding: 20px;
		text-align: center;
	}
	
	.phoe_video_main h3 {
		color: #02c277;
		font-size: 28px;
		font-weight: bolder;
		margin: 20px 0;
		text-transform: capitalize
		display: inline-block;
	}
	</style>