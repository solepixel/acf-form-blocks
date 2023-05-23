<?php
/**
 * Default JSX Block template.
 *
 * @package ACFFormBlocks
 */

?>
<InnerBlocks
	template="<?php echo esc_attr( $block_template ); ?>"
	allowedBlocks="<?php echo esc_attr( $allowed_blocks ); ?>"
	<?php acf_form_blocks_acf_block_attr( $block ); ?>
/>
