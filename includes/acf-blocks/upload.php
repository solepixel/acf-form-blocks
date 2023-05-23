<?php
/**
 * ACF Block Upload
 *
 * @package ACFFormBlocks
 */

/**
 * Get path to custom uploaded blocks.
 *
 * @return string
 */
function acf_form_blocks_get_custom_blocks_dir() {
	$uploads_dir = wp_upload_dir();
	return $uploads_dir['basedir'] . '/form-blocks';
}

/**
 * Block upload handler.
 *
 * @param array $errors Upload errors.
 *
 * @return array
 */
add_filter(
	'acf/upload_prefilter/name=form_block_upload',
	function ( $errors ) {
		$dir = basename( acf_form_blocks_get_custom_blocks_dir() );

		/**
		 * Modify upload path.
		 *
		 * @param array $uploads Uploads path.
		 *
		 * @return array
		 */
		add_filter( 'upload_dir', function ( $uploads ) {
			$uploads['path']   = $uploads['basedir'] . '/' . $dir;
			$uploads['url']    = $uploads['baseurl'] . '/' . $dir;
			$uploads['subdir'] = '';

			return $uploads;
		} );

		return $errors;
	}
);

/**
 * @param mixed $value    The field value.
 * @param int   $post_id  The Post ID.
 * @param array $field    The ACF field array.
 * @param mixed $original The original value.
 *
 * @return mixed
 */
add_filter(
	'acf/update_value/name=form_block_upload',
	function ( $value, $post_id, $field, $original ) {
		if ( ! $value ) {
			return $value;
		}

		$src = get_attached_file( $value );

		$zip = new ZipArchive;
		$res = $zip->open( $src );

		if ( true === $res ) {

			$zip->extractTo( acf_form_blocks_get_custom_blocks_dir() );
			$zip->close();

			unlink( $src );

			return '';
		}

		return $value;
	},
	10,
	4
);

/**
 * Display custom blocks interface.
 */
add_filter( 'acf/load_field/key=field_63ff76264b05a', function( $field ) {
	if ( ! isset( $field['message'] ) ) {
		return $field;
	}

	$blocks = glob( acf_form_blocks_get_custom_blocks_dir() . '/**/block.json' );

	if ( ! $blocks ) {
		return $field;
	}

	$message = '';
	foreach ( $blocks as $block ) {
		$json     = json_decode( file_get_contents( $block ), true );
		$message .= sprintf( '<div>%s (%s)</div>', $json['title'], $json['name'] );
	}

	$field['message'] = $message;

	return $field;
});
