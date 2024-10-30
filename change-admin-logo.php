<?php
/**
* Plugin Name: Change Admin Logo
* Description: This plugin gives you the feature to change wordpress default logo from wordpress default login page.
* Author: MohammedYasar Khalifa
* Author URI: https://myasark.wordpress.com/
* Text Domain: change-admin-logo
* Domain Path: /languages
* Version: 1.2
* License: GPLv2
*/
// Exit if accessed directly.
if (!defined('ABSPATH')) exit;
class FatehCustomAdminLogo 
{   
   public function __construct()
   {
      add_action('admin_menu', array($this, 'fateh_custom_admin_logo_setting_page'));
      add_action( 'admin_init', array($this, 'fateh_register_admin_logo_settings' ));
      add_action( 'admin_enqueue_scripts', array($this,'fateh_custom_admin_logo_load_media_files' ));
      add_action( 'login_enqueue_scripts', array($this,'fateh_custom_style_admin_logo' ));
   }
  public  function fateh_custom_admin_logo_setting_page() {
   add_menu_page('Custom Admin Logo', 'Custom Admin Logo', 'administrator', 'fateh-adminlogo',array($this, 'fateh_admin_logo_settings'), 'dashicons-edit', 70);
  }
public function fateh_register_admin_logo_settings()
      {      
      register_setting( 'fateh_change_admin_logo_options_group', 'fateh_admin_logo_options');
      
      }
public  function fateh_custom_admin_logo_load_media_files() {
    wp_enqueue_script('jquery');
    wp_enqueue_media();
 }

public function fateh_admin_logo_settings(){
if (current_user_can("administrator")) { ?>
<div class="wrap">
   <h2><?php _e( 'Custom Admin Logo Settings', 'change-admin-logo' ); ?></h2>   
   <form method="post" action="options.php">
      <?php
      // wp_enqueue_script('jquery');
     // wp_enqueue_media();
      settings_fields( 'fateh_change_admin_logo_options_group' );
      $falopt = get_option('fateh_admin_logo_options'); ?> 
   <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e( 'Logo', 'change-admin-logo' ); ?></th>
        <td><img src="<?php  if (isset($falopt['logo_url'])) {echo esc_url($falopt['logo_url']);} ?>" id="logoImage" height="200px" width="200px">
      <input type="hidden" id="logo_url" name="fateh_admin_logo_options[logo_url]" value="<?php  if (isset($falopt['logo_url'])) {echo esc_url($falopt['logo_url']);} ?>" />
      <input type="button" name="fateh-upload-btn" id="fateh-upload-btn" value="Choose Logo Image"></td>
        </tr>         
        <tr valign="top">
        <th scope="row"><?php _e( 'Height', 'change-admin-logo' ); ?></th>
        <td><input type="range" name="fateh_admin_logo_options[logo_height_range]" id="logo_height_range" value="<?php if (isset($falopt['logo_height_range'])) {echo esc_attr($falopt['logo_height_range']);}?>" oninput="logo_height.value=this.value" min="0" max="1500" step="1"/><input type="number" name="fateh_admin_logo_options[logo_height]" id="logo_height" value="<?php if (isset($falopt['logo_height'])) {echo esc_attr($falopt['logo_height']);}?>" oninput="logo_height_range.value=this.value"/><b> px</b></td>
        </tr>
        <tr valign="top">
        <th scope="row"><?php _e( 'Width', 'change-admin-logo' ); ?></th>
        <td><input type="range" name="fateh_admin_logo_options[logo_width_range]" id="logo_width_range" value="<?php if (isset($falopt['logo_width_range'])) {echo esc_attr($falopt['logo_width_range']);}?>" oninput="logo_width.value=this.value" min="0" max="1500" step="1"/>
            <input type="number" name="fateh_admin_logo_options[logo_width]" id="logo_width" value="<?php if (isset($falopt['logo_width'])) {echo esc_attr($falopt['logo_width']);}?>" oninput="logo_width_range.value=this.value" /><b> px</b></td> 
        </tr>
    </table>
      <?php submit_button(); ?>
   </form>  
      </div>
      <script type="text/javascript">       
        jQuery(document).ready(function($) {
          $('#fateh-upload-btn').click(function(e) {
            e.preventDefault();
           var logo_image = wp.media({
            title: 'Insert Image',
            multiple: false
            }).open().on('select', function(e) {
            var uploaded_image = logo_image.state().get('selection').first();
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            $('#logo_url').val(image_url);
            $("#logoImage").attr('src', image_url);
          });
        });
      });
      </script>
      <?php  }      
      }

public function fateh_custom_style_admin_logo() { 
      $falopt = get_option('fateh_admin_logo_options'); ?> 
        <style type="text/css"> 
         body.login div#login h1 a {
            background-image: url(<?php echo esc_url($falopt['logo_url']);?>);
            padding-bottom: 30px; 
            height:<?php echo esc_attr($falopt['logo_height']);?>px !important;
            width:<?php echo esc_attr($falopt['logo_width']);?>px !important;
            background-size:100% !important;
            background-repeat: no-repeat;
         } 
        </style>
 <?php 
 } 
}
$FatehCustomAdminLogo= new FatehCustomAdminLogo();