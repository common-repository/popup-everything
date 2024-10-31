<?php

/**
 * PopUp Everything plugin - Configuration page.
 */

/**
 * All plugin options.
 */
function popup_everything_get_all_options() {
	return array(
		'text'     => array(
			'box_size'     => __( 'Box size eg. 200px or 15% (% or px)', 'popup-everything' ),
			'box_position' => __( 'Box vertical position eg. 20% (% or px)', 'popup-everything' ),
			'box_title'    => __( 'Title', 'popup-everything' ),
			'phone_no'     => __( 'Phone No.', 'popup-everything' ),
			'email'        => __( 'E-mail', 'popup-everything' ),
			'facebook'     => __( 'Facebook', 'popup-everything' ),
			'twitter'      => __( 'Twitter', 'popup-everything' ),
			'linkedin'     => __( 'Linkedin', 'popup-everything' ),
			'instagram'    => __( 'Instagram', 'popup-everything' ),
			'pinterest'    => __( 'Pinterest', 'popup-everything' ),
			'googleplus'   => __( 'Google+', 'popup-everything' )
		),
		'textarea' => array(
			'content' => __( 'Content', 'popup-everything' )
		),
		'select'   => array(
			'box_side' => array(
				'title'   => __( 'Select the position', 'popup-everything' ),
				'options' => array(
					'left'  => __( 'Left', 'popup-everything' ),
					'right' => __( 'Right', 'popup-everything' ),
				)
			)
		)
	);
}

/**
 * Add option page.
 */
add_action( 'admin_menu', 'popup_everything_add_admin_menu' );
function popup_everything_add_admin_menu() {
	add_options_page( 'popup-everything', __( 'Popup Everything', 'popup-everything' ), 'manage_options', 'popup-everything', 'popup_everything_options_page' );
}

/**
 * Add settings.
 */
add_action( 'admin_init', 'popup_everything_settings_init' );
function popup_everything_settings_init() {

	if ( function_exists('popup_everything_get_all_options') ) {

		// Register global plugin settings.
		register_setting( 'popup_everything_settings', 'popup_everything_settings' );

		// Register plugin section for editing settings.
		add_settings_section(
			'popup_everything_plugin_page_section',
			__( 'Setup your popup options and social relations for the website/company.', 'popup-everything' ),
			'',
			'popup_everything_settings'
		);

		// for each nested array - find type, then key and content
		foreach ( popup_everything_get_all_options() as $type => $items ) {
			foreach ( $items as $item_name => $item ) {
				$options = array();
				// Select fields contains options.
				if ( $type === 'select' ) {

					// Prepare our option array.
					foreach ( $item['options'] as $value => $option_title ) {
						if ( ! isset( $options[ $value ] ) ) {
							$options[ $value ] = $option_title;
						}
					}
					$title = $item['title'];
				} else {
					$title = $item;
				}

				// Add settings field with dynamic info.
				add_settings_field(
					'popup_everything_' . $item_name,
					$title,
					'popup_everything_input_callback',
					'popup_everything_settings',
					'popup_everything_plugin_page_section',
					array(
						'type'    => $type,
						'name'    => $item_name,
						'options' => $options
					)
				);
			}
		}
	}
}

/**
 * Each option.
 */
function popup_everything_input_callback( $field_settings ) {

	// Multiple usage of values
	$type = $field_settings['type'];
	$name = $field_settings['name'];

	// Grab our options array.
	$settings_set = 'popup_everything_settings';
	$options      = get_option( $settings_set );
	// Check if we have an existing value and else set it empty.
	$value = ( isset( $options[ '_' . $name ] ) ? $options[ '_' . $name ] : '' );

	// Lets return the correct input markup by switching the type.
	switch ( $type ) {
		case 'text': // if $type == 'text', then echo this.
			echo '<input type="text" name="' . $settings_set . '[_' . $name . ']" value="' . $value . '">';
			break;
		case 'textarea': // if $type == 'textarea', then echo this.
			echo '<textarea cols="40" rows="5" name="' . $settings_set . '[_' . $name . ']">' . $value . '</textarea>';
			break;
		case 'select': // if $type == 'select', then echo this.
			$select_options = $field_settings['options']; // get options array settings
			echo '<select name="' . $settings_set . '[_' . $name . ']">'; // echo select tag
			// Run through all select_options (array) and echo option with value, content and check if selected.
			foreach ( $select_options as $select_option_value => $select_option_title ) {
				echo '<option value="' . $select_option_value . '" ' . selected( $value, $select_option_value ) . '>' . $select_option_title . '</option>';
			}
			echo '</select>';
			break;
		// default, echo nothing.
		default:
			echo '';
			break;
	}
}

/**
 * Options page.
 */
function popup_everything_options_page() { ?>
	<div style="margin-top:15px;padding:15px;">
		<div style="padding:15px;-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);background: #fff;">
			<form action='options.php' method='post'>

				<h2><?php _e( 'Popup Everything', 'popup-everything' ); ?></h2>
				<hr>
				<p><?php _e( 'Configure the Popup Everything plugin.', 'popup-everything' ); ?></p>

				<?php
				// Begin our settings.
				settings_fields( 'popup_everything_settings' );
				do_settings_sections( 'popup_everything_settings' );
				submit_button();
				?>
			</form>
		</div>
	</div>
<?php }
