<?php 

/* Plugin Name:Customer Manager

* Plugin URI: http://www.phoeniixx.com/

* Description:It is a plugin  which shows you a complete list  of registered users with orders , guest users with orders and customers with zero orders 

* Version: 1.9

* Author: phoeniixx

* Author URI: http://www.phoeniixx.com/

* License: GPLv2 or later

* Text Domain:Phoeniixx_Customer_Manager

* License URI: http://www.gnu.org/licenses/gpl-2.0.html

* WC requires at least: 2.6.0

* WC tested up to: 3.6.2

*/


if ( ! defined( 'ABSPATH' ) ) exit;

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{	

	include(dirname(__FILE__).'/libs/execute-libs.php');
	
	add_action('admin_menu', 'Phoeniixx_Customer_Manager_Menu');
	
	function Phoeniixx_Customer_Manager_Menu() {
		
		
		add_menu_page( 'Customer_Manager', __( 'Customer Manager', 'phe' ), 'nosuchcapability', 'Customer_Manager', NULL, plugin_dir_url( __FILE__ ).'assets/images/aa2.png', 57.1 );
		
		add_submenu_page( 'Customer_Manager', 'Cust_mgr_settings', 'Settings','manage_options', 'Cust_mgr_settings',  'phoe_setting_cust_mgr' );
	
		add_submenu_page( 'Customer_Manager', 'Cust_mgr_reports', 'Reports','manage_options', 'Cust_mgr_reports',  'phoe_Customer_Manager_tab' );
	
	
	
	} add_action('admin_head','ajax_font_awesome_product_filter_function_iconpicker_aa');

	function ajax_font_awesome_product_filter_function_iconpicker_aa(){
		
		wp_enqueue_style('font-awesome_call_frontend', plugin_dir_url(__FILE__). "assets/font-awesome/css/font-awesome.min.css"); 
		
		wp_enqueue_style('font-awesome_call_frontenda', plugin_dir_url(__FILE__). "assets/font-awesome/css/font-awesome.css"); 
		
		wp_enqueue_script( 'phoe_style_iconsddgg_ajax_gherhg', plugin_dir_url(__FILE__). "assets/js/admin.js" );	
		
		wp_enqueue_style( 'phoe_style_iconsddgsdcg_ajax_gherhg', plugin_dir_url(__FILE__). "assets/css/admin.css" );	
	}
	
	

function enqueue_select2_jquery() {
    wp_register_style( 'select2css', 'http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.css', false, '1.0', 'all' );
    wp_register_script( 'select2', 'http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_style( 'select2css' );
    wp_enqueue_script( 'select2' );
    }
add_action( 'admin_enqueue_scripts', 'enqueue_select2_jquery' );

 
register_activation_hook( __FILE__, 'function_phoe_cust_manager_value');

function function_phoe_cust_manager_value()
{
	
	$phoe_cust_manager_value = array(
		
		'enable_cust'=>1
		
	
		
		
		);
		
		update_option('phoe_cust_manager_value',$phoe_cust_manager_value);
	
}
 


	function phoe_setting_cust_mgr()
	{ ?>
		<div id="profile-page" class="wrap">
	
			<?php
				
			if(isset($_GET['tab']))
					
			{
				$tab = sanitize_text_field( $_GET['tab'] );
				
			}
			
			else
				
			{
				
				$tab="";
				
			}
			
			?>
			<h2> <?php _e('Customer Manager','Phoeniixx_Customer_Manager'); ?></h2>
			
			<?php $tab = (isset($_GET['tab']))?$_GET['tab']:'';?>
			
			<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
			
				<a class="nav-tab <?php if($tab == 'cust_mgr_setting' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=Customer_Manager&amp;tab=cust_mgr_setting"><?php _e('Setting','Phoeniixx_Customer_Manager'); ?></a>
				
				
			</h2>
			
		</div> 
		
		
	<?php  if($tab=='cust_mgr_setting'|| $tab == '' )
		{
			
			include_once(plugin_dir_path(__FILE__).'includes/pagesetting.php');
									
		} 


		}
	
	
	function phoe_Customer_Manager_tab() { 

		$gen_settings = get_option('phoe_cust_manager_value');
		$enable_cust=isset($gen_settings['enable_cust'])?$gen_settings['enable_cust']:'';

		if($enable_cust=="1")
		{
			?>
		
		<div id="profile-page" class="wrap">
	
			<?php
				
			if(isset($_GET['tab']))
					
			{
				$tab = sanitize_text_field( $_GET['tab'] );
				
			}
			
			else
				
			{
				
				$tab="";
				
			}
			
			?>
			<h2> <?php _e('Customer Manager','Phoeniixx_Customer_Manager'); ?></h2>
			
			<?php $tab = (isset($_GET['tab']))?$_GET['tab']:'';?>
			
			<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
			
				
				<a class="nav-tab <?php if($tab == 'cust_mgr_reg_cust' ){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=Cust_mgr_reports&amp;tab=cust_mgr_reg_cust"><?php _e('Registered User','Phoeniixx_Customer_Manager'); ?></a>
				
				<a class="nav-tab <?php if($tab == 'cust_mgr_zero_order' ){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=Cust_mgr_reports&amp;tab=cust_mgr_zero_order"><?php _e('Customer with Zero order','Phoeniixx_Customer_Manager'); ?></a>
				
				<a class="nav-tab <?php if($tab == 'cust_mgr_guest' ){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=Cust_mgr_reports&amp;tab=cust_mgr_guest"><?php _e('Guest','Phoeniixx_Customer_Manager'); ?></a>
				
			</h2>
			
		</div>
		
		<?php
		
		
		
		if($tab=='cust_mgr_reg_cust'|| $tab == '' )
		{
			
			include_once(plugin_dir_path(__FILE__).'includes/cust_mgr_registered.php');
									
		} 
		
		if($tab=='cust_mgr_zero_order' )
		{
			
			include_once(plugin_dir_path(__FILE__).'includes/cust_magr_zero_order.php');
									
		} 
		
		if($tab=='cust_mgr_guest' )
		{
			
			include_once(plugin_dir_path(__FILE__).'includes/cust_mgr_guest.php');
									
		} 
			
	}

	}
}


	
?>
