<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">``
	<![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />  
    <meta charset="<?php bloginfo('charset'); ?>" />	
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
<?php $wl_theme_options = weblizar_get_options(); ?>
<div id="menu_wrapper" <?php if($wl_theme_options['sticky_header']!='') { ?> data-spy="affix" data-offset-top="95" <?php } ?> >
	<div class="top_wrapper">
		<header id="header">
			<div class="row">
				<nav class="navbar navbar-default" role="navigation" <?php if ( has_header_image() ) { ?> style='background-image: url("<?php header_image(); ?>")' <?php  } ?>>
					<div class="container-fluid">	
					<div class="col-md-4" style="padding-left:6%;">
						<div class="navbar-header">						  
						  <div class="logo pull-left">							
							<?php  
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$image = wp_get_attachment_image_src( $custom_logo_id,'full' ); ?>	
							<a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" href="<?php echo home_url( '/' ); ?>">
							<?php if(has_custom_logo()) { ?>
							<img  src="<?php echo $image[0]; ?>" style="height:<?php if($wl_theme_options['height']!='') { echo $wl_theme_options['height']; }  else { echo "55"; } ?>px; width:<?php if($wl_theme_options['width']!='') { echo $wl_theme_options['width']; }  else { echo "150"; } ?>px;" /> <?php }
							else {
								echo '<span class="site-title">'.get_bloginfo( ).'</span>';
							}
							?>
							</a>
							<p class="site-description"><?php bloginfo( 'description' ); ?></p>
						  </div>
						  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						  </button>
						</div>
						</div>
						<div class="col-md-8">
						<?php wp_nav_menu( array(
							'theme_location'    => 'primary',               
							'container'         => 'nav-collapse collapse navbar-inverse-collapse',		
							'menu_class'        => 'nav navbar-nav navbar-left',
							'fallback_cb'       => 'weblizar_fallback_page_menu',
							'walker'            => new wp_bootstrap_navwalker())
						);  ?>
						</div>
					</div>
				</nav>		
			</div>
		</header>
	</div>
</div>