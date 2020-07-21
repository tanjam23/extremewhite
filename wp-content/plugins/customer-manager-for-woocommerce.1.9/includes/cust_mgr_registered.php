<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
	<form action="" method="post">
				
		<div>
		
			<br/>	
			
			<?php wp_nonce_field( 'phoe_woo_cust_manager_registered_form_action', 'phoe_woo_cust_manager_registered_form_nonce_field' ); 

			
			$user_detail_reg=array();
				
			$argsm    = array('posts_per_page' => -1, 'post_type' => 'shop_order','post_status'=>array_keys(wc_get_order_statuses()));
							
			$products_order = get_posts( $argsm ); 
					
			$user_id=array();
			
			$user_guest=array();
			
			$order_count='0';
			
			for($i=0;$i<count($products_order);$i++)  	{	
			
				$products_detail=get_post_meta($products_order[$i]->ID);  // order user_id, amount, 
						
				if($products_detail['_customer_user'][0]!=0)
				{
				if(!in_array($products_detail['_customer_user'][0], $user_id, true)){
						
					array_push($user_id, $products_detail['_customer_user'][0]);
				}
				}
				else{
					
					
				array_push($user_guest, $products_detail['_customer_user'][0]);	
					
				}
								
			}	
		
				
			for($i=0;$i<count($user_id);$i++)  {
					
				$user_detail=get_user_by('ID',$user_id[$i]); //nicename, user email
				
				$fname=get_user_meta($user_id[$i]);   // first name and last name
				 
				$order_count='0'; 
				
				$order_total='0';
				
				$date="";
					
				$order_num='';
				
				for($iq=0;$iq<count($products_order);$iq++)  {	
				
					$products_detail=get_post_meta($products_order[$iq]->ID);  // order user_id, amount, 
					
					if($user_id[$i]==$products_detail['_customer_user'][0]) 	{
						
						
						 
						 if(($products_order[$iq]->post_status=='wc-completed')||(($products_order[$iq]->post_status=='wc-processing') )) 		 {
							 
							  $order_count++;
								
							$order_total+=$products_detail['_order_total'][0];
							
							$date=		$products_order[$iq]->post_date	;
							
							$order_num=$products_order[$iq]->ID;

							}
						 
						 
					} 
						
					
				}
				$f_name=isset($fname['first_name'][0])?$fname['first_name'][0]:'';
				$l_name=isset($fname['last_name'][0])?$fname['last_name'][0]:'';
					
				 $name=$f_name." ".$l_name;
				$user_detail_reg[$i]=array(

					'id'=>$user_id[$i],
					
					'name'=>$name,
					
					'username'=>isset($user_detail->user_nicename)?$user_detail->user_nicename:'',
					
					'email'=>isset($user_detail->user_email)?$user_detail->user_email:'',
					
					'location'=>isset($fname['billing_state'][0])?$fname['billing_state'][0]:''." ".isset($fname['billing_country'][0])?$fname['billing_country'][0]:'' ,
					
					'orders'=>$order_count,
					
					'money_spent'=>$order_total,
					
					'date'=>$date,
					
					'order_num'=>$order_num
				);

				$order_count='0';
				
				$order_total='0';			
				
				$date='';		
									
				
			} 
			
			if(isset($_POST['name_desc'])) {
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['name'];
				}
				array_multisort($vc_array_name, SORT_DESC, $user_detail_reg);

			}
				
			if(isset($_POST['name_asc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['name'];
				}
				array_multisort($vc_array_name, SORT_ASC, $user_detail_reg);
			}
				
			
			if(isset($_POST['uname_desc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['username'];
				}
				array_multisort($vc_array_name, SORT_DESC, $user_detail_reg);

			}
				
			if(isset($_POST['uname_asc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['username'];
				}
				array_multisort($vc_array_name, SORT_ASC, $user_detail_reg);
			}
			
			
			if(isset($_POST['email_desc'])){
			
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['email'];
				}
				array_multisort($vc_array_name, SORT_DESC, $user_detail_reg);

			}
				
			if(isset($_POST['email_asc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['email'];
				}
				array_multisort($vc_array_name, SORT_ASC, $user_detail_reg);
			}
			
			
			
			if(isset($_POST['loc_desc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['location'];
				}
				array_multisort($vc_array_name, SORT_DESC, $user_detail_reg);

			}
				
			if(isset($_POST['loc_asc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['location'];
				}
				array_multisort($vc_array_name, SORT_ASC, $user_detail_reg);
			}
			
			
			if(isset($_POST['order_desc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['orders'];
				}
				array_multisort($vc_array_name, SORT_DESC, $user_detail_reg);

			}
				
			if(isset($_POST['order_asc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['orders'];
				}
				array_multisort($vc_array_name, SORT_ASC, $user_detail_reg);
			}
			
			if(isset($_POST['spent_desc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['money_spent'];
				}
				array_multisort($vc_array_name, SORT_DESC, $user_detail_reg);

			}
				
			if(isset($_POST['spent_asc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['money_spent'];
				}
				array_multisort($vc_array_name, SORT_ASC, $user_detail_reg);
			}
			
			if(isset($_POST['lorder_desc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['date'];
				}
				array_multisort($vc_array_name, SORT_DESC, $user_detail_reg);

			}
				
			if(isset($_POST['lorder_asc'])){
				
				foreach ($user_detail_reg as $key => $row){
					
					$vc_array_name[$key] = $row['date'];
				}
				array_multisort($vc_array_name, SORT_ASC, $user_detail_reg);
			}
			
			
			?>
					
		
			<table class="wp-list-table widefat fixed striped customers">
				
				<thead>
					
					<tr class="phoeniixx_woo_cust_manager_tr">
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
			
						<th id="orders" class="manage-column column-orders" scope="col"><span><?php _e('Orders','Phoeniixx_Customer_Manager'); ?></span>
							
							<button  name="order_desc" class="order_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="order_asc" class="order_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>
						
						</th>
			
						<th id="spent" class="manage-column column-spent" scope="col"><span><?php _e('Money Spent','Phoeniixx_Customer_Manager'); ?></span>
							
							<button  name="spent_desc" class="spent_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="spent_asc" class="spent_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>
						
						</th>
			
						<th id="last_order" class="manage-column column-last_order" scope="col"><span><?php _e('Last order','Phoeniixx_Customer_Manager'); ?></span>
							
							<button  name="lorder_desc" class="lorder_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button name="lorder_asc" class="lorder_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>
						</th>
			
						<th id="user_actions" class="manage-column column-user_actions" scope="col">
						
							<span><?php _e('Actions','Phoeniixx_Customer_Manager'); ?></span>
						
						</th>
						
					</tr>
					
				</thead>	
				
				<tbody>	
			
					<?php
							
					for($iq=0;$iq<count($user_detail_reg);$iq++)  {	
					?>

						<tr>
						<td class="customer_name column-customer_name has-row-actions column-primary" data-colname="Name (Last, First)"><?php echo $user_detail_reg[$iq]['name']; ?></td>
						<td class="username column-username" data-colname="Username"><?php echo $user_detail_reg[$iq]['username']; ?></td>
						<td class="email column-email" data-colname="Email"><?php echo $user_detail_reg[$iq]['email']; ?></td>
						<td class="location column-location" data-colname="Location"><?php echo $user_detail_reg[$iq]['location']; ?></td>
						<td class="orders column-orders" data-colname="Orders"><?php echo $user_detail_reg[$iq]['orders']; ?></td>
						<td class="spent column-spent" data-colname="Money Spent"><?php echo $user_detail_reg[$iq]['money_spent']; ?></td>
						<td class="last_order column-last_order" data-colname="Last order"><?php echo $user_detail_reg[$iq]['date']; ?>-<a href="<?php echo admin_url(); ?>post.php?post=<?php echo $user_detail_reg[$iq]['order_num']; ?>&action=edit"><?php echo $user_detail_reg[$iq]['order_num']; ?></a></td>
						<td class="user_actions column-user_actions" data-colname="Actions"><a class="button tips edit" href="<?php echo admin_url(); ?>user-edit.php?user_id=<?php echo $user_detail_reg[$iq]['id']; ?>"></a>&nbsp;<a class="button tips view" href="<?php echo admin_url(); ?>edit.php?post_type=shop_order&_customer_user=<?php echo $user_detail_reg[$iq]['id']; ?>"></a></td>
						</tr>

					<?php } ?>

				</tbody>


				<tfoot>
				
					<tr class="phoeniixx_woo_cust_manager_tr">
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
			
						<th id="orders" class="manage-column column-orders" scope="col"><span><?php _e('Orders','Phoeniixx_Customer_Manager'); ?></span>
							
							<button  name="order_desc" class="order_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="order_asc" class="order_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>
						
						</th>
			
						<th id="spent" class="manage-column column-spent" scope="col"><span><?php _e('Money Spent','Phoeniixx_Customer_Manager'); ?></span>
							
							<button  name="spent_desc" class="spent_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="spent_asc" class="spent_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>
						
						</th>
			
						<th id="last_order" class="manage-column column-last_order" scope="col"><span><?php _e('Last order','Phoeniixx_Customer_Manager'); ?></span>
							
							<button  name="lorder_desc" class="lorder_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button name="lorder_asc" class="lorder_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>
						</th>
			
						<th id="user_actions" class="manage-column column-user_actions" scope="col">
						
							<span><?php _e('Actions','Phoeniixx_Customer_Manager'); ?></span>
						
						</th>
						
					</tr>
					
				</tfoot>
		
			</table>

		</div>
	
	</form>