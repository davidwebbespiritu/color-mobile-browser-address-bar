<?php
/**
 * Plugin Name: Color Mobile Browser Address Bar
 * Plugin URI: https://github.com/webbteche/Color-Mobile-Browser-Address-Bar
 * Description: A Wordpress plugin that lets you add a custom color to the address bar of mobile browsers.
 * Version: 1.0.0
 * Author: Webb Jamelo
 * Author URI: https://github.com/webbteche
 * License: MIT
 */

// For security purposes. No direct browsing!
if (!defined('ABSPATH')) exit;

// Create sub menu on the appearance admin menu
add_action('admin_menu', 'mobile_browser_address_bar_color_create_menu');

function mobile_browser_address_bar_color_create_menu() {
	add_theme_page('Color Mobile Browser Address Bar', 'Mobile Browser Address Bar Color', 'manage_options', 'm-address-bar-color', 'm_address_bar_color_function');
	
	add_action(	'admin_init',
        'register_m_address_bar_color_settings'
    );
}

// Register Settings
function register_m_address_bar_color_settings() {
    register_setting	(	'save-m-address-bar-color-settings',
        'mobile_browser_address_bar_color_id'
    );
}

// Add Color picker
add_action( 'admin_enqueue_scripts', 'm_address_bar_color_add_color_picker' );
function m_address_bar_color_add_color_picker( $hook ) {
 
	if (!current_user_can('manage_options')) {
        wp_die( __("You're not cool enough to access this page."));
    }
		
		// Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'assets/custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 

}

// Create Settings Page
function m_address_bar_color_function() {
    if (!current_user_can('manage_options')) {
        wp_die( __("You're not cool enough to access this page."));
    }
    ?>

    <div class="wrap">
        <form method="post" action="options.php">
            <?php
            settings_fields		(	'save-m-address-bar-color-settings'
            );
            do_settings_sections(	'save-m-address-bar-color-settings'
            );

            $mobile_browser_address_bar_color_id = esc_attr(get_option('mobile_browser_address_bar_color_id'));
            ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Set Color</th>
                    <td>
					
					<input type="text" id="mbabc_color_picker_id" name="mobile_browser_address_bar_color_id" value="<?php echo $mobile_browser_address_bar_color_id; ?>" />
					
					</td>
                </tr>
            </table>

            <?php submit_button() ;?>

        </form>
    </div>
    <?php
}

// add meta tag in <head>.
add_action( 'wp_head', 'm_address_mobile_address_bar' );
function m_address_mobile_address_bar() {

	$mobile_browser_address_bar_color_id = esc_attr(get_option('mobile_browser_address_bar_color_id'));
	
	//this is for Chrome, Firefox
	echo '<meta name="theme-color" content="'.$mobile_browser_address_bar_color_id.'">';
	//this is for Windows Phone
	echo '<meta name="msapplication-navbutton-color" content="'.$mobile_browser_address_bar_color_id.'">';
	//this is for iOS Safari
	echo '<meta name="apple-mobile-web-app-capable" content="yes">';
	echo '<meta name="apple-mobile-web-app-status-bar-style" content="black">';
}

?>