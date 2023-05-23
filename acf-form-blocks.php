<?php
/**
 * ACF Form Blocks
 *
 * @package       ACFFormBlocks
 * @author        Briantics, Inc.
 *
 * @wordpress-plugin
 * Plugin Name:   ACF Form Blocks
 * Plugin URI:    https://briantics.com
 * Description:   Leverage the power of ACF to build custom forms.
 * Version:       0.0.1
 * Author:        Briantics, Inc.
 * Author URI:    https://briantics.com
 * Update URI:    https://briantics.com
 * Text Domain:   acf-form-blocks
 * Domain Path:   /lang
 */

define( 'ACF_FORM_BLOCKS_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_FORM_BLOCKS_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_FORM_BLOCKS_BASENAME', plugin_basename( __FILE__ ) );
define( 'ACF_FORM_BLOCKS_VERSION', '0.0.1' );

require ACF_FORM_BLOCKS_PATH . '/includes/acf-blocks.php';
require ACF_FORM_BLOCKS_PATH . '/includes/forms.php';
