<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

	<form method="post" action="">

		<?php wp_nonce_field( 'phoe_woo_cust_manager_registered_zero_order_form_action', 'phoe_woo_cust_manager_registered_zero_order_form_nonce_field' ); 

		$user_detail_reg=array();
		
		$argsm    = array('posts_per_page' => -1, 'post_type' => 'shop_order','post_status'=>array_keys(wc_get_order_statuses()));
					
		$products_order = get_posts( $argsm ); 
		
		$user_id=array();
		
		$user_guest=array();
		
		$reg_user_detail=array();
		
		$order_count='0';
		
		for($i=0;$i<count($products_order);$i++)  	{	
		
			$products_detail=get_post_meta($products_order[$i]->ID);  // order user_id, amount, 
					
			if($products_detail['_customer_user'][0]!=0) 	{
			
				if(($products_order[$i]->post_status=='wc-completed')||(($products_order[$i]->post_status=='wc-processing'))) 		 {
				 
					if(!in_array($products_detail['_customer_user'][0], $user_id, true)){
					
						array_push($user_id, $products_detail['_customer_user'][0]);
					}
				}
			}
		}
		
		$user_detail=get_users();
		
		for($a=0;$a<count($user_detail);$a++) 	{
			
			$name=get_user_meta($user_detail[$a]->ID);
				
			if(!in_array($user_detail[$a]->ID,$user_id)) 	{
				
				$f_name=isset($name['first_name'][0])?$name['first_name'][0]:'';
				$l_name=isset($name['last_name'][0])?$name['last_name'][0]:'';
					
				 $mname=$f_name." ".$l_name;
				
				
								
				array_push($reg_user_detail,array(
				
						'id'=>isset($user_detail[$a]->ID)?$user_detail[$a]->ID:'',
						
						'name'=>$mname,
						
						'username'=>isset($user_detail[$a]->user_nicename)?$user_detail[$a]->user_nicename:'',
						
						'email'=>isset($user_detail[$a]->user_email)?$user_detail[$a]->user_email:'',
						
						'state'=>isset($name['billing_state'][0])?$name['billing_state'][0]:'',
						
						'country'=>isset($name['billing_country'][0])?$name['billing_country'][0]:'',
						
					)
				);
			}
		}  
		
		if ( ! empty( $_POST ) && check_admin_referer( 'phoe_woo_cust_manager_registered_zero_order_form_action', 'phoe_woo_cust_manager_registered_zero_order_form_nonce_field' ) ) {
			
			if(isset($_POST['name_desc'])) {
				
			
				foreach ($reg_user_detail as $key => $row){
					
					$vc_array_name[$key] = $row['name'];
				}
				array_multisort($vc_array_name, SORT_DESC, $reg_user_detail);

			}
			
			if(isset($_POST['name_asc'])){
				
			
				foreach ($reg_user_detail as $key => $row){
					
					$vc_array_name[$key] = $row['name'];
				}
				array_multisort($vc_array_name, SORT_ASC, $reg_user_detail);
			}
				
		
			if(isset($_POST['id_desc'])){
				
			
				foreach ($reg_user_detail as $key => $row){
					
					$vc_array_name[$key] = $row['id'];
				}
				array_multisort($vc_array_name, SORT_DESC, $reg_user_detail);

			}
			
			if(isset($_POST['id_asc'])){
				
			
				
				foreach ($reg_user_detail as $key => $row){
					
					$vc_array_name[$key] = $row['id'];
				}
				array_multisort($vc_array_name, SORT_ASC, $reg_user_detail);
			}
		
		
			if(isset($_POST['email_desc'])){
			
				foreach ($reg_user_detail as $key => $row){
					
					$vc_array_name[$key] = $row['email'];
				}
				array_multisort($vc_array_name, SORT_DESC, $reg_user_detail);

			}
			
			if(isset($_POST['email_asc'])){
				
			
				
				foreach ($reg_user_detail as $key => $row){
					
					$vc_array_name[$key] = $row['email'];
				}
				array_multisort($vc_array_name, SORT_ASC, $reg_user_detail);
			}
			
		
			if(isset($_POST['username_desc'])){
				
			
				foreach ($reg_user_detail as $key => $row){
					
					$vc_array_name[$key] = $row['username'];
				}
				array_multisort($vc_array_name, SORT_DESC, $reg_user_detail);

			}
			
			if(isset($_POST['userename_asc'])){
				
			
				
				foreach ($reg_user_detail as $key => $row){
					
					$vc_array_name[$key] = $row['username'];
				}
				array_multisort($vc_array_name, SORT_ASC, $reg_user_detail);
			}
		
			if(isset($_POST['loc_desc'])){
				
				foreach ($reg_user_detail as $key => $row){
					
					$vc_array_name[$key] = $row['state'];
				}
				array_multisort($vc_array_name, SORT_DESC, $reg_user_detail);

			}
			
			if(isset($_POST['loc_asc'])){
				
			
				
				foreach ($reg_user_detail as $key => $row){
					
					$vc_array_name[$key] = $row['state'];
				}
				array_multisort($vc_array_name, SORT_ASC, $reg_user_detail);
			}
		
		
		
		}	 ?>

		<div>
			<br/>
			
			<table class="wp-list-table widefat fixed striped customers">
				
				<thead>
					
					<tr class="phoeniixx_woo_cust_manager_tr">
						
						<th id="customer_name" class="manage-column column-customer_name column-primary" scope="col"><span><?php _e('ID','Phoeniixx_Customer_Manager'); ?></span>
						
							<button class="id_desc"  class="name_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="id_asc" class="name_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>

						</th>
						
						<th id="customer_name" class="manage-column column-customer_name column-primary" scope="col"><span><?php _e('Name (First Last)','Phoeniixx_Customer_Manager'); ?></span>
						
							<button class="name_desc"  class="name_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="name_asc" class="name_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>

						</th>
						
						<th id="username" class="manage-column column-username" scope="col"><span><?php _e('Username','Phoeniixx_Customer_Manager'); ?></span>
							
							<button  name="uname_desc" class="uname_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="uname_asc" class="uname_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>

						</th>

						<th id="email" class="manage-column column-email" scope="col"><span><?php _e('Email','Phoeniixx_Customer_Manager'); ?></span>

							<button  name="email_desc" class="email_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="email_asc" class="email_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>

						</th>

						<th id="location" class="manage-column column-location" scope="col"><span><?php _e('Location','Phoeniixx_Customer_Manager'); ?></span>

							<button  name="loc_desc" class="loc_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="loc_asc" class="loc_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>
						
						</th>

						<th id="user_actions" class="manage-column column-user_actions" scope="col">
						
							<span><?php _e('Actions','Phoeniixx_Customer_Manager'); ?></span>
						
						</th>
					
					</tr>

				</thead>


				<tbody id="the-list" data-wp-lists="list:customer">

			
					<?php 	
					
					for($a=0;$a<count($reg_user_detail);$a++) 	{
								
					?>

						<tr>
							<td class="customer_name column-customer_name has-row-actions column-primary" data-colname="ID"><?php  echo $reg_user_detail[$a]['id']; ?></td>
							
							<td class="customer_name column-customer_name has-row-actions column-primary" data-colname="Name (Last, First)"><?php  echo $reg_user_detail[$a]['name']; ?></td>
							
							<td class="username column-username" data-colname="Username"><?php  echo $reg_user_detail[$a]['username']; ?></td>
							
							<td class="email column-email" data-colname="Email"><?php  echo $reg_user_detail[$a]['email']; ?></td>
							
							<td class="location column-location" data-colname="Location"><?php  echo $reg_user_detail[$a]['state']; ?>  <?php  echo $reg_user_detail[$a]['country']; ?></td>
							
							<td class="user_actions column-user_actions" data-colname="Actions"><a class="button tips edit" href="<?php echo admin_url(); ?>user-edit.php?user_id=<?php echo $reg_user_detail[$a]['id']; ?>"></a></td>

						</tr>

					<?php  
					
					} ?>
				
				</tbody>

				<tfoot>
				
					
					<tr class="phoeniixx_woo_cust_manager_tr">
						
						<th id="customer_name" class="manage-column column-customer_name column-primary" scope="col"><span><?php _e('ID','Phoeniixx_Customer_Manager'); ?></span>
						
							<button class="id_desc"  class="name_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="id_asc" class="name_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>

						</th>
						
						<th id="customer_name" class="manage-column column-customer_name column-primary" scope="col"><span><?php _e('Name (First Last)','Phoeniixx_Customer_Manager'); ?></span>
						
							<button class="name_desc"  class="name_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="name_asc" class="name_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>

						</th>
						
						<th id="username" class="manage-column column-username" scope="col"><span><?php _e('Username','Phoeniixx_Customer_Manager'); ?></span>
							
							<button  name="uname_desc" class="uname_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="uname_asc" class="uname_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>

						</th>

						<th id="email" class="manage-column column-email" scope="col"><span><?php _e('Email','Phoeniixx_Customer_Manager'); ?></span>

							<button  name="email_desc" class="email_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="email_asc" class="email_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>

						</th>

						<th id="location" class="manage-column column-location" scope="col"><span><?php _e('Location','Phoeniixx_Customer_Manager'); ?></span>

							<button  name="loc_desc" class="loc_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="loc_asc" class="loc_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>
						
						</th>

						<th id="user_actions" class="manage-column column-user_actions" scope="col">
						
							<span><?php _e('Actions','Phoeniixx_Customer_Manager'); ?></span>
						
						</th>
					
					</tr>

				</tfoot>

			</table>

		</div>
	</form>