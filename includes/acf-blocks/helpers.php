<?php
/**
 * ACF Block Helper Functions
 *
 * @package ACFFormBlocks
 */

/**
 * Render an ACF block with your chosen properties in place
 * Allows you to use the block within PHP templates
 *
 * @param string $block_name Name of the block.
 * @param array  $props      Block properties array.
 */
function acf_form_blocks_render_acf_block( $block_name, $props = array() ) {
	if ( 'acf/' !== substr( $block_name, 0, 4 ) ) {
		$block_name = 'acf/' . $block_name;
	}

	$block = array_merge(
		array(
			'name' => $block_name,
		),
		$props
	);

	if ( empty( $block['id'] ) ) {
		$block['id'] = uniqid();
	}

	acf_render_block( $block );
}

/**
 * Render the block default attributes.
 *
 * @param array  $block        The block array.
 * @param string $custom_class Extra custom classes.
 */
function acf_form_blocks_acf_block_attr( $block, $custom_class = '' ) {
	echo ' id="';
	acf_form_blocks_acf_block_id( $block );
	echo '" class="';
	acf_form_blocks_acf_block_class( $block, $custom_class );
	echo '"';
}

/**
 * Render the block ID attribute.
 *
 * @param array $block The block array.
 */
function acf_form_blocks_acf_block_id( $block ) {
	$prefix = str_replace( 'acf/', '', $block['name'] );
	$id     = $prefix . '_' . $block['id'];

	if ( ! empty( $block['anchor'] ) ) {
		$id = $block['anchor'];
	}

	echo esc_attr( $id );
}

/**
 * Render the block class attribute.
 *
 * @param array  $block        The block array.
 * @param string $custom_class Extra custom classes.
 */
function acf_form_blocks_acf_block_class( $block, $custom_class = '' ) {
	$class = array_merge(
		array(
			str_replace( 'acf/', '', $block['name'] ),
		),
		explode( ' ', $custom_class )
	);

	if ( ! empty( $block['className'] ) ) {
		$class[] = $block['className'];
	}

	if ( ! empty( $block['align'] ) ) {
		$class[] = 'align' . $block['align'];
	}

	if ( ! empty( $block['align_content'] ) ) {
		$class[] = 'align-content-' . $block['align_content'];
	}

	echo esc_attr( trim( implode( ' ', array_unique( $class ) ) ) );
}

/**
 * Get ACF field property.
 *
 * @param string $selector The ACF field selector.
 * @param string $property The property to return.
 * @param int    $group_id Setting Group ID.
 *
 * @return mixed
 */
function acf_form_blocks_acf_get_field_property( $selector, $property, $group_id = null ) {
	if ( null !== $group_id ) {
		$fields = acf_get_fields( $group_id );
		foreach ( $fields as $field_array ) {
			if ( $selector === $field_array['name'] ) {
				$field = $field_array;
				break;
			}
		}
	} else {
		$field = get_field_object( $selector );
	}

	if ( ! $field || ! is_array( $field ) ) {
		return '';
	}

	if ( empty( $field[ $property ] ) ) {
		return '';
	}

	return $field[ $property ];
}

/**
 * Get a block data value.
 *
 * @param string $field Field name/key.
 * @param array  $block Block array.
 *
 * @return mixed
 */
function acf_form_blocks_acf_get_block_field( $field, $block ) {
	if ( ! isset( $block['data'][ $field ] ) ) {
		return false;
	}

	return $block['data'][ $field ];
}

/**
 * Custom block category
 *
 * @param array                   $categories     Block Categories.
 * @param WP_Block_Editor_Context $editor_content The current block editor context.
 */
add_filter(
	'block_categories_all',

	/**
	 * Add Theme name to block categories.
	 *
	 * @param array  $categories     Block Categories array.
	 * @param string $editor_content Editor Content value.
	 *
	 * @return array
	 */
	function ( $categories, $editor_content ) {
		return array_merge(
			array(
				array(
					'slug'  => 'acf-form-blocks',
					'title' => __( 'Forms', 'acf-form-blocks' ),
				),
			),
			$categories
		);
	},
	10,
	2
);
