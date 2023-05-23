<?php
/**
 * Form Block: Label
 *
 * @package ACFFormBlocks
 */

$allowed = [
	'acf/frmblks-input',
	'acf/frmblks-textarea',
	'core/paragraph',
];
$allowed_blocks = wp_json_encode( $allowed );

// Prevent Pointer issues.
$tag = is_admin() ? 'div' : 'label';
?>
<<?php echo $tag; ?> <?php acf_form_blocks_acf_block_attr( $block ); ?>>
	<InnerBlocks
		template="<?php echo esc_attr( $block_template ); ?>"
		allowedBlocks="<?php echo esc_attr( $allowed_blocks ); ?>"
	/>
</<?php echo $tag; ?>>
