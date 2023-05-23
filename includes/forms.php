<?php
/**
 * Forms Post Type
 *
 * @package ACFFormBlocks
 */

add_action( 'init', 'acf_form_blocks_form_template' );

/**
 * Set Form Block Template
 */
function acf_form_blocks_form_template() {
	$post_type           = get_post_type_object( 'frmblk-form' );
	$post_type->template = [
		[
			'acf/frmblks-form',
		]
	];
}
