<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

	<form action="" method="post">
		
		<?php wp_nonce_field( 'phoe_woo_cust_manager_guest_form_action', 'phoe_woo_cust_manager_guest_form_nonce_field' ); 

		$argsm    = array('posts_per_page' => -1, 'post_type' => 'shop_order','post_status'=>array_keys(wc_get_order_statuses()));
				
		$products_order = get_posts( $argsm ); 
		
		$customer_guest_detail=array();
		
		$user_email=array();
		
		$user_guest=array();
		
		$order_total='';
		
		$order_count=0;		
		
		$name='';
		
		$date='';
		
		$add_state='';
		
		$add_country='';
		
		$order_num=array();
		
		for($i=0;$i<count($products_order);$i++)  	{	
		
			$products_detail=get_post_meta($products_order[$i]->ID);  // order user_id, amount, 
				
			if($products_detail['_customer_user'][0]==0)  		{
			
				if(!in_array($products_detail['_billing_email'][0], $user_email, true)) {
					
					array_push($user_email, $products_detail['_billing_email'][0]);
				}
			}

		}
			
		for($i=0;$i<count($user_email);$i++)  	{
				
			for($ii=0;$ii<count($products_order);$ii++)  	{	
					
				$products_detail=get_post_meta($products_order[$ii]->ID);
					
				if($user_email[$i]==$products_detail['_billing_email'][0]) {
						
					$date=$products_order[$ii]->post_date;
					
					$f_name=isset($products_detail['_billing_first_name'][0])?$products_detail['_billing_first_name'][0]:'';
				
					$l_name=isset($products_detail['_billing_last_name'][0])?$products_detail['_billing_last_name'][0]:'';
					
				
					
					array_push($order_num, $products_order[$ii]->ID);
					
					$name=$f_name." ".$l_name;
					
					$add_state=isset($products_detail['_billing_state'][0])?$products_detail['_billing_state'][0]:'';
					
					$add_country=isset($products_detail['_billing_country'][0])?$products_detail['_billing_country'][0]:'';
						
					
					
					if(($products_order[$ii]->post_status=='wc-completed')||($products_order[$ii]->post_status=='wc-processing'))  {
			 
						$order_count++;
						
						$order_total+=isset($products_detail['_order_total'][0])?$products_detail['_order_total'][0]:'';
					 
					}
		
				} 
					
			}
	

			$customer_guest_detail[$i]=array(

				'name'=>$name,
				
				'email'=>$user_email[$i],
				
				'order_count'=>$order_count,
				
				'order_total'=>$order_total,
				
				'order_num'=>$order_num,
				
				'state'=>$add_state,
				
				'country'=>$add_country
				


			);
			$order_total=0; 
			
			$order_count=0;	
			
			$order_num=array();
		}   ?>
				

		<div>
		
			<br/>

			<table class="wp-list-table widefat fixed striped customers">
				
				<thead>

					<tr class="phoeniixx_woo_cust_manager_tr">
					
						<th id="customer_name" class="manage-column column-customer_name column-primary" scope="col"><span><?php _e('Name (First Last)','Phoeniixx_Customer_Manager'); ?></span>
							
							<button class="name_desc"  class="name_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="name_asc" class="name_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>
						
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
						
						<th id="last_order" class="manage-column column-last_order" scope="col">
						
							<span><?php _e('View Orders','Phoeniixx_Customer_Manager'); ?></span>
						
						</th>
						
					</tr>

				</thead>


				<tbody id="the-list" data-wp-lists="list:customer">

					<?php 
					
					if(isset($_POST['name_desc'])) {
							
						foreach ($customer_guest_detail as $key => $row){
							$vc_array_name[$key] = $row['name'];
						}
						array_multisort($vc_array_name, SORT_DESC, $customer_guest_detail);

					}
						
					if(isset($_POST['name_asc'])){
						
					
						foreach ($customer_guest_detail as $key => $row){
							$vc_array_name[$key] = $row['name'];
						}
						array_multisort($vc_array_name, SORT_ASC, $customer_guest_detail);
					}
							
						
						
						
					if(isset($_POST['email_desc'])){
					
					
						foreach ($customer_guest_detail as $key => $row){
							$vc_array_name[$key] = $row['email'];
						}
						array_multisort($vc_array_name, SORT_DESC, $customer_guest_detail);

					}
							
					if(isset($_POST['email_asc'])){
						
					
						
						foreach ($customer_guest_detail as $key => $row){
							$vc_array_name[$key] = $row['email'];
						}
						array_multisort($vc_array_name, SORT_ASC, $customer_guest_detail);
					}
					
						
						
					if(isset($_POST['loc_desc'])){
						
					
						foreach ($customer_guest_detail as $key => $row){
							$vc_array_name[$key] = $row['state'];
						}
						array_multisort($vc_array_name, SORT_DESC, $customer_guest_detail);

					}
							
					if(isset($_POST['loc_asc'])){
						
					
						
						foreach ($customer_guest_detail as $key => $row){
							$vc_array_name[$key] = $row['state'];
						}
						array_multisort($vc_array_name, SORT_ASC, $customer_guest_detail);
					}
						
						
						
						
					if(isset($_POST['order_desc'])){
						
					
						foreach ($customer_guest_detail as $key => $row){
							$vc_array_name[$key] = $row['order_count'];
						}
						array_multisort($vc_array_name, SORT_DESC, $customer_guest_detail);

					}
							
					if(isset($_POST['order_asc'])){
						
					
						
						foreach ($customer_guest_detail as $key => $row){
							$vc_array_name[$key] = $row['order_count'];
						}
						array_multisort($vc_array_name, SORT_ASC, $customer_guest_detail);
					}
					
					if(isset($_POST['spent_desc'])){
						
					
						foreach ($customer_guest_detail as $key => $row){
							$vc_array_name[$key] = $row['order_total'];
						}
						array_multisort($vc_array_name, SORT_DESC, $customer_guest_detail);

					}
							
					if(isset($_POST['spent_asc'])){
						
					
						
						foreach ($customer_guest_detail as $key => $row){
							$vc_array_name[$key] = $row['order_total'];
						}
						array_multisort($vc_array_name, SORT_ASC, $customer_guest_detail);
					} 
					
				
					for($i=0;$i<count($customer_guest_detail);$i++)  	{

						?>
						<tr>
							<td class="customer_name column-customer_name has-row-actions column-primary" data-colname="Name (Last, First)"><?php  echo $customer_guest_detail[$i]['name'] ; ?></td>

							<td class="email column-email" data-colname="Email"><?php  echo $customer_guest_detail[$i]['email'] ; ?></td>
							<td class="location column-location" data-colname="Location"><?php  echo $customer_guest_detail[$i]['state'] ; ?>,<?php  echo $customer_guest_detail[$i]['country'] ; ?></td>
							<td class="orders column-orders" data-colname="Orders"><?php  echo $customer_guest_detail[$i]['order_count'] ; ?></td>
							<td class="spent column-spent" data-colname="Money Spent"><?php  echo $customer_guest_detail[$i]['order_total'] ; ?>
							<td class="last_order column-last_order" data-colname="Last order">
							
								<select class="phoen_select_order_num"><option value="select">View Orders</option><?php
									
									foreach($customer_guest_detail[$i]['order_num'] as $val) 	{ ?>

										<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
										
										<?php 
										
									}  ?>
								
								</select>
							</td>

						</tr>			
									
						<?php 
					}  		?>

				</tbody>


				<tfoot>
					
					
						<tr class="phoeniixx_woo_cust_manager_tr">
					
						<th id="customer_name" class="manage-column column-customer_name column-primary" scope="col"><span><?php _e('Name (First Last)','Phoeniixx_Customer_Manager'); ?></span>
							
							<button class="name_desc"  class="name_desc"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></button> 
							
							<button  name="name_asc" class="name_asc"><i class="fa fa-chevron-up fa-fw" aria-hidden="true"></i></button>
						
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
						
						<th id="last_order" class="manage-column column-last_order" scope="col">
						
							<span><?php _e('View Orders','Phoeniixx_Customer_Manager'); ?></span>
						
						</th>
						
					</tr>
				
				</tfoot>
			
			</table>

		</div>


	</form>
		
				