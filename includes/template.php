<?php

/**
 * PopUp Everything plugin - Front-end template.
 */

/**
 * Render HTML for contact box plugin.
 */
add_action( 'wp_footer', 'popup_everything_box_render', 100 );
function popup_everything_box_render() {

	// Get saved plugin options.
	$options = get_option( 'popup_everything_settings' );

	// Set the display variables for the content box.
	$box_size     = ( isset( $options['_box_size'] ) ? esc_attr( $options['_box_size'] ) : '230px' );
	$box_position = ( isset( $options['_box_position'] ) ? esc_attr( $options['_box_position'] ) : '20%' );
	$box_side     = ( isset( $options['_box_side'] ) ? esc_attr( $options['_box_side'] ) : 'left' );
	$box_title    = ( isset( $options['_box_title'] ) ? esc_attr( $options['_box_title'] ) : 'Contact' );
	$phone_no     = ( isset( $options['_phone_no'] ) ? esc_attr( $options['_phone_no'] ) : '' );
	$email        = ( isset( $options['_email'] ) ? esc_attr( $options['_email'] ) : '' );
	$content      = ( isset( $options['_content'] ) ? wp_kses_post( $options['_content'] ) : '' );

	// if $box_size does not contain % or px, add px to string.
	if ( ! preg_match('(px|%)', $box_size) ) {
		$box_size .= 'px';
	}

	// Begin rendering our template.
	echo '<div id="popup-everything" class="popup-everything popup-everything-position-' . $box_side . '" style="top:' . $box_position . ';">';
	echo '<input style="display: none;" type="checkbox" id="popup-everything-checkbox">';
	echo '<label for="popup-everything-checkbox" id="popup-everything-checkbox-toggle"><span class="popup-everything-ico popup-everything-ico-phone"></span></label>';
	echo '<div class="popup-everything-inner-wrap" style="width:' . esc_attr( $box_size ) . ';">';
	echo '<h2 class="popup-everything-header">' . esc_attr( $box_title ) . '</h2>';
	echo '<div class="popup-everything-inner">';
	// Phone
	if ( ! empty( $phone_no ) ) {
		echo '<div class="popup-everything-phone_no">';
		if ( wp_is_mobile() ) {
			echo '<a href="tel:' . preg_replace( '/\s+/', '', $phone_no ) . '"><span class="popup-everything-ico popup-everything-ico-phone"></span>' . $phone_no . '</a>';
		} else {
			echo '<span class="popup-everything-ico popup-everything-ico-phone"></span>' . $phone_no;
		}
		echo '</div>';  
	}

	// Content.
	if ( ! empty( $content ) ) {
		echo '<div class="popup-everything-content">';
		echo wpautop( do_shortcode( $content ) );
		echo '</div>';
	}

	// E-mail.
	if ( ! empty( $email ) ) {
		echo '<div class="popup-everything-email">';
		echo '<a href="mailto:' . $email . '"><span class="popup-everything-ico popup-everything-ico-envelope-o"></span>' . $email . '</a>';
		echo '</div>';
	}
	echo '</div>';

	// Set the variables for our social media navigation.
	$social_media_types = array(
		'facebook',
		'twitter',
		'linkedin',
		'instagram',
		'pinterest',
		'googleplus',
	);

	$social_media        = '';
	$social_active_count = 0;
	foreach ( $social_media_types as $media_type ) {

		if ( isset( $options[ '_' . $media_type ] ) && ! empty( $options[ '_' . $media_type ] ) ) {
			$social_media .= '<li class="' . $media_type . '">
				<a class="popup-everything-ico popup-everything-ico-' . $media_type . '" href="' . esc_url( $options[ '_' . $media_type ] ) . '"></a>
			</li>';
			$social_active_count ++;
		}
	}
	
	// Begin rendering the social media templates.
	if ( ! empty( $social_media ) ) {
		echo '<ul class="popup-everything-social-list active-count-' . $social_active_count . '">';
		echo $social_media;
		echo '</ul>';
	}
	echo '</div>';
	echo '</div>';
}
