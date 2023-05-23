<?php
/**
 * Form Block: Input
 *
 * @package ACFFormBlocks
 */

$type = get_field( 'type' );
$name = get_field( 'name' );
?>
<input
	<?php acf_form_blocks_acf_block_attr( $block ); ?>
	type="<?php echo esc_attr( $type ); ?>"
	name="<?php echo esc_attr( $name ); ?>"
/>
