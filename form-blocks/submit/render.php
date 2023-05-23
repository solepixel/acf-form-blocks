<?php
/**
 * Form Block: Input
 *
 * @package ACFFormBlocks
 */

$label = get_field( 'label' );
?>
<input type="submit"
	<?php acf_form_blocks_acf_block_attr( $block ); ?>
	type="submit"
	value="<?php echo esc_attr( $label ); ?>"
/>
