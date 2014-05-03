<?php

/*******************************************
* private forums visibility Settings Page
*******************************************/


function pfv_settings_page()
{
	global $pfv_options;
		
	?>
	<div class="wrap">
		<div id="upb-wrap" class="upb-help">
			<h2><?php _e('Private Forum Visibility', 'private-forum-visibility'); ?></h2>
			<?php
			if ( ! isset( $_REQUEST['updated'] ) )
				$_REQUEST['updated'] = false;
			?>
			<?php if ( false !== $_REQUEST['updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved', 'private-forum-visibility'); ?> ); ?></strong></p></div>
			<?php endif; ?>
			
			<table class="form-table">
			<tr>
		
		<td>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="S6PZGWPG3HLEA">
<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>
</td><td>
<?php _e("If you find this plugin useful, please consider donating just a couple of pounds to help me develop and maintain it. You support will be appreciated", 'private-forum-visibility'); ?>
		
	</td>
	</tr>
	</table>		
			
			<form method="post" action="options.php">

				<?php settings_fields( 'pfv_settings_group' ); ?>
								
				<table class="form-table">
					
					<tr valign="top">
						<th colspan="2"><p> This plugin adds visibility for private forums (and descriptions) to non-logged in users.</p></th>
					</tr>
					
										
					<!-------------------------------Redirect Page ---------------------------------------->
					
					<tr valign="top">
						<th colspan="2"><h3><?php _e('Redirect Page', 'private-forum-visibility'); ?></h3></th>
					</tr>
					
					
					<tr valign="top">
					<th><?php _e('URL of redirect page', 'private-forum-visibility'); ?></th>
					<td>
						<input id="pfv_settings[redirect_page]" class="large-text" name="pfv_settings[redirect_page]" type="text" value="<?php echo isset( $pfv_options['redirect_page'] ) ? esc_html( $pfv_options['redirect_page'] ) : '';?>" /><br/>
						<label class="description" for="pfv_settings[redirect_page]"><?php _e( 'Enter the full url (permalink) of the page to redirect non-logged in users to eg http://www.mysite.com/sign-up', 'private-forum-visibility' ); ?></label><br/>
					</td>
					</tr>
										
					<!-------------------------------Freshness settings ---------------------------------------->
					
					<tr valign="top">
						<th colspan="2"><h3><?php _e('Freshness Settings', 'private-forum-visibility'); ?></h3></th>
					</tr>
					<!-- checkbox to activate -->
					<tr valign="top">  
					<th><?php _e('Activate', 'private-forums-visibility'); ?></th>
					<td>
					<?php freshness_checkbox() ;?>
					</td>
					</tr>		
					<tr valign="top">
					<td></td><td><?php _e('For private forums, when not logged in, you can either show a message in freshness column, or leave it as the default time since last post.  In both cases for non logged-in users they will be taken to the redirect page above.', 'private-forum-visibility'); ?></td>
					</tr>
					<tr valign="top">
					<th><?php _e('Freshness Message', 'private-forum-visibility'); ?></th>
					<td>
						<input id="pfv_settings[freshness_message]" class="large-text" name="pfv_settings[freshness_message]" type="text" value="<?php echo isset( $pfv_options['freshness_message'] ) ? esc_html( $pfv_options['freshness_message'] ) : '';?>" /><br/>
						<label class="description" for="pfv_settings[redirect_page]"><?php _e( 'Enter the message to be shown e.g. Click here to sign up', 'private-forum-visibility' ); ?></label><br/>
					</td>
					</tr>
					
					
					
					
					
					
					
					
					<!------------------------------- Hide topic/reply counts ------------------------------------------>
					<tr valign="top">
						<th colspan="2"><h3><?php _e('Hide topic and reply counts', 'private-forum-visibility'); ?></h3></th>
					</tr>
					
					
					<!-- checkbox to activate -->
					<tr valign="top">  
					<th><?php _e('Activate', 'private-forums-visibility'); ?></th>
					<td>
					<?php activate_hide_counts_checkbox() ;?>
					</td>
					</tr>					
					<!------------------------------- Descriptions ------------------------------------------>
					<tr valign="top">
						<th colspan="2"><h3><?php _e('Show Descriptions', 'private-forum-visibility'); ?></h3></th>
					</tr>
					
					
					<!-- checkbox to activate -->
					<tr valign="top">  
					<th><?php _e('Activate', 'private-forums-visibility'); ?></th>
					<td>
					<?php activate_descriptions_checkbox() ;?>
					</td>
					</tr>
					
					
					<!------------------------------- Remove 'Private' prefix ------------------------------------------>
					<tr valign="top">
						<th colspan="2"><h3><?php _e("Remove 'Private' prefix", 'private-forum-visibility'); ?></h3></th>
					</tr>
					
					<!-- checkbox to activate -->
					<tr valign="top">  
					<th><?php _e('Activate', 'private-forum-visibility'); ?></th>
					<td>
					<?php activate_private_prefix_checkbox() ;?>
					</td>
					</tr>
					<tr valign="top">
					<td></td><td><?php _e('By default bbPress shows the prefix "Private" before each private forum. Activate this checkbox to remove this prefix.', 'private-forum-visibility'); ?></td>
					</tr>
					
					
				
				</table>
				
				<!-- save the options -->
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'private-forum-visibility' ); ?>" />
				</p>
								
				
			</form>
		</div><!--end sf-wrap-->
	</div><!--end wrap-->
		
	<?php
}

// register the plugin settings
function pfv_register_settings() {

	// create whitelist of options
	register_setting( 'pfv_settings_group', 'pfv_settings' );
	}
//call register settings function
add_action( 'admin_init', 'pfv_register_settings' );


function pfv_settings_menu() {

	// add settings page
	add_submenu_page('options-general.php', __('Private Forums Visibility', 'private-forum-visibility'), __('Private Forums Visibility', 'private-forum-visibility'), 'manage_options', 'private-forum-visibility-settings', 'pfv_settings_page');
}
add_action('admin_menu', 'pfv_settings_menu');

/*****************************   Checkbox functions **************************/

function freshness_checkbox() {
 	global $pfv_options ;
	$item4 =  $pfv_options['set_freshness_message'] ;
	echo '<input name="pfv_settings[set_freshness_message]" id="pfv_settings[set_freshness_message]" type="checkbox" value="1" class="code" ' . checked( 1,$item4, false ) . ' /> Click to activate a freshness message';
  } 


function activate_hide_counts_checkbox() {
 	global $pfv_options ;
	$item1 =  $pfv_options['hide_counts'] ;
	echo '<input name="pfv_settings[hide_counts]" id="pfv_settings[hide_counts]" type="checkbox" value="1" class="code" ' . checked( 1,$item1, false ) . ' /> Hide topic and reply counts';
  } 

function activate_descriptions_checkbox() {
 	global $pfv_options ;
	$item2 =  $pfv_options['activate_descriptions'] ;
	echo '<input name="pfv_settings[activate_descriptions]" id="pfv_settings[activate_descriptions]" type="checkbox" value="1" class="code" ' . checked( 1,$item2, false ) . ' /> Show forum content (Descriptions) on main index';
  }

function activate_private_prefix_checkbox() {
 	global $pfv_options ;
	$item3 =  $pfv_options['activate_remove_private_prefix'] ;
	echo '<input name="pfv_settings[activate_remove_private_prefix]" id="pfv_settings[activate_remove_private_prefix]" type="checkbox" value="1" class="code" ' . checked( 1,$item3, false ) . ' /> Remove Private prefix';
  }