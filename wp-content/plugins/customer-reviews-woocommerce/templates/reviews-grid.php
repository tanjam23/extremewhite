<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="ivole-reviews-grid" id="<?php echo $id; ?>" style="<?php echo $section_style; ?>">
	<?php foreach ( $reviews as $i => $review ):
		$rating = intval( get_comment_meta( $review->comment_ID, 'rating', true ) );
		$order_id = intval( get_comment_meta( $review->comment_ID, 'ivole_order', true ) );
		$country = get_comment_meta( $review->comment_ID, 'ivole_country', true );
		$country_code = null;
		if( $country_enabled && is_array( $country ) && isset( $country['code'] ) ) {
			$country_code = $country['code'];
		}
	?>
		<div class="ivole-review-card" style="<?php echo $card_style; ?>">
			<div class="top-row">
				<div class="rating">
					<div class="star-rating"><span style="width:<?php echo ($rating / 5) * 100; ?>%;"></span></div>
					<div class="datetime">
						<?php printf( _x( '%s ago', '%s = human-readable time difference', IVOLE_TEXT_DOMAIN ), human_time_diff( mysql2date( 'U', $review->comment_date, true ), current_time( 'timestamp' ) ) ); ?>
					</div>
				</div>
				<div class="reviewer">
					<div class="reviewer-name">
						<?php
							echo get_comment_author( $review );
							if( $country_code ) {
								echo '<img src="https://www.cusrev.com/flags/' . $country_code . '.svg" class="ivole-grid-country-icon" alt="' . $country_code . '">';
							}
						?>
					</div>
					<div class="reviewer-verified">
						<?php echo wc_review_is_from_verified_owner( $review->comment_ID ) ? $verified_text: ''; ?>
					</div>
				</div>
			</div>
			<div class="middle-row">
				<div class="review-thumbnail">
					<?php echo get_avatar( $review ); ?>
				</div>
				<div class="review-content">
					<div class="review-text"><?php echo $review->comment_content; ?></div>
				</div>
			</div>
			<?php if ( $verified_reviews_enabled && $order_id && intval( $review->comment_post_ID ) !== intval( $shop_page_id ) ): ?>
				<div class="verified-review-row">
					<div class="verified-badge"><?php printf( $badge, $review->comment_post_ID, $order_id ); ?></div>
				</div>
			<?php elseif ( $verified_reviews_enabled && $order_id && intval( $review->comment_post_ID ) === intval( $shop_page_id ) ): ?>
				<div class="verified-review-row">
					<div class="verified-badge"><?php printf( $badge_sr, $order_id ); ?></div>
				</div>
			<?php else: ?>
				<div class="verified-review-row">
					<div class="verified-badge-empty"></div>
				</div>
			<?php endif; ?>
			<?php if ( $show_products && $product = wc_get_product( $review->comment_post_ID ) ): ?>
			<div class="review-product" style="<?php echo $product_style; ?>">
				<div class="product-thumbnail">
					<?php echo $product->get_image( 'woocommerce_gallery_thumbnail' ); ?>
				</div>
				<div class="product-title">
					<?php if ( $product_links ): ?>
						<?php echo '<a href="' . esc_url( get_permalink( $product->get_id() ) ) . '">' . $product->get_title() . '</a>'; ?>
					<?php else: ?>
						<?php echo '<span>' . $product->get_title() . '</span>'; ?>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>
