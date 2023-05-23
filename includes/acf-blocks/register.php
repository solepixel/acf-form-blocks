<?php
/**
 * ACF Block Registration
 *
 * @package ACFFormBlocks
 */

/**
 * Register ACF Blocks.
 */
add_action( 'acf/init', function() {
	$locations = acf_form_blocks_get_block_locations();

	foreach ( $locations as $location ) {
		$blocks = glob( trailingslashit( $location ) . '**/block.json' );

		foreach ( $blocks as $path ) {
			$include = str_replace( '.json', '.php', $path );

			// Autoload block.php
			if ( file_exists( $include ) ) {
				require $include;
			}

			register_block_type( $path );
		}
	}
} );

/**
 * Get locations where blocks can be found.
 *
 * @return string[]
 */
function acf_form_blocks_get_block_locations() {
	return apply_filters(
		'form_block_locations',
		[
			ACF_FORM_BLOCKS_PATH . '/form-blocks',
			acf_form_blocks_get_custom_blocks_dir(),
		]
	);
}

/**
 * @param string $block_name
 * @param string $return
 *
 * @return string|false
 */
function acf_form_blocks_get_block_location( string $block_name, string $return = 'path' ) {
	$locations  = acf_form_blocks_get_block_locations();
	$block_name = str_replace( 'acf/', '', $block_name );

	foreach ( $locations as $location ) {
		$blocks = glob( trailingslashit( $location ) . '**/block.json' );
		if ( empty( $blocks ) ) {
			continue;
		}

		foreach ( $blocks as $block ) {
			$json = json_decode( file_get_contents( $block ), true );
			if ( $block_name === $json['name'] ) {
				return dirname( $block );
			}
		}
	}

	return false;
}

/**
 * Automatically adds block render callbacks.
 *
 * @param array $metadata Block metadata.
 *
 * @return array
 */
add_filter( 'block_type_metadata', function ( array $metadata ) {
	if ( ! function_exists( 'acf_is_acf_block_json' ) ) {
		return $metadata;
	}

	// Default to Theme category.
	if ( empty( $metadata['category'] ) || 'common' === $metadata['category'] ) {
		$metadata['category'] = 'acf-form-blocks';
	}

	if (
		! acf_is_acf_block_json( $metadata ) ||
		! empty( $metadata['acf']['renderCallback'] ) ||
		! empty( $metadata['acf']['renderTemplate'] ) ||
		empty( $metadata['name'] )
	) {
		return $metadata;
	}

	$metadata['acf']['renderCallback'] = function( array $block ) {
		$name = str_replace( 'acf/', '', $block['name'] );
		$path = acf_form_blocks_get_block_location( $block['name'] ) . '/render.php';

		if ( ! empty( $block['supports']['jsx'] ) && true === $block['supports']['jsx'] ) {
			// Default to basic JSX block template.
			if ( ! file_exists( $path ) ) {
				$path = ACF_FORM_BLOCKS_PATH . '/form-blocks/_jsx.php';
			}

			// Make sure JSX blocks have a block template and allowed blocks.
			$block_template = wp_json_encode(
				[
					[
						'core/paragraph',
						[
							'placeholder' => __( 'Type / to choose a block', 'acf-form-blocks' ),
						],
					],
				]
			);

			$allowed_blocks = wp_json_encode( [] );
		}

		// Check to make sure view file exists.
		if ( ! file_exists( $path ) ) {
			if ( get_current_user() ) {
				printf(
					'<p style="text-align:center;">%s: %s</p>',
					esc_html__( 'Block template missing', 'acf-form-blocks' ),
					$name
				);
			}
			return;
		}

		require $path;
	};

	return $metadata;

}, 5 );
