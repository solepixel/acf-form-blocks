<?php
/**
 * Form Block: Textarea
 *
 * @package ACFFormBlocks
 */

$name = get_field( 'name' );
?>
<textarea
	<?php acf_form_blocks_acf_block_attr( $block ); ?>
	name="<?php echo esc_attr( $name ); ?>"
></textarea>
