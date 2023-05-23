<?php
/**
 * ACF Block Settings
 *
 * @package ACFFormBlocks
 */

/**
 * Save block fields in block folder.
 *
 * @param string $path Path where to save JSON.
 *
 * @return string
 */
add_filter( 'acf/settings/save_json', function ( $path ) {
	$block = acf_form_blocks_acf_get_posted_block();

	if ( ! $block ) {
		return $path;
	}

	$block_path = acf_form_blocks_get_block_location( $block );

	if ( $block_path ) {
		return $block_path;
	}

	return $path;
} );

/**
 * Grab the block name from posted field settings, if present.
 *
 * @return false|string
 */
function acf_form_blocks_acf_get_posted_block() {
	if ( empty( $_POST['acf_field_group'] ) || ! is_array( $_POST['acf_field_group'] ) || empty( $_POST['acf_field_group']['location'] ) ) {
		return false;
	}

	if ( count( $_POST['acf_field_group']['location'] ) > 1 ) {
		return false;
	}

	foreach ( $_POST['acf_field_group']['location'] as $group_key => $group ) {
		if ( empty( $group ) ) {
			continue;
		}

		if ( count( $group ) > 1 ) {
			return false;
		}

		foreach ( $group as $rule_key => $rule ) {
			if ( empty( $rule ) || empty( $rule['param'] ) || empty( $rule['value'] ) ) {
				continue;
			}

			if ( 'block' === $rule['param'] && '==' === $rule['operator'] && ! empty( $rule['value'] ) ) {
				return str_replace( 'acf/', '', $rule['value'] );
			}
		}
	}

	return false;
}

/**
 * Load block JSON from block folders.
 *
 * @param array $paths Paths where to load block settings.
 *
 * @return array
 */
add_filter( 'acf/settings/load_json', function ( $paths ) {
	$paths[]   = ACF_FORM_BLOCKS_PATH . '/acf-json';
	$locations = acf_form_blocks_get_block_locations();

	foreach ( $locations as $location ) {
		$groups = glob( trailingslashit( $location ) . '**/group_*.json' );

		foreach ( $groups as $group ) {
			$paths[] = dirname( $group );
		}
	}

	// return
	return $paths;
} );

/**
 * Disable Inner Blocks Wrapping
 */
add_filter( 'acf/blocks/wrap_frontend_innerblocks', function( $wrap, $block_name ) {
	if ( false === strpos( $block_name, 'acf/frmblks-' ) ) {
		return $wrap;
	}

	return false;
}, 10, 2 );
