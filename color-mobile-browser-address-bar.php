<?php
/**
 * Plugin Name: Color Mobile Browser Address Bar
 * Plugin URI: https://github.com/webbteche/Color-Mobile-Browser-Address-Bar
 * Description: A WordPress plugin that lets you add a custom color to the address bar of mobile browsers.
 * Version: 1.0.4
 * Author: Webb Jamelo
 * Author URI: https://github.com/webbteche
 * License: GPLv2 or later
 */

// For security purposes, no direct browsing!
if ( !defined( 'ABSPATH' ) )
    exit;

// Create a sub menu on the appearance admin menu
add_action( 'admin_menu', 'mobile_browser_address_bar_color_create_menu' );
function mobile_browser_address_bar_color_create_menu( )
  {
    add_theme_page( 'Color Mobile Browser Address Bar', 'Mobile Browser Address Bar Color', 'manage_options', 'm-address-bar-color', 'm_address_bar_color_function' );
    add_action( 'admin_init', 'register_m_address_bar_color_settings' );
  }
  
// Register settings
function register_m_address_bar_color_settings( )
  {
    register_setting( 'save-m-address-bar-color-settings', 'mobile_browser_address_bar_color_value' );
  }
  
// Enqueue Color picker scripts
add_action( 'admin_enqueue_scripts', 'm_address_bar_color_add_color_picker' );
function m_address_bar_color_add_color_picker( $hook )
  {
    if ( 'appearance_page_m-address-bar-color' != $hook )
        return;
    // Add the color picker css file       
    wp_enqueue_style( 'wp-color-picker' );
    // Include our custom jQuery file with WordPress Color Picker dependency
    wp_enqueue_script( 'custom-script-handle', plugins_url( 'admin/js/custom-script.js', __FILE__ ), array(
         'wp-color-picker' 
    ), false, true );
  }
  
// Create plugin settings page
function m_address_bar_color_function( )
  {
    if ( !current_user_can( 'manage_options' ) )
      {
        wp_die( __( "Oops! You've gone too far." ) );
      }
?>

	<div class="wrap">
	<h2>Just add the color!</h2>
        <form method="post" action="options.php">
		<?php
		settings_fields( 'save-m-address-bar-color-settings' );
		do_settings_sections( 'save-m-address-bar-color-settings' );
		
		$mobile_browser_address_bar_color_value = esc_attr( get_option( 'mobile_browser_address_bar_color_value' ) );

		?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Set Color</th>
						<td>
							<input type="text" id="mbabc_color_picker_id" name="mobile_browser_address_bar_color_value" value="
							<?php echo $mobile_browser_address_bar_color_value;?>" />
						</td>
				</tr>
            </table>
		<?php
		submit_button();
?>
		</form>
    </div>
	<?php
  }
  
// add meta tag in <head>.
add_action( 'wp_head', 'm_address_mobile_address_bar' );
function m_address_mobile_address_bar( )
  {
    $mobile_browser_address_bar_color_value = esc_attr( get_option( 'mobile_browser_address_bar_color_value' ) );
    
	//this is for Chrome, Firefox
    echo '<meta name="theme-color" content="' . $mobile_browser_address_bar_color_value . '">';
    //this is for Windows Phone
    echo '<meta name="msapplication-navbutton-color" content="' . $mobile_browser_address_bar_color_value . '">';
    //this is for iOS Safari
    echo '<meta name="apple-mobile-web-app-capable" content="yes">';
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">';
  }
?>