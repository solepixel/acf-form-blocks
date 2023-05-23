<?php
/**
 * Form Block: Form
 *
 * @package ACFFormBlocks
 */

$action = get_field( 'action' );
$method = get_field( 'method' );
$allowed = [
	'acf/frmblks-label',
	'acf/frmblks-input',
	'acf/frmblks-textarea',
	'acf/frmblks-submit',
	'core/paragraph',
	'core/heading',
	'core/columns',
];
$allowed_blocks = wp_json_encode( $allowed );
?>
<form
	action="<?php echo esc_attr( $action ); ?>"
	method="<?php echo esc_attr( $method ); ?>"
	<?php acf_form_blocks_acf_block_attr( $block ); ?>
>
	<InnerBlocks
		template="<?php echo esc_attr( $block_template ); ?>"
		allowedBlocks="<?php echo esc_attr( $allowed_blocks ); ?>"
	/>
</form>
